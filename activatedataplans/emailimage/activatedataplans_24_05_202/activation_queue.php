<?php 
@session_start();
@ob_start();

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
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
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."style-speedtalk.css"; ?>">

    </head>
    <body>
        <?php 
            if(!isset($_SESSION['phone_details']))
            {
                
                header('location: index.php');
            }
            else
            {
               

                 $email=str_replace(" ","+",$_REQUEST['email']);
                 $email = PHP_AES_Cipher::decrypt(KEY, $email);
                 unset($_SESSION['phone_details']);
            }
        ?>
        <!--main section start-->
        <main>
          






                <!--hero section start-->
        <section class="activated-hero-sec" style="display:block;">
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
                        <p class="text-white mb-2" style="text-align: left;">016 | Activation Pending</p>
                        <h1>You are now in the activation queue. </h1>
                        <p style="text-align: left;">This may take up to 4 hours before your device receives service. A confirmation will be sent to the email below when completed. </p>

                     <div class="row device-number device-number-new device-activation-new">
                        <div class="col-2">
                            <img src="<?= IMAGE_PATH.'email-icon.png'?>" width="34" />
                        </div>
                        <div class="col-8">
                            <p class="gray-text text-left"> Email </p>
                            <p id="email_value" class="phone_number text-left"><?=$email;?></p>
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
                          <p>Contact customer support.</p>
                       </div>
                         
                    </div>
                </div>
            </div>
        </section>
        <!--hero section end-->


                <!--landing activate form start--->
                  <section class="activate-device" style="display:block;">
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
                                                <!-- <img src="<?= IMAGE_PATH.'app-store.png'?>" width="120" srcset="<?= IMAGE_PATH.'app-store@2x.png 2x'?>, <?= IMAGE_PATH.'app-store@3x.png 3x'?>images/" /> -->
                                                <img src="<?= IMAGE_PATH.'app_store_new_qr.png'?>" alt="App Store QR" class="img-fluid d-none d-lg-block">
                                                <img src="<?= IMAGE_PATH.'app_store_btn_new.png'?>" alt="App Store QR" class="img-fluid d-block d-lg-none">
                                            </a>
                                            <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol" target="_blank" class="newqr-img">
                                                <!-- <img src="<?= IMAGE_PATH.'play-store.png'?>" width="120" srcset="<?= IMAGE_PATH.'play-store@2x.png 2x'?>, <?= IMAGE_PATH.'play-store@3x.png 3x'?>" /> -->
                                                <img src="<?= IMAGE_PATH.'google_play_new_qr.png'?>" alt="Google Play QR" class="img-fluid d-none d-lg-block">
                                                <img src="<?= IMAGE_PATH.'google_play_btn_new.png'?>" alt="Google Play QR" class="img-fluid d-block d-lg-none">
                                            </a>
                                        </p>
                                    </div>
                        </div>
                    </div>
                </section>
             <!--landing activate form end--->

         


        </main>
        <!--main section end-->



        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script type="text/javascript">
    window.history.pushState(null, null, window.location.href);
        window.onpopstate = function ()
        {
            window.history.go(1);
        };




</script>


    </body>
</html>