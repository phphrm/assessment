<?php
include 'hr_config.php';


$PHPHR = curl_init();
curl_setopt_array($PHPHR, array(
  CURLOPT_URL=>$WebURL.'/index.php/api/assessment/assessment/'.$Token_Key,
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
		<title>Assessment</title>
	</head>

	<body onload="f1()" >
	<div class="container"> 
	<center>
		<div>
			<div id="starttime"></div>
			<div id="endtime"></div>
			<div id="showtime"></div>
		</div>
	</center>	
		   
			
			<form action="submit_phphr.php" method="post"> 
				<table class="styled-table">
					<tbody>						
						<?php
							$i=1;
							foreach($data1['data']['assessment'] as $row){ if($row['category']==$ID) 
							{
						?>
							<h4><b><?php echo $i; ?>. </b><?php echo $row['question']; ?></h4>
								<input type="radio" id="option1" name="answer[<?php echo $row['id']; ?>]" value="<?php echo $row['option1']; ?>">
								<label for="option1"><?php echo $row['option1']; ?></label><br>
								
								<input type="radio" id="option2" name="answer[<?php echo $row['id']; ?>]" value="<?php echo $row['option2']; ?>">
								<label for="option2"><?php echo $row['option2']; ?></label><br>
								
								<input type="radio" id="option3" name="answer[<?php echo $row['id']; ?>]" value="<?php echo $row['option3']; ?>">
								<label for="option3"><?php echo $row['option3']; ?></label><br>
								
								<input type="radio" id="option4" name="answer[<?php echo $row['id']; ?>]" value="<?php echo $row['option4']; ?>">
								<label for="option4"><?php echo $row['option4']; ?></label>
								
						<?php $i++; ?>
						<?php }} ?>
					</tbody>
				</table>
				<input type="hidden" name="category_id" value="<?php echo $ID; ?>">
				<input type="hidden" name="ended" value="1">
				<input type="hidden" name="candidate_id" value="<?php echo $_SESSION["candidate_id"];?>">
				<input type="hidden" name="assessment_id" value="<?php echo $_SESSION["assessment_id"];?>">
				<center><input type="submit" value="Submit"></center>
				
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
        var tim;
       
        var min = 19;
        var sec = 60;
        var f = new Date();
        function f1() {
            f2();
            document.getElementById("starttime").innerHTML = "You started your Exam at " + f.getHours() + ":" + f.getMinutes();
             
          
        }
        function f2() {
            if (parseInt(sec) > 0) {
                sec = parseInt(sec) - 1;
                document.getElementById("showtime").innerHTML = "Your Left Time  is :"+min+" Minutes ," + sec+" Seconds";
                tim = setTimeout("f2()", 1000);
            }
            else {
                if (parseInt(sec) == 0) {
                    min = parseInt(min) - 1;
                    if (parseInt(min) == -1) {
                        clearTimeout(tim);
                        location.href = "submit_phphr.php";
                    }
                    else {
                        sec = 60;
                        document.getElementById("showtime").innerHTML = "Your Left Time  is :" + min + " Minutes ," + sec + " Seconds";
                        tim = setTimeout("f2()", 1000);
                    }
                }
               
            }
        }
</script>