Thank you {field_gb_name}!  Please <a href="index.php">click here</a> to view the guestbook.
<?php 
function getIP() {
$ip;
if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR");
else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR");
else $ip = "UNKNOWN";
return $ip;
}
$ip = getIP(); 
print("$ip");
?>
