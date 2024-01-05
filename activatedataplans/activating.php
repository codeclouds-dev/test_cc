<?php 
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
use Application\RechargeApi;
$recharge_api=new RechargeApi();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="theme-color" content="#0A3C9B">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <title>Activating</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=IMAGE_PATH."favicon.png"; ?>">
        <!--google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
        <!--font-awesome cdn--->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."bootstrap.min.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."main-style.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."style-speedtalk.css?v=1.8"; ?>">

        <style type="text/css">

            .error_popup .error_popup_box .try_btn {
                 font-family: 'Neuzeit Grotesk', sans-serif !important;
            }
            .activated-hero-sec h1 {
                font-family: 'Neuzeit Grotesk', sans-serif !important;
            }
            .activated-hero-sec h1 + p {
                font-family: 'SF Pro', sans-serif !important;
            }
            .device-number .gray-text {
                font-family: 'SF Pro', sans-serif !important;
            }
            .activate_button {
                font-family: 'Neuzeit Grotesk', sans-serif !important;
            }
            /*@media not all and (min-resolution:.001dpcm) {
              @media {
                  .error_popup .error_popup_box .try_btn{
                    padding: 17px 30px 12px 30px !important;
                  }
                  
                }
            }
            @media not all and (min-resolution:.001dpcm) {
              @media screen and (max-width: 767px) {
                  .error_popup .error_popup_box .try_btn{
                    padding: 13px 30px 12px 30px !important;
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
            if(isset($_GET['charge_id']) and $_GET['charge_id']!="" and isset($_GET['email']) and $_GET['email']!="" )
            {
                 // $charge_id=$_GET['charge_id'];
                 // $email=$_GET['email'];
                  $charge_id=$_GET['charge_id'];
                 $order_dtl=$recharge_api->getOrder($_GET['charge_id']);
                 $email=$order_dtl['orders'][0]['email'];

            }
            else
            {
                ?>
                <p>Something Went Wrong</p>
                <?php
                exit();

            }



        ?>
        <!--main section start-->
        <main>
            <!--new activate section start ---->
        <section class="activated-hero-sec" id="activated_block" style="display:none;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="main-head"> Your watch is activated! <img src="<?=IMAGE_PATH. "partynewimg.png"; ?>"/>   </h1>
                        <p class="sub-headenw"> Thank you for joining COSMO! Your JrTrack and COSMO membership are now active. <br class="d-none d-md-block"/>A confirmation email has also been sent with your new phone number. </p>
                        <p class="smalltxt"><img src="<?=IMAGE_PATH. "info-icon@2x.png"; ?>" alt="info-icon">You may have to restart the watch several times after <br> powering it on the first time to complete all updates.</p>
                     
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
                            <p id="phone_no" class="phone_number inpt-val"><?=$phone; ?></p>
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
        <!--new activate section end ---->


  <section class="activated-hero-sec" id="activation_pending" style="display:none;">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-5">
                        <div class="hero-logo-wrap text-left">
                            <img src="<?= IMAGE_PATH.'logo-white.png'?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x'?>, <?= IMAGE_PATH.'logo-white@3x.png 3x'?>" alt="white-logo" class="img-fluid hero-logo">
                        </div>
                    </div>
                    <div class="col-md-7 col-7">
                        
                    </div>
                    <div class="col-md-12">
                        <p class="text-white mb-2" id="message3"></p>
                        <h1>You are now in the activation queue. </h1>
                        <p style="text-align: left">This may take up to 4 hours before your device receives service. A confirmation will be sent to the email below when completed. </p>

                     <div class="row device-number device-number-new device-activation-new">
                        <div class="col-2">
                            <img src="<?= IMAGE_PATH.'email-icon.png'?>" width="34" />
                        </div>
                        <div class="col-9">
                            <p class="gray-text text-left"> Email </p>
                            <p id="email_value" class="text-left"><?=$email?></p>
                        </div>
                        <!-- <div class="col-3">
                            <div class="copy_box position-relative">
                                <p style="display: none;" id="copied">Copied</p>
                                <img src="<?= IMAGE_PATH.'copy-frame.png'?>" width="24" /  onclick="copyToClipboard()" style="cursor: pointer;" >
                                
                            </div>
                        </div> -->
                     </div>
                     
                        <!-- <button class="btn btn-blue mx-auto d-table" onclick="submitform()" style="cursor:pointer;" > Activate another device </button> -->
                        
                       <div class="bttmtxt">
                          <p class="subtxt">Need assistance?</p>
                          <p><a href="javascript:void(0);" class="support_popup_btn" id="contact_btn5" style="color: #fff">Contact customer support.</a></p>
                          <div class="error_support_popup_box d-none d-md-block activation_pending_errorpop_desk">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone5">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="desk_email5">
                                    </div>
                                </div>
                            </div>
                        </div>

                       </div>

                         <div class="error_support_popup_box d-block d-md-none">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="mob_phone5">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="mob_email5">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>


        <!--new app download section start ---->
        <section class="activate-device" style="display:none;">
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
                                        <div class="mb-btnwrap d-block d-md-none">
                                           <button class="dwnld-btn" id="dwnld-btn">Download the COSMO app</button> 
                                        </div>
                                        <p class="dff-dvc">or <a href="javascript:void(0)" onclick="submitform()">activate another device</a></p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none d-md-block">
                                    <div class="appph-wrap">
                                        <img src="<?=IMAGE_PATH. "activate-newph@2x.png"; ?>"  alt="phone-image" class="appscr-img img-fluid" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--new app download section end ---->
            <!--activating content start-->
            <div class="activating_content">
                <!--activate main-body start-->
                <section class="activate-main">
                    <div class="container">
                        <div class="row">
                            <!--<div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <img src="<?=IMAGE_PATH. "logo-white.png"; ?>" srcset="<?=IMAGE_PATH. "logo-white@2x.png 2x"; ?>, <?=IMAGE_PATH. "logo-white@3x.png 3x"; ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                            </div>-->
                        </div>
                    </div>
                </section>
                <!--activate main-body end-->
                <!--activate signal popup start-->
                <div class="signal-popup">
                    <div class="spopup-box">
                        <div class="popup-info text-center px-2">
                            <img src="<?=IMAGE_PATH. "signal_new_edited.gif"; ?>"  alt="signal-icon" class="img-fluid signal-icon">
                            <h4  id="activating-plan-text">Activating plan...</h4>
                            <p>This may take a minute</p>
                        </div>
                    </div>
                     <div class="protip">
                        <div class="container text-center">
                            <h3>Pro Tip</h3>
                            <?php 
           
                            $arr=array("Turning on your watch’s Wi-Fi helps to provide extra GPS accuracy!","You can also customize preset messages in the parent app that the watch send with a single tap.","Set a SafeZone to be notified when the watch enters and leaves.","Mix and match styles by easily swapping JrTrack wrist bands!","Turn on Class Mode to limit watch functions and reduce distractions during set times.","Hit “Refresh Location” in the Mission Control parent app any time to see your child’s current location.");

                            $rand=mt_rand(0,5);
                            ?>
                            <p id="changingtext"><?php echo $arr[$rand];?></p>
                        </div>
                    </div>

                </div>
                <!--activate signal popup end-->
            </div>
            <!--activating content end-->

<form method="post" id="form" action="scan.php">
    <input type="hidden" name="uid" id="uid">
</form>



                <!--hero section start-->
        <!-- <section class="activated-hero-sec" id="activated_block" style="display:none;">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-5">
                        <div class="hero-logo-wrap text-left">
                            <img src="<?= IMAGE_PATH.'logo-white.png'?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x'?>, <?= IMAGE_PATH.'logo-white@3x.png 3x'?>" alt="white-logo" class="img-fluid hero-logo">
                        </div>
                    </div>
                    <div class="col-md-7 col-7">
                        
                    </div>
                    <div class="col-md-12">
                        <h1 class="mt-4"> Device is activated! </h1>
                        <p> Thank you for joining COSMO. Your JrTrack2 and COSMO membership are now active. </p>

                     <div class="row device-number py-2">

                        <div class="col-3 col-md-2">
                            <img src="<?= IMAGE_PATH.'email_new.png'?>" width="24" />
                        </div>
                        <div class="col-6 col-md-8 align-items-start">
                            <p class="gray-text text-left"> Email </p>
                            <p ><?=$_GET['email']; ?></p>
                        </div>
                        <div class="col-3 col-md-2">

                        </div>

                        <div class="col-3 col-md-2 mt-2">
                            <img src="<?= IMAGE_PATH.'watch_new.png'?>" width="24" />
                        </div>
                        <div class="col-6 col-md-8 mt-2 align-items-start">
                            <p class="gray-text text-left"> Your new number </p>
                            <p id="phone_no" class="phone_number"><?=$phone; ?></p>
                        </div>
                        <div class="col-3 col-md-2 mt-2">
                            <div class="copy_box position-relative">
                                <p style="display: none;" id="copied">Copied</p>
                                <img src="<?= IMAGE_PATH.'copy-frame.png'?>" width="22" /  onclick="copyToClipboard()" style="cursor: pointer;" >
                            </div>
                        </div>

                     </div>

                        <button class="btn btn-blue mx-auto d-table" onclick="submitform()" style="cursor:pointer;" > Activate another device </button>

                         
                    </div>
                </div>
            </div>
        </section> -->
        <!--hero section end-->


                <!--landing activate form start--->
                  <!-- <section class="activate-device" style="display:none;">
                    <div class="container">
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
                </section> -->
             <!--landing activate form end--->

              <!--purchase confirmation content start-->
           <div class="purchase_content" style="display:none;">
               <section class="top-purs pt-md-4 pt-sm-3 pt-3 text-lg-center text-md-left">
                 <div class="container">
                   <div class="row">
                     <div class="col-md-12 col-12 p-0">
                       <div class="purchase-head">Your plan is now activated!</div>
                     </div>
                     <div class="col-md-12 col-12">
                        <div class="purchase-in">
                          <div class="cosmo-mob-wrap text-lg-center text-sm-left">
                            <img src="<?=IMAGE_PATH. "cosmo-mob.png"; ?>" srcset="<?=IMAGE_PATH. "cosmo-mob@2x.png 2x"; ?>, <?=IMAGE_PATH. "cosmo-mob@3x.png 3x"; ?>" alt="cosmo-mobile-image" class="img-fluid cosmo-mob">
                          </div>
                          <h2 class="my-lg-4 my-3">Lets continue by pairing your StartPhone</h2>
                          <p class="mb-lg-4 mb-md-4 mb-3">A confirmation of your subscription plan has been emailed to <a href="mailto:johnsmith@gmail.com"><span id="mail_id">johnsmith@gmail.com</a>.</span></p>
                          <p class="mb-lg-3 mb-md-2 mb-1">Your new StartPhone’s phone number is</p>
                          <h3 class="p-0"><a href="#" class="phone_number"></a></h3>
                          <div class="purchase-btn text-lg-center text-md-left">
                             <a href="#" id="success_phone" class="purchase-btn-in d-block mx-lg-auto">Pair my StartPhone</a>
                          </div>
                        </div>
                     </div>
                   </div>
                 </div>
               </section>
           </div>
         <!--purchase confirmation content end-->

              <!-- Error Content Start -->
            <div class="error_content" id="error_curl" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <!--<img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">-->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4 >Oh no, something went wrong</h4>
                            <p class="p1" id="error_message" >401 | Server connection error</p>
                            <a href="#" class="try_btn" >Try again</a>
                            <p class="p2">Not activating?</p>
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn" id="contact_btn">Contact customer support for assistance.</a></p>
                        </div>
                        <div class="error_support_popup_box d-none d-md-block" tabindex="-1">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="desk_phone1" >
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_email1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none" tabindex="-1">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="mob_phone1">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="mob_email1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->

              <!-- Error Content Start -->
            <div class="error_content" id="response_block-old" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <!--<img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">-->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4 >Oh no, something went wrong</h4>
                            <p class="p1" id="message1-old">401 | Server connection error</p>
                            <a href="javascript:void(0);" class="try_btn support_popup_btn2">Contact customer support for assistance.</a>
                            
                            <p class="p3"><a href="#" class="support_popup_btn" onclick="location.reload();">Try again</a></p>


                            <!-- <a href="#" class="try_btn">Try again</a> 
                            <p class="p2">Not activating?</p>
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn">Contact customer support for assistance.</a></p> -->
                        </div>
                        <div class="error_support_popup_box d-none d-md-block">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->

               <!-- Error Content Start -->
            <div class="error_content" id="response_block" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                               <!-- <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">-->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4>Oh no, something went wrong</h4>
                            <p class="p1"  id="message1" class="message1">015 | Server connection error</p>
                            <a href="#" class="try_btn" onclick="location.reload();">Try again</a>
                            <p class="p2">Not activating?</p>
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn" id="contact_btn2">Contact customer support for assistance.</a></p>
                        </div>
                        <div class="error_support_popup_box d-none d-md-block">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone2">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="desk_email2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="mob_phone2">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="mob_email2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->

                <!-- Error Content Start -->
            <div class="error_content" id="response_block2" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                               <!-- <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">-->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4>Oh no, something went wrong</h4>
                            <p class="p1"  id="messagessss" class="message1">015 | Server connection error</p>
                          <!--   <a href="javascript:void(0);" class="try_btn support_popup_btn">Contact customer support for assistance.</a>
                            <p class="p2">Not activating?</p> -->
                            <p class="p3"><a href="javascript:void(0);" class="try_btn support_popup_btn" id="contact_btn4">Contact customer support for assistance.</a></p>
                        </div>
                        <div class="error_support_popup_box d-none d-md-block">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone4">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="desk_email4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="mob_phone4">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="mob_email4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->




                <!-- Error Content Start -->
            <div class="error_content" id="response_block_2" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                               <!-- <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">-->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4>Oh no, something went wrong</h4>
                            <p class="p1"  id="message2" class="message1">401 | Server connection error</p>
                            <a href="#" class="try_btn support_popup_btn">Contact customer support for assistance.</a>
                           <!--  <p class="p2">Not activating?</p> 
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn">Contact customer support for assistance.</a></p>-->
                        </div>
                        <div class="error_support_popup_box d-none d-md-block">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741 ">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->




                <!-- Error Content Start -->
            <div class="error_content" id="confirm_email" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box wrong_mail_error_box">
                        <div class="popup-info text-center px-2">
                        <img src="<?= IMAGE_PATH.'wrong-email-new.png' ?>" srcset="<?= IMAGE_PATH.'wrong-email-new.png 2x' ?>, <?= IMAGE_PATH.'wrong-email-new@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon wrong_mail_icon">
                            <h4>Email does not match</h4>
                            <p class="acc-mapp">004 | Account mapping</p>
                          
                            
                            <p class="p1"  id="message2" class="message1">The purchased plan is assigned to an email that is different from your verified email address. Confirm the email address below to continue to activate.
</p>

                            <p class="customer_mail"><?=$email; ?></p>
                            <a href="#" class="try_btn support_popup_btn2 confirm_email_btn" onclick="emailMismatchUpdate()">Confirm and activate</a>
                            <a href="#" class="try_btn support_popup_btn contact_support_btn" id="contact_btn3">Contact customer support</a>
                           <!--  <p class="p2">Not activating?</p> 
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn">Contact customer support for assistance.</a></p>-->
                        </div>
                        <div class="error_support_popup_box d-none d-md-block">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone3">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="desk_email3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none">
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="mob_phone3">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="mob_email3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->


        </main>
        <!--main section end-->



        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script type="text/javascript">

    
$(document).click(function(e) {

  // check that your clicked
  // element has no id=info

  if( e.target.id != 'contact_btn' && e.target.id != 'contact_btn2' && e.target.id != 'contact_btn3' && e.target.id != 'contact_btn4' && e.target.id != 'contact_btn5' && e.target.id != 'desk_phone1' && e.target.id != 'desk_email1' && e.target.id != 'mob_phone1' && e.target.id != 'mob_email1'   && e.target.id != 'desk_phone2' && e.target.id != 'desk_email2' && e.target.id != 'mob_phone2' && e.target.id != 'mob_email2'   && e.target.id != 'desk_phone3' && e.target.id != 'desk_email3' && e.target.id != 'mob_phone3' && e.target.id != 'mob_email3' && e.target.id != 'desk_phone4' && e.target.id != 'desk_email4' && e.target.id != 'mob_phone4' && e.target.id != 'mob_email4' && e.target.id != 'desk_phone5' && e.target.id != 'desk_email5' && e.target.id != 'mob_phone5' && e.target.id != 'mob_email5' ) {
  console.log('wwwwwww',e.target);

    $('.error_support_popup_box').removeClass('active');
                    $('.error_support_popup').css('bottom','-100%');

  }
});

// $(".error_support_popup_box").on('blur',function(){
//       $('.error_support_popup_box').removeClass('active');
//                     $('.error_support_popup').css('bottom','-100%');
// });

    window.history.pushState(null, null, window.location.href);
        window.onpopstate = function ()
        {
            window.history.go(1);
        };

    $( document ).ready(function() {
        
            if (/Android/i.test(navigator.userAgent)) {
$('#dwnld-btn').attr("onclick","window.location='https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol&hl=en_US&gl=US'");
}
else if(/webOS|iPhone|iPad|iPod/i.test(navigator.userAgent))
{
$('#dwnld-btn').attr("onclick","window.location='https://apps.apple.com/us/app/cosmo-mission-control/id1580600845'");

}

     activateDataplan();

       $('.support_popup_btn').click(function(){
                    $('.error_support_popup_box').addClass('active');
                    $('.error_support_popup').css('bottom','0');
                });

     });

/*function activateDataplan()
{
    var charge_id='<?=$charge_id?>';
    var email='<?=$email?>';
    $(".activating_content").show();
 //   $("#activate_btn").hide();
   $.ajax({
            type: 'POST',
            url: 'activateDataplanSpeedtalk.php',
            data: {"charge_id":charge_id,"email":email},
            dataType: 'json',
           // crossDom;ain:true,
            // statusCode:{

            //      200: function (response) {
            //          alert('1');
                     
            //       },
            //     404: function (response) {
            //          alert('2');
                     
            //       },

            // },
            success: function(data,textStatus, jqXHR) { 
              // console.log(jqXHR.status);
               console.log(data);
                //alert(data.phone);
                if(data.response==true)
                {

                     $("#uid").val(data.uid);
                   // window.history.replaceState(null, null, "?response=success");
                    $(".activating_content").hide();
                    var phone=data.phone;
                    var phn1=phone.substring(0, 3);
                    var phn2=phone.substring(3,6);
                    var phn3=phone.substring(6,10);
                    var phone_format="+1 ("+phn1+") "+phn2+"-"+phn3;
                   // $(".phone_number").text(data.phone);
                    $(".phone_number").text(phone_format);
                    
                    if(data.referrer=='Web')
                    {
                      
                            
                         $(".activated-hero-sec").show();
                         $(".activate-device").show();


                      //  $("#downloadapp").show();
                    }
                    else
                    {
                       
                        $(".purchase_content").show();
                       // $("#downloadapp").hide();
                        $("#mail_id").text(data.email);
                        $("#success_phone").attr("href","success.php?pn="+data.encrypted_phone+"&imei="+data.imei);
                    }
                }
                else if(data.response==false)
                {
                   // dont retry
                   // alert(data.message);
                   // window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                    $("#message1").text(data.message);
                    $("#message2").text(data.message);
                   
                    //alert(data.block);
                    $('#'+data.block).show();
                   // $("#response_block").show();
                   
                }
                else
                {
                    //window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                   // $("#error_code").text(data.error_code);
                   // $("#error_message").text(data.error_code+' | '+data.error_message);
                    $("#error_message").text(data.error_message);
                    $(".error_content").hide();
                    $("#error_curl").show();
                }
                
            },

             error : function(jqXHR,request,error)
             {

                //window.history.replaceState(null, null, "?response=fail");
                    console.log(jqXHR.status);
                    //alert(error);
                    // $("#error_message").text(data.error_message);
                    // $(".error_content").hide();
                    // $("#error_curl").show();
                   if(jqXHR.status==404)
                   {
                    // alert('ss');
                   }
                  
                   
             }



          });
}

*/


