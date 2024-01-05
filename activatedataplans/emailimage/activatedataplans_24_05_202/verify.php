<?php
@session_start();
@ob_start();
//print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';


?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charSet="utf-8"/>
      <title>Verify IMEI</title>
      <meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width"/>
      <link rel="shortcut icon" href="images/icon-180x180-08f3b9876667.png" type="image/x-icon">
      <!--css-->
      <link rel="shortcut icon" type="image/x-icon" href="<?= IMAGE_PATH.'favicon.png' ?>">
       <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
        <!--font-awesome cdn--->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."bootstrap.min.css"; ?>">
        
      <link rel="stylesheet" href="<?= CSS_PATH.'register.css' ?>"/>
      <link rel="stylesheet" href="<?= CSS_PATH.'main.css' ?>"/>
              <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."main-style.css"; ?>">

        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style.css' ?>">

  <!--     <style>
        @media not all and (min-resolution:.001dpcm) {
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
        }
      </style> -->

         <style>
        .errorpop{    padding: 10px 40px !important;}
        .errorpop .p1 {
    font-size: 14px;
    color: #434343;
    margin-top: 0.575rem;
    margin-bottom: 0.7rem !important;
}
        @media not all and (min-resolution:.001dpcm) {
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
        }
        @media screen and (max-width: 768px){
           .errorpop{    padding: 10px 20px !important;}
        }
      </style>

        <?php 
       include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'custom-script.php';


    ?>
    <script>
          
            gtag('get', 'G-5F7QGXG61T', 'client_id', (client_id) => {
              localStorage.setItem('client_id',client_id);
            });
            gtag('get', 'G-5F7QGXG61T', 'session_id', (session_id) => {
              localStorage.setItem('session_id',session_id);

            });

    </script>
   </head>
   <!-- <input type="hidden" name="email" id="email" value="<?=$_SESSION['userDtls']['email'];?>"> -->
   <body class="text-gray-800">

    <?php 



        $referer = "App";

        if (preg_match("/activate.cosmotogether.com/i", $_SERVER['HTTP_REFERER'])){

           $referer = "Web";
        }

        if ($referer == "App") {

           if ( !empty($_REQUEST['email']) && !empty($_REQUEST['IMEI'])) {

           $IMEI=str_replace(" ","+",$_REQUEST['IMEI']);
           $email=str_replace(" ","+",$_REQUEST['email']);

              $IMEI = PHP_AES_Cipher::decrypt(KEY, $IMEI);

              $email = PHP_AES_Cipher::decrypt(KEY, $email);

              $_SESSION['userDtls']['email'] = $email;
              $_SESSION['LAST_ACTIVITY'] = time();

           }else{

              header("Location: index.php");
           }
        }

        if ($referer == "Web") {


            $checkuserexists=checkUserActive();
            if(!$checkuserexists)
            {
                
               // header('location: index.php');
                //exit();

            }
            if(!empty($_SESSION['userDtls']))
            {
               // header('location: index.php');
               // exit();
            }



           $IMEI = $_REQUEST['imei_no'];

           if ( empty($_REQUEST['imei_no'])) {



                // header("Location: https://activate.cosmotogether.com/activatedataplans/scan.php");
              

           }
        }
        //echo $referer;
        //print_r($_SESSION);



    ?>
      <div id="__next">
         <div class="sc-jIkXHa jElBwA">
            <main class="sc-gKclnd hmgNPn">
               <div class="sc-iCfMLu kVlbxJ">
                  <div class="sc-caiLqq bQYhvz">
                     <div class="sc-iUKqMP fNNbHR">
                        <!-- <div class="sc-cTAqQK gfQyJg">
                           <div class="sc-dkPtRN hNBCZE">
                              <svg width="24px" viewBox="0 0 24 25" fill="#000022" xmlns="http://www.w3.org/2000/svg" color="#000022">
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M15.707 4.297a1 1 0 010 1.414l-6.293 6.293 6.293 6.293a1 1 0 01-1.414 1.414l-7-7a1 1 0 010-1.414l7-7a1 1 0 011.414 0z" fill="currentColor"></path>
                              </svg>
                           </div>
                        </div> -->
                        <div class="sc-efQSVx bMgScO">Verifying IMEI</div>
                        <div class="sc-jObWnj cnsYCp"></div>
                     </div>
                  </div>
                  <div class="sc-jeraig fiCoxp justify-content-center align-items-center">

                     <!-- <img src="<?= IMAGE_PATH.'loader.gif'?>" alt="loader"> -->

                     <p><i class="fa-8x fa-solid fa-spinner fa-spin" style="color: #004feb;"></i></p>
                     
                  </div>
               </div>
            </main>

            <div></div>

            

            <div class="sc-pVTFL cYosFl" id="incorrect_msg_block" style="display: none;">
               <div class="sc-jrQzAO bSuipU">
                  <div class="sc-kDTinF fqlkth">
                     <div class="sc-iqseJM dKTPEg" id="message">The security code is empty or incorrect</div>
                     <div class="sc-crHmcD dPPCDC"><button class="sc-egiyK gxhdhz" onclick="hideIncorrect()">DISMISS</button></div>
                  </div>
               </div>
            </div>
            


         </div>
      </div>

      <form method="post" id="form" action="scan.php">
          <input type="hidden" name="uid" id="uid" value="">

      </form>

             <!--confirmation content start-->
            <div class="confirmation_content" style="display:none;">
                <!--top section start-->
                <section class="top-con pt-md-5 pt-sm-4 pt-4 text-lg-center text-md-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <img src="<?=IMAGE_PATH. "logo-white.png"; ?>" srcset="<?=IMAGE_PATH. "logo-white@2x.png 2x"; ?>, <?=IMAGE_PATH. "logo-white@3x.png 3x"; ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                                <h2 class="my-lg-4 my-3">Device is activated!</h2>
                                <p class="mb-lg-4 mb-md-4 mb-3">Thank you for your joining COSMO. Your JrTrack2 is now activated.</p>
                                <p class="mb-lg-4 mb-md-4 mb-3">The following number has been assigned to your watch.</p>
                                <h3 class="pl-md-3 pl-3"><a href="tel:(877) 215-4741" class="phone_number">(877) 215-4741</a></h3>
                                <div class="activate-ot text-lg-center text-md-left">
                                    <a href="index.php" class="act-ot-btn d-block mx-lg-auto">Activate another device</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--top section end-->
                <!--bottom section start-->
                <section class="bottom-con" id="downloadapp" style="display:none;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="bottom-main mx-auto">
                                    <div class="bottom-head text-lg-center text-md-left">
                                        <h2>Download the app</h2>
                                        <p class="my-lg-4 my-4">Download the COSMO: Mission Control parental controls app to set up your watch.</p>
                                    </div>
                                    <div class="bottom-foot text-center pt-lg-5 pt-5 pb-lg-4 pb-3">
                                        <img src="<?=IMAGE_PATH. "cosmo-icon.png"; ?>" srcset="<?=IMAGE_PATH. "cosmo-icon@2x.png 2x"; ?>, <?=IMAGE_PATH. "cosmo-icon@3x.png 3x"; ?>" alt="cosmo-icon" class="img-fluid cosmo-icon d-block mx-auto mt-3">
                                        <div class="bottom-info my-lg-5 my-md-5 my-4">
                                            <h4>COSMO: Mission Control</h4>
                                            <p class="mt-1">The app for parental controls</p>
                                        </div>
                                        <div class="download-btns pt-lg-2 pt-md-2 pt-3">
                                            <a href="#">
                                                <button class="app-store d-inline-block">
                                                    <img src="<?=IMAGE_PATH. "app-store.png"; ?>" srcset="<?=IMAGE_PATH. "app-store@2x.png 2x"; ?>, <?=IMAGE_PATH. "app-store@3x.png 3x"; ?>" alt="app-store-icon" class="img-fluid app-store-icon d-block mx-auto w-100">
                                                </button>
                                            </a>
                                            <a href="#">
                                                <button class="play-store d-inline-block">
                                                    <img src="<?=IMAGE_PATH. "play-store.png"; ?>" srcset="<?=IMAGE_PATH. "play-store@2x.png 2x"; ?>, <?=IMAGE_PATH. "play-store@3x.png 3x"; ?>" alt="play-store-icon" class="img-fluid play-store-icon d-block mx-auto w-100">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--bottom section end-->
            </div>
            <!--confirmation content end-->


        <!-- Error Content Start -->
            <div class="error_content" style="display:none;">
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
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4 id="start_actv">Oh no, something went wrong</h4>
                            <p class="p1" id="error_message">401 | Server connection error</p>
                            
                            <p class="p2"><a href="#" onclick="submitForm()" style="cursor:pointer;" id="scan_link" class="try_btn">Go to Scan Page</a></p>
                            <p class="p2"><a href="appqr.php" style="cursor:pointer;" id="scan_link2" class="try_btn">Go to Scan Page</a></p>
                            <p class="p2"><a href="javascript:void(0)" onclick="location.reload();" style="cursor:pointer;" id="tryagain" class="try_btn" style="display:none">Try Again</a></p>
                            <p class="p1 activation_link" style="display:none;"><a href="#" style="cursor:pointer; display: none;" id="actv_message">Click Here for Activation</a></p>
                            <p class="p3"><a href="javascript:void(0);" class=" support_popup_btn" id="contact_btn">Contact customer support for assistance.</a></p>
                            <!-- <p class="p3"><a href="#" class="support_popup_btn" onclick="location.reload();">Try again</a></p> -->
                        </div>
                        <div class="error_support_popup_box d-none d-md-block" >
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone1">
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
                    <div class="error_support_popup_box d-block d-md-none" >
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
           <!-- <div class="error_content" style="display:none;">
               
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                            </div>
                        </div>
                    </div>
                </section>
               
               
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4 id="start_actv">Oh no, something went wrong</h4>
                            <p class="p1" id="error_message">401 | Server connection error</p>
                            
                            <p class="p2"><a href="#" onclick="submitForm()" style="cursor:pointer;" id="scan_link" class="try_btn">Go to Scan Page</a></p>
                            <p class="p2"><a href="appqr.php" style="cursor:pointer;" id="scan_link2" class="try_btn">Go to Scan Page</a></p>
                            <p class="p2"><a href="javascript:void(0)" onclick="location.reload();" style="cursor:pointer;" id="tryagain" class="try_btn" style="display:none">Try Again</a></p>
                            <p class="p1 activation_link" style="display:none;"><a href="#" style="cursor:pointer; display: none;" id="actv_message">Click Here for Activation</a></p>
                            <p class="p3"><a href="javascript:void(0);" class=" support_popup_btn" id="contact_btn">Contact customer support for assistance.</a></p>
                            <p class="p3"><a href="#" class="support_popup_btn" onclick="location.reload();">Try again</a></p> 
                        </div>
                        <div class="error_support_popup_box d-none d-md-block" >
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone1">
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
                    <div class="error_support_popup_box d-block d-md-none" >
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
              
            </div>-->
          

                <div  id="error_content2"  style="display: none;">
                <div class="error_content">
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
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2 errorpop">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4 id="start_actv">Oh no, something went wrong</h4>
                            <p class="p1" id="error_message2">401 | Server connection error</p>
                            <p class="p2" id="subhead">Our team is working hard to fix this issue.Give us a few hours and try again later.Sorry for the inconvenience.</p>
                            

                            <p class="p3"><a href="javascript:void(0);" class=" support_popup_btn try_btn" id="contact_btn">Contact customer support for assistance.</a></p>
                            <!-- <p class="p3"><a href="#" class="support_popup_btn" onclick="location.reload();">Try again</a></p> -->
                        </div>
                        <div class="error_support_popup_box d-none d-md-block" >
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone1">
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
                    <div class="error_support_popup_box d-block d-md-none" >
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
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.js"></script>


