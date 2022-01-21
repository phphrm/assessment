<?php
session_start();
if($_SESSION["auth"]==1){
include 'hr_config.php';

$post_data=$_POST;

$PHPHR = curl_init();
curl_setopt_array($PHPHR, array(
  CURLOPT_URL=>$WebURL.'/index.php/api/assessment/add_result/'.$Token_Key,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => http_build_query($post_data),
));

$response = curl_exec($PHPHR);
curl_close($PHPHR);
header("Location:thanks.php");
exit();
?>
<?php }
else
{
		session_unset();
	session_destroy();
	header("Location: login.php", true, 301);
	exit();
}
?>