function activateDataplan()
{

    var localstorage_email=localStorage.getItem('email');
    var localstorage_imei=localStorage.getItem('imei');
    var charge_id='<?=$charge_id?>';
    var email='<?=$email?>';
    $(".activating_content").hide();
    console.log(localstorage_email);
    console.log(email);

    if(localstorage_email!=email)
    {

        $("#confirm_email").show();
        //alert('Email Mismatch');
       
    }
    else
    { 
        $(".activating_content").show();
        activate(charge_id,email);


    }
}

function emailMismatchUpdate()
{

       var localstorage_email=localStorage.getItem('email');
    var localstorage_imei=localStorage.getItem('imei');
    var charge_id='<?=$charge_id?>';
    var email='<?=$email?>';
     $(".activating_content").show();
      $("#confirm_email").hide();
    //  alert('hi');
     $.ajax({
            type: 'POST',
            url: 'emailmismatch_update.php',
            data: {"charge_id":charge_id,"email":email,"localstorage_email":localstorage_email,"localstorage_imei":localstorage_imei},
            dataType: 'json',
          
            success: function(data,textStatus, jqXHR) { 
              // console.log(jqXHR.status);
               console.log(data);
               if(data.response==true)
               {

                    localStorage.setItem('email',email);
                     activate(charge_id,email);
                
               }
              else
              {

                 $("#response_block").show();
              }
              
            }});

        
}

