<?php
include_once("config.php");
@include_once("header.inc");

$file_complete = file($data_file);
$full_output = "";
$template = file($post_template);
$can_post = 1;
$repost = 0;

function getIP() 
{
  $ip;
  if (getenv("HTTP_CLIENT_IP")) 
    $ip = getenv("HTTP_CLIENT_IP");
  else if(getenv("HTTP_X_FORWARDED_FOR")) 
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  else if(getenv("REMOTE_ADDR")) 
    $ip = getenv("REMOTE_ADDR");
  else 
    $ip = "UNKNOWN";
return $ip;
}

function valid_email($str)
{
  $str = strtolower($str);
if(ereg("^([^[:space:]]+)@(.+)\.(ad|ae|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|cr|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|fi|fj|fk|fm|fo|fr|fx|ga|gb|gov|gd|ge|gf|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nato|nc|ne|net|nf|ng|ni|nl|no|np|nr|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$",$str))
  {
    return 1;
  } 
  else 
  {
    return 0;
  }
}

// Check to make sure they have all the proper fields.  If not? Don't let them post! Duh :P
$fields = explode("|", $custom_fields);
foreach($fields as $cfield)
{
  $required = explode("|", $required_fields);
  foreach($required as $rfield)
  {
    if($cfield == $rfield)
    {
      $tfield = $_POST[$rfield];
      if(empty($tfield))
      {
        echo "<b>A REQUIRED FIELD ($rfield) IS EMPTY!</b><br />";
        $can_post = 0;
      }
      if($validate_email == 1)
      {
        $temp_email = $_POST['email'];
        if(($rfield == "email") && !valid_email($temp_email))
        {
          echo "<b>You have entered an invalid email address ($temp_email).  Please fix this before continueing.</b><br />";
          $can_post = 0;
        }
      }
    }
  }
}

// This little hack makes the searches case-insensitive for the bad word filter.
$badwords = explode("|", $filtered_words);
$goodwords = explode("|", $filtered_replace);

for($curword = 0; $curword < 4; $curword++)
{
  $badwords[$curword] = "/$badwords[$curword]/i";
}

if((strtolower($name) == strtolower($admin_name)) && ($password != $admin_password))
{
  echo "<b>You have entered and invalid password for that user.  Please fix this before continueing.</b><br />";
  $can_post = 0;
}

if($can_post == 1)
{
  $file_complete = file($data_file);

  foreach($file_complete as $entry)
  {
    $entry = trim($entry);
    // Check for the end of an entry
    if($entry == "#ENDENTRY")
    {
      $in_entry = 0;
      $gb_count += 1;
      if($found == 1)
        $repost = 1;
    }

    if($in_entry == 1)
    {
      $pos = strpos($entry, " ");
      if($pos != false)
      {
        $key  = substr($entry, 0, $pos);
        $primkey = substr($key, 3, strlen($key));
        $data = substr($entry, $pos);
        $data = substr($data, 1);
        $newdata = $_POST[$primkey];
        trim($newdata);
        trim($data);
        if((strcmp(strtolower($newdata), strtolower($data)) == 0) && (strcmp($primkey, "timestamp") !== 0) && !empty($data) && !empty($newdata) && ($found < 2))
        {
          $found = 1;
        }
        else if((strcmp($primkey, "timestamp") == 0) || empty($data) || empty($newdata))
        {
        }
        else
        {
          $found = 2;
        }
      }
    }

    // Check for the start of an entry
    if($entry == "#ENTRY")
    { 
      $output = $orig_output;
      $in_entry = 1;
      $found = 0;
    }
  }

  if($repost == 1)
  {
    print("Reposting not allowed.<br />\n");
  }
  else
  {
  foreach($template as $myline)
  {
    $full_output .= $myline;
  }

  $full_output = str_replace("{field_gb_name}", $name, $full_output);

  print("$full_output\n");
  $ip = getIP();

  if(is_writeable($data_file))
  {
    $handle = fopen($data_file, "a");
    if(!$handle)
    {
      print("Cannot open file ($data_file) for append.<br />\n");
    }
    else
    {
      flock($handle, LOCK_EX);
      fwrite($handle, "#ENTRY\n");
      $time = time();
      fwrite($handle, "gb_timestamp $time\n");
      $fields = explode("|", $custom_fields);
      foreach($fields as $field)
      { 
        // Here is the meat and potatos of the writing to the file of this script!

        if($field != "timestamp")
        {
          // First step, get rid of ANY html we don't allow!
          $temp_storage = strip_tags($_POST[$field],$allowed_html);

          // Trim off any extra spaces, cr/lf, etc...
          $temp_storage = trim($temp_storage);

          $temp_storage = str_replace("\\\"", "&quot;", $temp_storage);
          $temp_storage = str_replace("\\'", "&#039;", $temp_storage);
          $temp_storage = str_replace("&nbsp;", "", $temp_storage);
          $temp_storage = str_replace("<", "&lt;", $temp_storage);
          $temp_storage = str_replace(">", "&gt;", $temp_storage);
          $temp_storage = str_replace("\n", "<br />", $temp_storage);
          $temp_storage = str_replace("\r", "", $temp_storage);

          // Time to check for bad words.... and replace if found.
          ksort($badwords);
          ksort($goodwords);
          $temp_storage = preg_replace($badwords, $goodwords, $temp_storage);

          // WRITE IT!
          fwrite($handle, "gb_$field $temp_storage\n");
        }
      }
      fwrite($handle, "gb_loggedip $ip\n");
      fwrite($handle, "gb_admincomment \n");
      fwrite($handle, "#ENDENTRY\n\n");
      flock($handle, LOCK_UN);
      fclose($handle);
    }
  }
  else
  {
    print("The file ($data_file) is not writeable.<br />\n");
  }
  }
}
else
{
  print("You are missing some required fields, please fix those before posting.\n");
}

@include_once("footer.inc");
?>

