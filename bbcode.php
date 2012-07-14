<?php

function bbcode_decode($messageStr) {
//    $messageStr = strip_tags($messageStr);

    // Bold
    $messageStr = eregi_replace("\\[b]([^\\[]*)\\[/b\\]","<b>\\1</b>",$messageStr);

    // Italic
    $messageStr = eregi_replace("\\[i]([^\\[]*)\\[/i\\]","<i>\\1</i>",$messageStr);

    // Underline
    $messageStr = eregi_replace("\\[u]([^\\[]*)\\[/u\\]","<u>\\1</u>",$messageStr);

    // Code
    $messageStr = eregi_replace("\\[code]([^\\[]*)\\[/code\\]","<code>\\1</code>",$messageStr);

    // URL
    $messageStr = eregi_replace("\\[url]http://([^\\[]*)\\[/url\\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$messageStr);
    $messageStr = eregi_replace("\\[url]([^\\[]*)\\[/url\\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$messageStr);
    $messageStr = eregi_replace("\\[url=http://([^\\[]*)\\]([^\\[]*)\\[/url\\]","<a href=\"http://\\1\" target=\"_blank\">\\2</a>",$messageStr);
    $messageStr = eregi_replace("\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]","<a href=\"http://\\1\" target=\"_blank\">\\2</a>",$messageStr);

    // Email
    $messageStr = eregi_replace("\\[email=([^\\[]*)\\]([^\\[]*)\\[/email\\]","<a href=\"mailto:\\1\">\\2</a>",$messageStr);

    // Images
    $messageStr = eregi_replace("\\[img]([^\\[]*)\\[/img\\]","<img src=\"\\1\" border=0>",$messageStr);

    // Quote
    $messageStr = eregi_replace("quote\\]","quote]",$messageStr);  // make lower case
    $messageStr = eregi_replace("\[quote\]\r\n", '<blockquote><smallfont>Quote:</smallfont><hr>', $messageStr); 
    $messageStr = eregi_replace("\[quote\]", '<blockquote><smallfont>Quote:</smallfont><hr>', $messageStr); 
    $messageStr = eregi_replace("\[/quote\]\r\n", '<hr></blockquote>', $messageStr); 
    $messageStr = eregi_replace("\[/quote\]", '<hr></blockquote>', $messageStr); 

    return nl2br($messageStr);
}

// The following function is not used currently, however, it may be used in future version of peoGuest, 
// so I recommend you keep them both up to date, as then you could simply keep this file to preserve your 
// custom BBCode.

function bbcode_encode($messageStr) {
    // Bold
    $messageStr = eregi_replace("\<b\>", '[b]', $messageStr);
    $messageStr = eregi_replace("\</b\>", '[/b]', $messageStr);

    // Italic
    $messageStr = eregi_replace("\<i\>", '[i]', $messageStr);
    $messageStr = eregi_replace("\</i\>", '[/i]', $messageStr);
    
    // Underline
    $messageStr = eregi_replace("\<u\>", '[u]', $messageStr);
    $messageStr = eregi_replace("\</u\>", '[/u]', $messageStr);

    // Code
    $messageStr = eregi_replace("\<code\>", '[code]', $messageStr);
    $messageStr = eregi_replace("\</code\>", '[/code]', $messageStr);

    // Url
    $messageStr = eregi_replace("\\<a href=\"([^\\[\"]*)\"\\ target=\"_blank\">([^<\[]*)</a>","[url=\\1]\\2[/url]", $messageStr);
  
    // Mailto
    $messageStr = eregi_replace("\\<a href=\"mailto:([^\\[]*)\"\\>([^<\[]*)</a>","[email=\\1]\\2[/email]",$messageStr);

    // Image
    $messageStr = eregi_replace("\\<img src=\"([^\\[]*)\"\\ border=0>([^<\[]*)","[img]\\1[/img]",$messageStr);

    // Quote
    $messageStr = eregi_replace("\<blockquote><smallfont>Quote:</smallfont><hr>", '[quote]', $messageStr);
    $messageStr = eregi_replace("\<hr></blockquote>", '[/quote]', $messageStr);
    $messageStr = eregi_replace("\<hr></blockquote>", '[/quote]', $messageStr);

    // BR
    $messageStr = eregi_replace("\<br />\n", '/n', $messageStr);

    // BR
    $messageStr = eregi_replace("\<br>", '/n', $messageStr);
    return $messageStr;
}


?>

