<?php
@session_start();
@ob_start();
print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

if(!isset($_SESSION['did']))
{
     header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="<?= IMAGE_PATH.'favicon.png' ?>" type="image/png">
        <link rel="icon" href="<?= IMAGE_PATH.'favicon.png' ?>" type="image/png">
        <title>Cosmo SmartWatch</title>
        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style.css' ?>"/>


    </head>
    <body>
        <!--main section start-->
        <main>
            <!--hero section start-->
            <section class="hero-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <div class="hero-logo-wrap text-left">
                                <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="white-logo" class="img-fluid hero-logo">
                            </div>
                        </div>
                        <div class="col-md-7 col-7">
                            <div class="hero-modal text-right">
                                <img src="<?= IMAGE_PATH.'header-modal.png' ?>" srcset="<?= IMAGE_PATH.'header-modal@2x.png 2x' ?>, <?= IMAGE_PATH.'header-modal@3x.png 3x' ?>" alt="hero-modal" class="img-fluid modal-img">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--hero section end-->
            <!--landing activate form start--->
            <section class="activate-form">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p class="activate_hd">Activate your watch</p>
                            <p class="welcome_txt">Welcome to COSMO and thank you for purchasing your JrTrack2. Let's not waste any time and get your watch activated! Here's what we'll do:</p>
                            <div class="steps steps1 d-flex align-items-center">
                                <div class="number">1</div>
                                <div class="step_txt ml-3">Scan the QR code on the back of your JrTrack2</div>
                            </div>
                            <div class="steps steps2 d-flex align-items-center">
                                <div class="number">2</div>
                                <div class="step_txt ml-3">Add a subscription plan to use all the JrTrack2 features</div>
                            </div>
                            <p class="form_hd">Enter email to start activation</p>
                            <p class="form_subhd">Your device and account will be connected to this email address.</p>
                            <form  id="basic-form" action="javascript:void(0);" method="post">
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control required">
                                <button type="submit" id="submitform" class="activate_btn">Start activation</button>
                            </form>
                            <p class="terms_txt">By continuing, you confirm to have read and agreed to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy.</a></p>
                        </div>
                    </div>
                </div>
            </section>
            <!--landing activate form end--->
        </main>
        <!--main section end-->



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="asset/js/index_js/index.js"></script>

    </body>
</html>