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
<?php
$ID=$_REQUEST['ID'];
?>




<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Instruction</title>
	</head>

	<body onload="disableSubmit()">
		<div class="container"> 
			<?php
                foreach($data1['data']['assess_category'] as $row){
				if($row['id']==$ID)
						$category_name= $row['name'];
				}
			?>
		   
			
			<form action="assessment.php?ID=<?php echo $ID?>" method="post">
				<center><h1><?php echo $category_name; ?></h1></center>
				<p>1. All questions are compulsory.</p>
				<p>2. Try to submit the paper in 20 minutes.</p>
				<p>3. You are allowed to submit only once, make sure that you have correctly attempted all the questions before submission.</p>
				<p>4. Make sure you clicked on submit button to successfully complete the test.</p>
				<input type="checkbox" name="terms" id="terms" onchange="activateButton(this)">I Agree Terms & Coditions
				<br><br>
				<input type="submit" name="submit" id="submit">	
				
			</form>
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

<script>
 function disableSubmit() {
  document.getElementById("submit").disabled = true;
 }

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("submit").disabled = false;
       }
       else  {
        document.getElementById("submit").disabled = true;
      }

  }
</script>