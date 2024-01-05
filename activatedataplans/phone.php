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
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style-speedtalk.css?v=1.9' ?>">

    <style type="text/css">
        body { font-family: 'Roboto', sans-serif; }
        .activated-hero-sec h1 {
            font-family: 'Neuzeit Grotesk', sans-serif !important;
        }
        .activate_button {
            font-family: 'Neuzeit Grotesk', sans-serif !important;
        }
        .activate-device h2 {
            font-family: 'Neuzeit Grotesk', sans-serif !important;
        }
        .activate-device p {
            font-family: 'SF Pro', sans-serif !important;
        }
        .device-number .gray-text {
            font-family: 'SF Pro', sans-serif !important;
        }
        .mission-control-app h3 {
            font-family: 'Roboto', sans-serif !important;
        }
        .mission-control-app h3 + p {
            font-family: 'Roboto', sans-serif !important;
        }
        .device-number + .btn-blue {
            line-height: 1;
            padding: 12px 14px;
        }
        /*@media not all and (min-resolution:.001dpcm) {
          @media {
              button.btn.btn-blue.activate_button{
                padding: 17px 30px 12px 30px !important;
              }
              
            }
        }
        @media not all and (min-resolution:.001dpcm) {
          @media screen and (max-width: 767px) {
              button.btn.btn-blue.activate_button{
                padding: 15px 30px 12px 30px !important;
              }
            }
        }*/
    </style>

      <?php 
       include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'custom-script.php';


    ?>
    
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

     $email=str_replace(" ","+",$_REQUEST['email']);
     $email = PHP_AES_Cipher::decrypt(KEY, $email);
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


         <section class="activated-hero-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="main-head"> Your watch is <br class="d-block d-md-none"/>activated! <img src="<?=IMAGE_PATH. "partynewimg.png"; ?>"/>   </h1>
                        <p class="sub-headenw"> Thank you for joining COSMO! Your JrTrack and COSMO membership are now active. <br class="d-none d-md-block"/>A confirmation email has also been sent with your new phone number. </p>
                      <!-- <p class="smalltxt"><img src="<?=IMAGE_PATH. "info-icon@2x.png"; ?>" alt="info-icon">You may have to restart the watch several times after <br> powering it on the first time to complete all updates.</p> -->

                      <p class="alertbox-thanks"> <img src="<?=IMAGE_PATH. "letter-infoicn.png"; ?>" width="17" class="thnksicn-alert"> You may have to restart the watch several times after  powering it on the first time to establish connection.</p>
                      
                     <div class="device-number">
                         <div class="row p-0">
                        <div class="col-2 col-md-2">
                            <img src="<?=IMAGE_PATH. "email_new.png"; ?>" width="24" />
                        </div>
                        <div class="col-7 col-md-8 align-items-start pl-0">
                            <p class="gray-text text-left"> Email </p>
                            <p class="inpt-val"><?=$email; ?></p>
                        </div>
                        <div class="col-3 col-md-2"></div>
                     </div>
                     <div class="row p-0">
                         <div class="col-2 col-md-2 mt-2">
                            <img src="<?=IMAGE_PATH. "watch_new.png"; ?>" width="24" />
                        </div>
                        <div class="col-7 col-md-8 mt-2 align-items-start pl-0">
                            <p class="gray-text text-left"> JrTrack phone number: </p>
                            <p id="phone_no" class="phone_number inpt-val"><?=$phone_format; ?></p>
                        </div>
                        <div class="col-3 col-md-2 mt-4">
                            <div class="copy_box position-relative">
                                <p style="display: none;" id="copied">Copied</p>
                                <a href="javascript:void(0)" class="copy-txt" onclick="copyToClipboard()">Copy</a>
                            </div>
                        </div>
                     </div>
                     <div class="row p-0">
                        <div class="col-2 col-md-2 mt-2">
                        </div>
                        <div class="col-8 col-md-8 mt-0 align-items-start py-0 pl-0" >
                            <p class="extph-info d-flex align-items-center"><img src="<?=IMAGE_PATH. "stargreynw@2x.png"; ?>" />Copy to add it to your contact list.</p>
                        </div>
                        <div class="col-2 col-md-2 mt-2">
                        </div>
                     </div>
                     </div>
                    </div>
                </div>
            </div>
        </section>

      	<!--hero section start-->
      <!-- 	<section class="activated-hero-sec">
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
            				<h1 class="mt-4"> Device has already been activated! </h1>

                           

                			<div class="row device-number py-2">
                                    
                                   
                                    <div class="col-3 col-md-2">
                                        <img src="<?= IMAGE_PATH.'email_new.png'?>" width="24" />
                                    </div>
                                    <div class="col-6 col-md-8 align-items-start">
                                        <p class="gray-text text-left"> Email </p>
                                        <p id="phone_no"> <?=$email; ?></p>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        
                                    </div>
                                  

                                   
                    			 	<div class="col-3 col-md-2 mt-2">
                    			 		<img src="<?= IMAGE_PATH.'watch_new.png'?>" width="24" />
                    			 	</div>
                    			 	<div class="col-6 col-md-8 mt-2 align-items-start">
                    			 		<p class="gray-text text-left"> Your new number </p>
                    			 		<p id="phone_no"> <?=$phone_format; ?></p>
                    			 	</div>
                    			 	<div class="col-3 col-md-2 mt-2">
                                        <div class="copy_box position-relative">
                                            <p style="display: none;"  id="copied">Copied</p>
                                            <img src="<?= IMAGE_PATH.'copy-frame.png'?>" width="22" /  onclick="copyToClipboard()" style="cursor: pointer;" >
                                        </div>
                    			 	</div>
                               
                                
                			</div>

            				<button class="btn btn-blue d-block mx-auto activate_button" onclick="submitform()" style="cursor:pointer;" > Activate another device </button>
            				 
            			</div>
    	      		</div>
                </div>
      		</div>
      	</section> -->

      	<!--hero section end-->

      	<!--landing activate form start--->
     <!--    <section class="activate-device">
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
                                <p class="d-flex justify-content-center align-items-center w-100 qr_codes">
                                    <a href="https://apps.apple.com/us/app/cosmo-mission-control/id1580600845" target="_blank" class="newqr-img">
                                      <img src="<?= IMAGE_PATH.'app-store.png'?>" width="120" srcset="<?= IMAGE_PATH.'app-store@2x.png 2x'?>, <?= IMAGE_PATH.'app-store@3x.png 3x'?>images/" /> 
                                        <img src="<?= IMAGE_PATH.'app_store_new_qr.png'?>" alt="App Store QR" class="img-fluid d-none d-lg-block">
                                        <img src="<?= IMAGE_PATH.'app_store_btn_new.png'?>" alt="App Store QR" class="img-fluid d-block d-lg-none">
                                    </a>
                                    <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol" target="_blank" class="newqr-img">
                                       <img src="<?= IMAGE_PATH.'play-store.png'?>" width="120" srcset="<?= IMAGE_PATH.'play-store@2x.png 2x'?>, <?= IMAGE_PATH.'play-store@3x.png 3x'?>" /> 
                                        <img src="<?= IMAGE_PATH.'google_play_new_qr.png'?>" alt="Google Play QR" class="img-fluid d-none d-lg-block">
                                        <img src="<?= IMAGE_PATH.'google_play_btn_new.png'?>" alt="Google Play QR" class="img-fluid d-block d-lg-none">
                                    </a>
                                </p>
    						</div>
            		  </div>
            	   </div>
               </div>
            </div>
        </section> -->
      	<!--landing activate form end--->

 <section class="activate-device">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nwapp-in">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="nwdownload-info">
                                        <p>Next step</p>
                                        <h2>Download the app</h2>
                                        <div class="cosmo-infonw d-flex align-items-center">
                                            <div class="inf-img">
                                                <img src="<?=IMAGE_PATH. "cosmobiglogo@2x.png"; ?>" alt="cosmo-logo-image" class="cosmonw-logo img-fluid" />
                                            </div>
                                            <div class="inftxt">
                                                <h3>COSMO: Mission Control</h3>
                                                <p>The app for parental controls</p>
                                            </div>
                                        </div>
                                        <div class="qrscan-sec">
                                           <div class="qrscan-box android">
                                              <img src="<?=IMAGE_PATH. "googleplaynew.png"; ?>" alt="playstore-image" class="playstoreicon storeicn img-fluid">
                                               <img src="<?=IMAGE_PATH. "andriodqr-new.png"; ?>" alt="playstore-image" class="playstore-qrnew qricn img-fluid">
                                           </div>
                                            <div class="qrscan-box ios">
                                                <img src="<?=IMAGE_PATH. "appstornew.png"; ?>" alt="appstore-image" class="appstoreicon storeicn img-fluid">
                                               <img src="<?=IMAGE_PATH. "iosqr-new.png"; ?>" alt="appstore-image" class="appstore-qrnew qricn img-fluid">
                                           </div>
                                        </div>
                                        <div class="mb-btnwrap d-block d-md-none">
                                           <button class="dwnld-btn">Download the COSMO app</button> 
                                        </div>
                                        <p class="dff-dvc">or <a href="javascript:void(0)" onclick="submitform()">activate another device</a></p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none d-md-block">
                                    <div class="appph-wrap">
                                        <img src="<?=IMAGE_PATH. "phoneqropt.png"; ?>"  alt="phone-image" class="appscr-img img-fluid" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

      </main>
    <!--main section end-->
	


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
      $( document ).ready(function() {
        
            if (/Android/i.test(navigator.userAgent)) {
$('.dwnld-btn').attr("onclick","window.location='https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol&hl=en_US&gl=US'");
}
else if(/webOS|iPhone|iPad|iPod/i.test(navigator.userAgent))
{
$('.dwnld-btn').attr("onclick","window.location='https://apps.apple.com/us/app/cosmo-mission-control/id1580600845'");

}

});

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