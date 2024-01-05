<?php
@session_start();
@ob_start();
//print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
use Application\Database;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<title>Device Activated</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= IMAGE_PATH.'favicon.png' ?>">
	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style-speedtalk.css?v=1.1' ?>">
</head>
<body>
<?php 


$user_exists=0;
if(!isset($_SESSION['phone_details']))
{
    header('location: index.php');
}
else
{
     $phone=str_replace(" ","+",$_REQUEST['pn']);

     $phone = PHP_AES_Cipher::decrypt(KEY, $phone);
    // echo $phone;
     $phn1=substr($phone,0,3);
     $phn2=substr($phone,3,3);
     $phn3=substr($phone,6,4);
     $phone_format= "+1 (".$phn1.") ".$phn2."-".$phn3;
     unset($_SESSION['phone_details']);
}

if(isset($_GET['uid']))
{
    //echo $_GET['uid'];
    $uid=str_replace(" ","+",$_REQUEST['uid']);

    $uid = PHP_AES_Cipher::decrypt(KEY, $uid);

   $db=new Database();
    $user_arr=array();
    $user_arr['table']=USERTABLE;
    $user_arr['selector']="count(id) as count";
    $user_arr['condition']="where id='".$uid."'";

    $getUserDtls=$db->Select($user_arr);
    //print_r($getUserDtls);
    if($getUserDtls[0]['count']>0)
    {
        $user_exists=1;
    }

}

//echo $user_exists;


?>
    <!--main section start-->
      <main>

      	 <form method="post" id="form" action="scan.php">
            <input type="hidden" name="uid" id="uid" value="<?=md5($uid);?>">
        </form>


      	<!--hero section start-->
      	<section class="activated-hero-sec">
      		<div class="container">
                <div class="activated_device_cont">
          			<div class="row">
    	      			<div class="col-md-5 col-5">
    	      				<div class="hero-logo-wrap text-left">
    	      					<img src="<?= IMAGE_PATH.'logo-white@2x.png'?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x'?>, <?= IMAGE_PATH.'logo-white@3x.png 3x'?>" alt="white-logo" class="img-fluid hero-logo">
    	      				</div>
    	      			</div>
    	      			<div class="col-md-7 col-7"></div>
    	      			<div class="col-md-12">
            				<h1> Device has already been activated! </h1>

                			<div class="row device-number">
                			 	<div class="col-3">
                			 		<img src="<?= IMAGE_PATH.'watch-1.png'?>" width="34" />
                			 	</div>
                			 	<div class="col-6">
                			 		<p class="gray-text"> Your new number </p>
                			 		<p id="phone_no"> <?=$phone_format; ?></p>
                			 	</div>
                			 	<div class="col-3">
                                    <div class="copy_box position-relative">
                                        <p style="display: none;"  id="copied">Copied</p>
                                        <img src="<?= IMAGE_PATH.'copy-frame.png'?>" width="24" /  onclick="copyToClipboard()" style="cursor: pointer;" >
                                        
                                    </div>
                			 	</div>
                			</div>

            				<button class="btn btn-blue d-block mx-auto activate_button" onclick="submitform()" style="cursor:pointer;" > Activate another device </button>
            				 
            			</div>
    	      		</div>
                </div>
      		</div>
      	</section>
      	<!--hero section end-->

      	<!--landing activate form start--->
        <section class="activate-device">
        	<div class="container">
                <div class="activated_device_cont">
            		<div class="row">
            			<div class="col-md-12">
            		 		<h2> Download the app </h2>
            		 		<p> Download the COSMO: Mission Control parental controls app to set up your watch. </p>
            		 		<div class="mission-control-app">
                                <p class="my-4"> <img src="<?= IMAGE_PATH.'cosmo-icon-blue.png'?>" srcset="<?= IMAGE_PATH.'cosmo-icon-blue@2x.png 2x'?>, <?= IMAGE_PATH.'cosmo-icon-blue@3x.png 3x'?>" alt="cosmo-icon-blue" /></p>
                                <h3> COSMO: Mission Control </h3>
                                <p class="mb-5"> The app for parental controls </p>
                                <p class="d-flex justify-content-around align-items-center w-100">
                                    <a href="https://apps.apple.com/us/app/cosmo-mission-control/id1580600845" target="_blank" class="newqr-img">
                                        <!-- <img src="<?= IMAGE_PATH.'app-store.png'?>" width="120" srcset="<?= IMAGE_PATH.'app-store@2x.png 2x'?>, <?= IMAGE_PATH.'app-store@3x.png 3x'?>images/" /> -->
                                        <img src="<?= IMAGE_PATH.'app-new-iconqr.png'?>" alt="">
                                    </a>
                                    <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol" target="_blank" class="newqr-img">
                                        <!-- <img src="<?= IMAGE_PATH.'play-store.png'?>" width="120" srcset="<?= IMAGE_PATH.'play-store@2x.png 2x'?>, <?= IMAGE_PATH.'play-store@3x.png 3x'?>" /> -->
                                        <img src="<?= IMAGE_PATH.'play-new-iconqr.png'?>" alt="">
                                    </a>
                                </p>
    						</div>
            		  </div>
            	   </div>
               </div>
            </div>
        </section>
      	<!--landing activate form end--->

      </main>
    <!--main section end-->
	


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    

    function submitform()
    {

        var user_exists='<?=$user_exists;?>';
        if(user_exists==1)
        {
            $("#form").submit();
        }
        else
        {
            window.location.href='index.php';
        }
        
    }

      function copyToClipboard() {
    
       $("#copied").show();
        setTimeout(function() {
        $("#copied").hide()
    }, 2000);


	    var phone_no=$("#phone_no").text();
	   // alert(phone_no);
	    var phone_no_trimmed = $.trim(phone_no);
	    // alert(phone_no_trimmed);


    navigator.clipboard.writeText(phone_no_trimmed).then(() => {
        // Alert the user that the action took place.
        // Nobody likes hidden stuff being done under the hood!
        //  alert("Copied to clipboard");
        //$("#open_fb").focus();
                                             
                                                 
    });
  }
  


</script>



</body>
</html>