function activate(charge_id,email)
{

    var charge_id=charge_id;
    var email=email;
 //   $("#activate_btn").hide();
   $.ajax({
            type: 'POST',
            url: 'activateDataplanSpeedtalk.php',
            data: {"charge_id":charge_id,"email":email},
            dataType: 'json',
           // crossDom;ain:true,
            // statusCode:{

            //      200: function (response) {
            //          alert('1');
                     
            //       },
            //     404: function (response) {
            //          alert('2');
                     
            //       },

            // },
            success: function(data,textStatus, jqXHR) { 
              // console.log(jqXHR.status);
               console.log(data);
                //alert(data.phone);
                if(data.response==true)
                {

                     $("#uid").val(data.uid);
                   // window.history.replaceState(null, null, "?response=success");
                    $(".activating_content").hide();
                     var phone=data.phone;
                    // if(data.provider=='telnyx')
                    // {
                    //         var phn1=phone.substring(0, 2);
                    //         var phn2=phone.substring(2,5);
                    //         var phn3=phone.substring(5,8);
                    //         var phn4=phone.substring(8,12);
                    //         var phone_format=phn1+" ("+phn2+") "+phn3+"-"+phn4;
                    // }
                    // else
                    // {
                           
                    //         var phn1=phone.substring(0, 3);
                    //         var phn2=phone.substring(3,6);
                    //         var phn3=phone.substring(6,10);
                    //         var phone_format="+1 ("+phn1+") "+phn2+"-"+phn3;
                    // }
                    
                    var phn1=phone.substring(0, 3);
                    var phn2=phone.substring(3,6);
                    var phn3=phone.substring(6,10);
                    var phone_format="+1 ("+phn1+") "+phn2+"-"+phn3;

                   // $(".phone_number").text(data.phone);
                    $(".phone_number").text(phone_format);
                    
                    if(data.referrer=='Web')
                    {
                      
                            
                        // $(".activated-hero-sec").show();
                         $("#activated_block").show();
                         
                         $(".activate-device").show();

                         window.location='phone.php?pn='+data.encrypted_phone+'&uid='+data.uid+'&email='+data.encrypted_email;

                      //  $("#downloadapp").show();
                    }
                    else
                    {
                       
                        $(".purchase_content").show();
                       // $("#downloadapp").hide();
                        $("#mail_id").text(data.email);
                        $("#success_phone").attr("href","success.php?pn="+data.encrypted_phone+"&imei="+data.imei);
                    }
                }
                else if(data.response==false)
                {
                   // dont retry
                   // alert(data.message);
                   // window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                    $("#message1").text(data.message);
                    $("#message2").text(data.message);
                    $("#message3").text(data.message);
                    $("#messagessss").text(data.message);


                    //alert(data.block);
                    $('#'+data.block).show();
                   // $("#response_block").show();
                   
                }
                else if(data.response==5)
                {
                   // dont retry
                   // alert(data.message);
                   // window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                    $("#message1").text(data.message);
                     $("#messagessss").text(data.message);
                    
                    //alert(data.block);
                    $('#'+data.block).show();
                   // $("#response_block").show();
                   
                }
                else if(data.response==7)
                {
                   // dont retry
                   // alert(data.message);
                   // window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                    $("#messagessss").text(data.message);
                    $("#message3").text(data.message);

                    //alert(data.block);
                    $('#'+data.block).show();
                    $(".activate-device").show();
                   // $("#response_block").show();
                   
                }
                else
                {
                    //window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                   // $("#error_code").text(data.error_code);
                   // $("#error_message").text(data.error_code+' | '+data.error_message);
                    $("#error_message").text(data.error_message);
                    $(".error_content").hide();
                    $("#error_curl").show();
                }
                
            },

             error : function(jqXHR,request,error)
             {

                //window.history.replaceState(null, null, "?response=fail");
                    console.log(jqXHR.status);
                    //alert(error);
                    // $("#error_message").text(data.error_message);
                    // $(".error_content").hide();
                    // $("#error_curl").show();
                   if(jqXHR.status==404)
                   {
                    // alert('ss');
                   }
                  
                   
             }



          });

}
function submitform()
{
    $("#form").submit();
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


        gtag('config','G-5F7QGXG61T', {
        'client_id': localStorage.getItem('client_id'),
        'session_id': localStorage.getItem('session_id')
        });
                

</script>
  <script>
            (function(){
      var words = [
          'Activating plan...',
          'Assembling Avengers...',
          'Accessing the mainframe...',
          'Loading flux capacitor...',
          'Slaying the dragon...',
          'Searching for intelligent life...',
          'Resurrecting the dinosaurs...',
          'Collecting infinity stones...',
          'Phoning home...',
          'Unwrapping golden ticket...',
          'Running with scissors...',
          'Rescuing the princess...',
          'Burning the cookies...',
          'Stealing the moon...',
          'Executing plan Z...',


          ], i = 0;
      setInterval(function(){
          $('#activating-plan-text').fadeOut(function(){
              $(this).html(words[i=(i+1)%words.length]).fadeIn();
          });
      }, 5000);
        
  })();
        </script>

    </body>
</html>