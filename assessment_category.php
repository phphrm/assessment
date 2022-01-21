<?php
include 'hr_config.php';

$PHPHR = curl_init();
curl_setopt_array($PHPHR, array(
  CURLOPT_URL=>$WebURL.'/index.php/api/assess_category/assess_category/'.$Token_Key,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($PHPHR);
$data1 = json_decode($response,true);
session_start();
if($_SESSION["auth"]==1){
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assessment Category</title>
</head>
<body>
<center>
<?php // print_r( $response); ?><br><br>
<?php //print_r ($data1); ?>
<div class="container">    
	<h1>Select Assessment Category</h1>
    <?=$msg;?>
	<center>
    <table class="styled-table">
    <thead>
        <tr>
           <th>Id</th>
                <th>Assessment</th>
                
				
                <th>Apply Here</th>
        </tr>
    </thead>
    <tbody>
         <?php
                foreach($data1['data']['assess_category'] as $row){?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>       
                
					 
					<td><a href="assessment_fetch.php?ID=<?php echo $row['id']; ?>"   target="_blank">Click Here!</a></td>
				
                <tr>
				
            <?}?>
    </tbody>
</table>

	</center>
	</div>
</body>
</html>
<?php }
else
{
		session_unset();
	session_destroy();
	header("Location: login.php", true, 301);
	exit();
}
?>
