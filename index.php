<?php
session_start();
include_once("config.php");
include_once("bbcode.php");
@include_once("header.inc");
$file_complete = file($data_file);

function admin_logged_in()
{
  return 1;
}

$gb_count = 0;
$in_entry = 0;
$full_output = "";
$output = "";
$orig_output = "";

if(empty($start))
{
  $start = 0;
}

$template = file($view_template);

foreach($template as $myline)
{
  $orig_output .= $myline;
}

$total_entries = 0;

foreach($file_complete as $entry)
{
  $entry = trim($entry);
  if($entry == "#ENDENTRY")
  {
    $total_entries = $total_entries + 1;
  }
}

if($total_entries > $entries_per_page)
{
  if($newest_first == 1)
  {
    $start = $total_entries - $entries_per_page - $start;
  }
}

foreach($file_complete as $entry)
{
  $entry = trim($entry);
  // Check for the end of an entry
  if($entry == "#ENDENTRY")
  {
    $in_entry = 0;
    $gb_count += 1;
    if(($gb_count <= ($entries_per_page + $start)) && ($gb_count > $start))
    {
      if($newest_first == 1)
      {
        $full_output = $output . $full_output;
      }
      else
      {
        $full_output .= $output;
      }
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
        $output = str_replace("{field_gb_timestamp}", date($date_format,$data), $output);
      }
      else
      {
        if($key == "gb_message")
          $data = bbcode_decode($data);

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
  $smilies = explode("|", $emoticons);
  $smilcode = explode("|", $emotcodes);
  if((count($smilies) > 0) && ($allow_emoticons == 1))
  {
    for($curr = 0; $curr < count($smilies); $curr++)
    {
      $full_output = str_replace("$smilcode[$curr]", "<img src=\"emoticons/$icontheme/$smilies[$curr].gif\" alt=\"$smilcode[$curr]\" />", $full_output);
    }
  }
  
  // Get rid of excess elements
  $fields = explode("|", $custom_fields);
  foreach($fields as $field)
  {
    $full_output = str_replace("{field_gb_$field}", "&nbsp;", $full_output);
  }

  $full_output = eregi_replace("{field_gb_([^<\[]*)}","",$full_output);

  $full_output .= "<div style=\"text-align: center;\"><sub>Powered by <a href=\"http://www.peoii.com/\">SimpliGuest</a> $app_version</sub></div>\n";

  print("$full_output\n");

  $template = file($page_template);

  $orig_output = "";

  foreach($template as $myline)
  {
    $orig_output .= $myline;
  }

  $page_output = "";

  if($total_entries > $entries_per_page)
  {
    $i = 1;
    for($pages = 0; $pages < $total_entries; $pages += $entries_per_page)
    {
      $page = $pages + 1;
      $page_output .= "[<a href=\"$PHP_SELF?start=$pages\">$i</a>] ";
      $i ++;
    }
    $orig_output = str_replace("{pages}", $page_output, $orig_output);
    print("$orig_output\n");
  }

}
@include_once("footer.inc");

?>

