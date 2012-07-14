<?php
include_once("config.php");
@include_once("header.inc");



$file_complete = file($data_file);

$gb_count = 0;
$in_entry = 0;
$full_output = "";
$output = "";
$orig_output = "";

$template = file($sign_template);

foreach($template as $myline)
{
  $orig_output .= $myline;
}

if($allow_emoticons == 1)
{
  print("<script language=\"JavaScript\" type=\"text/javascript\">\n");
  print("<!--\n");
  print("  function emoticon(text) {\n");
  print("	var txtarea = document.SimpliGuest.message;\n");
  print("	text = ' ' + text + ' ';\n");
  print("	txtarea.value  += text;\n");
  print("	txtarea.focus();\n");
  print("  }\n");
  print("-->\n");
  print("</script>\n");

  $smiletable = "\n<table style=\"border: 0px\" cellspacing=\"0\">";

  $smilies = explode("|", $emoticons);
  $smilcode = explode("|", $emotcodes);
  $smilshow = explode("|", $emotishow);

  $num_of_smilies = count($smilies);
  $passes = 1;
  $again = 1;

  while($again == 1)
  {
    $smiletable .= "<tr>";
    for($i = (($passes - 1) * 10); $i < $num_of_smilies; $i++)
    {
      if($i < (10 * $passes))
      {
        if($smilshow[$i] == 1)
        {
          $smiletable .= "<td style=\"padding: 5px 5px 5px 5px; \"><a href=\"javascript:emoticon('$smilcode[$i]')\"><img src=\"emoticons/$icontheme/$smilies[$i].gif\" alt=\"$smilcode[$i]\" title=\"$smilcode[$i]\" style=\"border: 0px;\" /></a></td>\n";
        }
        if($i == ($num_of_smilies - 1))
        {
          $again = 0;
        }
        else
        {
          $again = 1;
        }
      }
    }
    $smiletable .= "</tr>";
    $passes = $passes + 1;
  }
  $smiletable .= "</table>";
  $orig_output = str_replace("{emoticons}", $smiletable, $orig_output);
}
else
{
  $orig_output = str_replace("{emoticons}", "&nbsp;", $orig_output);
}

$full_output = $orig_output;
print("$full_output\n");

@include_once("footer.inc");

?>

