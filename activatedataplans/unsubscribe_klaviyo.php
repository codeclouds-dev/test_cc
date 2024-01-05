<?php



include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';



include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';

use Application\KlaviyoApi;



$klaviyo_api=new KlaviyoApi();

$message="";
$email_get=str_replace(" ","+",$_REQUEST['p']);
$email_get = PHP_AES_Cipher::decrypt(KEY, $email_get);


   $em   = explode("@",$email_get);
   $email_text=$em[0];
   $email_domain=$em[1];
//             echo $email_text[0];      
//           echo  strlen($email_text);                       
// echo $email_text[strlen($email_text)-1];

$hidden_mail=$email_text[0].str_repeat('*', strlen($email_text)-2).$email_text[strlen($email_text)-1].'@'.$email_domain[0].str_repeat('*', strlen($email_domain)-2).$email_domain[strlen($email_domain)-1];         
 if(isset($_POST['unsubscribe']))

 {

 

 	$email=str_replace(" ","+",$_REQUEST['p']);
 	$email = PHP_AES_Cipher::decrypt(KEY, $email);



 	$unsubscribe_arr=array();

	$unsubscribe_arr['data']=array("type"=>"profile-unsubscription-bulk-create-job","attributes"=>array("emails"=>array($email)));







	$res=$klaviyo_api->unsubscribeList($unsubscribe_arr);

	if($res=="")

	{

		$message="You have been successfully subscribed";

	}

 }

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<title>Opt-Out</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: 'Poppins', sans-serif;
		}
		main {
			display: flex;
			justify-content: center;
			flex-direction: column;
			max-width: 100%;
			height: auto;
			text-align: center;
			padding: 1rem;
		}
		p {
			color: #000;
			line-height: 1.3;
		}
		p.txt1 {
			color: #004feb;
			font-weight: 700;
			font-size: 2rem;
		}
		p.txt2 {
			font-size: 1rem;
		}
		p.txt3 {
			color: #d64030;
			font-weight: 700;
			font-size: 1.5rem;
		}
		p.txt4 {
			font-size: 0.875rem;
			font-weight: 500;
		}
		button, input[type="submit"] {
			background: #004feb;
			color: #fff;
			border: transparent;
			border-radius: 5px;
			font-size: 14px;
			line-height: 1;
			font-family: 'Poppins', sans-serif;
			padding: 0.875rem 2.75rem;
			text-align: center;
			cursor: pointer;
			transition: all 0.2s linear;
			-webkit-transition: all 0.2s linear;
			-ms-transition: all 0.2s linear;
			-moz-transition: all 0.2s linear;
		}
		button:hover, button:focus, input[type="submit"]:hover, input[type="submit"]:focus {
			background: #0a3c9b;
		}
		p.msg_txt {
			color: #fff;
		    background: #42b542;
		    padding: 0.5rem 1rem;
		    border: transparent;
		    border-radius: 0.25rem;
		    font-size: 1rem;
		    line-height: 1;
		    width: fit-content;
		    display: block;
		    margin-left: auto;
		    margin-right: auto;
		}
	</style>
</head>
<body>
	<main>
		<p class="txt1">COSMO DataPlans</p>
		<p class="txt2"><?=$hidden_mail;?></p>
		
		

		<?php if(isset($_POST['unsubscribe']) and $message!=""){?>

		<!-- <p class="msg_txt"><?=$message;?></p> -->
		<p class="txt3">Opt Out Successful!</p>
		<p class="txt4">You'll no longer receive the following type of email communication from this sender.</p>
		<?php 
		}
		else 
		{

		?>
		<p class="txt2">Please click on the below button to Unsubscribe.</p>
		<form method="post">
			<input type="submit" name="unsubscribe" value="Unsubscribe">
		</form>

		<?php

		} ?>

		
	</main>
</body>
</html>