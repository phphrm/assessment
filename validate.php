<?php
include 'hr_config.php';

$PHPHR = curl_init();
curl_setopt_array($PHPHR, array(
  CURLOPT_URL=>$WebURL.'/index.php/api/exam_code/exam_code/'.$Token_Key,
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

?>
<?php
  

function test_input($data) {
      
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
   
if ($_SERVER["REQUEST_METHOD"]== "POST") 
{ 
    $candidate_email = test_input($_POST["candidate_email"]);
    $password = test_input($_POST["password"]);
    $date = date("m/d/Y");
    $check_credential=0;
	$check_date=0;
	$check_exam_given=0;
    foreach($data1['data']['assessment'] as $user) 
	{   
        if(($user['candidate_email'] == $candidate_email) && ($user['exam_code'] == $password))
				{
					if($user['end_date']>=$date)
					{
						$check_date=1;
					}
					if($user['ended']==0)
					{
						$check_exam_given=1;	
					}
					$check_credential=1;
					$a=$user['candidate_id'];
					$b=$user['category_id'];
					$c=$user['id'];
						
					
				}		
       
    }
	if($check_credential==1 && $check_date==1 && $check_exam_given==1)
	{	session_start();
		$_SESSION["auth"] = "1";
		$_SESSION["candidate_id"]=$a;
		$_SESSION["assessment_id"]=$c;
		header("Location: instruction.php?ID=$b");
		
	}
	
	else if($check_date==0 && $check_credential==1)
	{
		echo "<script>
			alert('Link Expired');
			window.location.href='login.php';
			</script>"; 
	}else if($check_exam_given==0 && $check_credential==1)
	{
		echo "<script>
			alert('Exam Already Given');
			window.location.href='login.php';
			</script>"; 
	}
	else
	{
		echo "<script>
			alert('Username and Passord are incorrect');
			window.location.href='login.php';
			</script>";  
    }    
}
  
?>