<?php
session_start();
include_once("config.php");
@include_once("header.inc");
include_once("bbcode.php");
$file_complete = file($data_file);

function admin_logged_in()
{
  return $_SESSION["admin_logged_in"];
}

if(!isset($func))
{ 
  if(admin_logged_in())
  {
    $func = 1;
  }
  else
  {
    $func = 0;
  }
}

$gb_count = 0;
$in_entry = 0;
$full_output = "";
$output = "";
$orig_output = "";

if($func == 3)
{
  if(($_POST["adminname"] == $admin_name) && ($_POST["adminpassword"] == $admin_password))
  {
    $_SESSION["admin_logged_in"] = 1;
    print("Logged in, <a href=\"admin.php\">click here</a> to continue.");
  }
}
else if(!admin_logged_in())
{
  print("<b>Admin Login:</b><br />");
  print("<form name=\"adminform\" action=\"admin.php\" method=\"POST\">\n");
  print("<input type=\"hidden\" name=\"func\" value=\"3\" />\n");
  print("Name: <input type=\"text\" name=\"adminname\" /><br />\n");
  print("Password: <input type=\"password\" name=\"adminpassword\" /><br />\n");
  print("&nbsp;<input type=\"submit\" name=\"Login\" value=\"Login\" />\n");
  print("</form>\n");
}
if($func == 4)
{
  session_destroy();
  print("Logged out.\n");
}
else if($func == 1)
{
  print("<form name=\"adminform\" action=\"admin.php\" method=\"POST\">\n");
  print(" Pick the entry you wish to edit:\n");
  print("<input type=\"hidden\" name=\"func\" value=\"2\" />");
  print("<select name=\"editid\">");

  foreach($file_complete as $entry)
  {
    $entry = trim($entry);
    if($entry == " ")
    {
      $entry = "";
    }
    // Check for the end of an entry
    if($entry == "#ENDENTRY")
    {
      $in_entry = 0;
      $gb_count += 1;
      $output .= "</option>\n";
      echo $output;

      if($newest_first == 1)
      {
        $full_output = $output . $full_output;
      }
      else
      {
        $full_output .= $output;
      }
    }

    if($in_entry == 1)
    {
      $pos = strpos($entry, " ");
      if($pos != false)
      {
        $key  = substr($entry, 0, $pos);
        $data = substr($entry, $pos);
        if($key == "gb_timestamp")
        {
          $output .= $data." - ";
        }
        else if($key == "gb_name")
        {
          $output .= $data;
        }
      }
    }

    // Check for the start of an entry
    if($entry == "#ENTRY")
    {
      $output = "<option>";
      $in_entry = 1;
    }
  }
  print("</select>");
  print("&nbsp;<input type=\"submit\" name=\"Go\" value=\"Go\" />");
  print("</form>");
}
else if($func == 2)
{
  $myval = explode(" ", $editid);
  $toedit = $myval[0];
  $dooutput = 0;

  $template = file($admin_template);

  foreach($template as $myline)
  {
    $orig_output .= $myline;
  }

  foreach($file_complete as $entry)
  {
    $entry = trim($entry);
    // Check for the end of an entry
    if($entry == "#ENDENTRY")
    {
      $in_entry = 0;
      $gb_count += 1;

      if($dooutput == 1)
      {
        $full_output .= $output;
        $dooutput = 0;
      }
    }

    if($in_entry == 1)
    {
      $pos = strpos($entry, " ");
      if($pos != false)
      {
        $key  = substr($entry, 0, $pos);
        $data = substr($entry, $pos);
        if($key == "gb_timestamp")
        {
          if($data == $toedit)
          {
            $dooutput = 1;
            $data = trim($data);
            $output = str_replace("{field_gb_timestamp}", "$data", $output);
          }
        }
        else
        {
          $data = trim($data);

	  $icons = explode("|", $icon_field);
          for($i = 0; $i < count($icons); $i++)
          {
            if(($key == "gb_".$icons[$i]) && !empty($data))
              $output = str_replace("{field_gb_icon_$icons[$i]}", "<img src=\"images/$icons[$i].gif\" alt=\"$data\" title=\"$data\" style=\"border: 0px;\" />", $output);
          }

          $output = str_replace("{field_$key}", $data, $output);
        }
      }
    }

    // Check for the start of an entry
    if($entry == "#ENTRY")
    {
      $output = $orig_output;
      $in_entry = 1;
    }
  }

  print("$gb_max_element<br />\n");

  if($gb_count == 0)
  {
    print("<b>The Guestbook is Empty</b><br />\n");
  }
  else
  {
    // Get rid of excess elements
    $fields = explode("|", $custom_fields);
    foreach($fields as $field)
    {
      $full_output = str_replace("{field_gb_$field}", "", $full_output);
    }

    $full_output = eregi_replace("{field_gb_([^<\[]*)}","",$full_output);

    $full_output .= "<div style=\"text-align: center;\"><sub>Powered by <a href=\"http://www.peoii.com/\">SimpliGuest</a> $app_version </sub></div>\n";

    print("$full_output\n");

    $template = file($page_template);

    $orig_output = "";

    foreach($template as $myline)
    {
      $orig_output .= $myline;
    }

    $page_output = "";
  }
}
else if($func == 5)
{
  $file_data = file($data_file);

  $file_info = "";

  foreach($file_data as $line)
  {
    $file_info .= $line;
  }

  $file_complete = explode("\n", $file_info);

  $in_modified = 0;
  $mod_written = 0;
  if(is_writeable($data_file))
  {
    $handle     = fopen($data_file, "w");
    flock($handle, LOCK_EX);
    
    foreach($file_complete as $entry)
    {
      $data = explode(" ", $entry);
      $data[0] = trim($data[0]);
      $data[1] = trim($data[1]);
      $timestamp = trim($timestamp);
      if(($data[0] == "gb_timestamp") && ($data[1] == $timestamp))
      {
        $in_modified = 1;
      }
      if($data[0] == "#ENTRY")
      {
        $in_modified = 0;
      }

      if($in_modified == 0)
      {
        fwrite($handle, $entry);
        fwrite($handle, "\n");
      }
      else if($_POST["deleteentry"] == 1)
      {
      }
      else if($mod_written == 0)
      { 
        $fields = array_keys($HTTP_POST_VARS);
        $values = array_values($HTTP_POST_VARS);
  
        for($i = 0; $i < count($fields); $i++)
        { 
          if(($fields[$i] != "deleteentry") && ($fields[$i] != "func") && ($fields[$i] != "save"))
          {
            $temp_storage = "gb_".$fields[$i]." ".$values[$i]."";
  
            $temp_storage = str_replace("\\\"", "&quot;", $temp_storage);
            $temp_storage = str_replace("\\'", "&#039;", $temp_storage);
            $temp_storage = str_replace("&nbsp;", "", $temp_storage);
            $temp_storage = str_replace("\n", "<br />", $temp_storage);
            $temp_storage = str_replace("\r", "", $temp_storage);
            $temp_storage .= "\n";

            fwrite($handle, $temp_storage);
          }
        }
        fwrite($handle, "#ENDENTRY\n\n");
        $mod_written = 1;
      }
    }

    flock($handle, LOCK_UN);
    fclose($handle);
  }
  print("Entry successfully edited.<br />");
}
if(($func == 1) || ($func == 2) || ($func == 5))
  print("<br />[ <a href=\"admin.php?func=4\">Logout</a> ]<br />");
@include_once("footer.inc");

?>