<!-- <script src="asset/js/checking.js"></script> -->
<script type="text/javascript">


$(document).click(function(e) {

  // check that your clicked
  // element has no id=info




  if( e.target.id != 'contact_btn' && e.target.id != 'desk_phone1' && e.target.id != 'desk_email1' && e.target.id != 'mob_phone1' && e.target.id != 'mob_email1'  ) {
  console.log('wwwwwww',e.target);

    $('.error_support_popup_box').removeClass('active');
                    $('.error_support_popup').css('bottom','-100%');

  }
});



$(".error_support_popup_box").on('blur',function(){
      $('.error_support_popup_box').removeClass('active');
                    $('.error_support_popup').css('bottom','-100%');
});
 // $('.inputs').keyup(function(e)
 // {
 //   if(e.keyCode == 8)
 //   {
 //      $(this).prev('.inputs').focus();
 //   }

 // });

 $(document).ready(function() {

   $('.support_popup_btn').click(function(){
           $('.error_support_popup_box').addClass('active');
           $('.error_support_popup').css('bottom','0');
       });


   var referer = '<?=$referer;?>'; 
   //alert(referer);
   if (referer === "App") {

      createAppUser();

   }else{

      checkIMEI();
   }


 });



function submitForm()
{
     //alert('ssssssssss');
    $("#form").submit();
}
function checkIMEI(){

        var referer='<?=$referer;?>';
         $.ajax({

                   url : 'library/App.php',
                   type:'POST',
                   data : {
                       
                       'referrer':'<?=$referer;?>',
                       'functionName': 'checkIMEISpeedtalk',
                   },
                   dataType:'json',
                   success : function(data) {      

                       // alert('ddd');
                        console.log(data);
                        localStorage.setItem("imei", data.imei);
                        //console.log(localStorage.getItem('imei'));

                        if(data.response==1)
                        {
                           window.location.href='https://cosmotogether.com/pages/purchase-dataplans-1?clientId='+localStorage.getItem('client_id')+'&sessionId='+localStorage.getItem('session_id');
                        }
                        else if(data.response==2)
                        {

                           
                            $("#start_actv").text('Start Activating your SIM');
                            $("#error_message").show();
                            $("#start_actv").show();
                            $("#error_message").text('Seems like you have paid but not activated the sim and left in between. Click below link to activate');
                            $("#actv_message").attr('href','activating.php?charge_id='+data.charge_id+'&email='+data.email);
                            $("#actv_message").show();
                            $(".activation_link").show();
                                
                            $("#__next").hide();
                            $("#scan_link").hide();
                            $("#scan_link2").hide();
                            $(".error_content").show();
                            //window.location.href='https://cosmotogether.com/pages/purchase-dataplans-1';
                        }
                        else if(data.response==3)
                        {

                            if(referer=='Web')
                            {
                                  window.location='phone.php?pn='+data.phone_no+'&uid='+data.uid+'&email='+data.email;
                            }
                            else
                            {
                                  window.location='success.php?pn='+data.phone_no+"&imei="+data.imei;
                            }  

                        }
                        else if(data.response==4 || data.response==false)
                        {
                            //alert(referer);
                            if(referer=='Web')
                            {

                                $("#uid").val(data.ud);
                                $("#scan_link").show();
                                $("#scan_link2").hide();
                                 $("#tryagain").hide();
                                // alert(data.message);
                                $("#error_message").text(data.message);
                                $("#__next").hide();
                                $(".error_content").show();
                                // window.location='index.php';
                            }
                            else
                            {

                                $("#scan_link2").show();
                                $("#scan_link").hide();
                                
                            }      
                            
                           
                              
                           
                        }
                        else if(data.response=='error')
                        {
                                $("#error_message").text(data.error_message);
                                $("#__next").hide();
                                $(".error_content").show();
                                $("#scan_link2").hide();
                                $("#scan_link").hide();
                               
                                $("#actv_message").parent().removeClass('try_btn');

                        }
                        // else if(data.response==5)
                        // {
                        //     //alert(referer);
                           
                                
                        //         // $("#uid").val(data.ud);
                        //         $("#tryagain").show();
                        //         $("#scan_link").hide();
                        //         $("#scan_link2").hide();
                                
                        //         // alert(data.message);
                        //         $("#error_message").text(data.message);
                        //         $("#__next").hide();
                        //         $(".error_content").show();
                        //         // window.location='index.php';
                            
                           
                              
                           
                        // }
                        else if(data.response==5)
                        {
                            //alert(referer);
                                  // operator communication error
                                
                                // $("#uid").val(data.ud);
                                $("#tryagain").show();
                                $("#scan_link").hide();
                                $("#scan_link2").hide();
                                
                                // alert(data.message);
                                $("#error_message2").text(data.message);
                                $("#__next").hide();
                                $("#error_content2").show();
                                // window.location='index.php';
                            
                           
                              
                           
                        }
                        else if(data.response==6)
                        {
                            //alert(referer);
                            // activation pending
                              window.location='activation_queue.php?email='+data.email+'&imei='+data.imei+'&email='+data.email;
                            
                           
                              
                           
                        }
                         else if(data.response==7)
                        {
                            //alert(referer);
                             // cancelled imei
                              // alert(error);
                              $("#error_message2").text(data.message);
                                $("#scan_link").hide();
                                  $("#scan_link2").hide();
                              $("#__next").hide();
                            $("#subhead").hide();  
                              $("#error_content2").show();
                                //window.location='index.php';
                                      
                           
                        }
                        
                                      

                   },
                   error : function(request,error)
                   {

                      
                      $("#error_message2").text("019 | Something went wrong");
                        $("#scan_link").hide();
                          $("#scan_link2").hide();
                      $("#__next").hide();
                       $("#subhead").hide();  
                      $("#error_content2").show();
                        //window.location='index.php';
                      
                       
                   }
               });


    }


function createAppUser()
{

    var referer='<?=$referer?>';

    $.ajax({

                   url : 'library/App.php',
                   type:'POST',
                   data : {
                       
                       'imei_no':'<?=$IMEI;?>',
                       'functionName': 'createAppUser2',
                   },
                   dataType:'json',
                   success : function(data) {      

                       // console.log(data);
                        if(data.response==true)
                        {
                           checkIMEI();
                        }
                        else
                        {
                                 // alert(data.message);
                                $("#error_message").text(data.message);
                                $("#__next").hide();
                                $(".error_content").show();
                                //alert(referer);
                                
                                $("#scan_link2").show();
                                $("#scan_link").hide();
                                
                                
                              
                        }
                       
                                      

                   },
                   error : function(request,error)
                   {

                       // alert(error);
                      $("#error_message").text("Something Went Wrong");
                      $("#__next").hide();
                      $(".error_content").show();
                        //window.location='index.php';
                      
                       
                   }
               });

}



</script>

   </body>
</html>