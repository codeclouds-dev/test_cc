<?php
@session_start();
@ob_start();

//echo $_SERVER['HTTP_REFERER'];
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
?>
<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <title>Verfication</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= IMAGE_PATH.'favicon.png' ?>">
        <!--google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
        <!--font-awesome cdn--->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style.css' ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'register.css' ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main.css' ?>">



    </head>
    <body>

        <?php
        if(!isset($_SESSION['userDtls']))
        {
            //header('location: index.php');
        }
        if(!isset($_SESSION['did']))
        {
            //header('location: index.php');
        }
      //  print_r($_SESSION);


        ?>


        <!--main section start-->
        <main>
            <input type="hidden" name="email" id="email" value="<?=$_SESSION['userDtls']['email'];?>">
            <!--verfication content start-->
            <div class="verification_content">
                <!--header section start-->
                <section class="header-sec text-lg-center text-md-left">
                    <div class="container">
                        <div class="verification_content_wrap">
                            <div class="row">
                                <div class="col-md-12 col-12 text-left">
                                    <img src="<?= IMAGE_PATH.'logo-gray@2x.png' ?>" srcset="<?= IMAGE_PATH.'logo-gray@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-gray@3x.png 3x' ?>" alt="dark-logo" class="img-fluid dark-logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--header section end-->
                <!--verify form start-->
                <section class="verify-form pt-lg-4 pt-sm-4 pt-4">
                    <div class="container">
                        <div class="verification_content_wrap">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="text-lg-center text-md-left">Verify email</h1>
                                    <p class="text-lg-center text-md-left my-4">We’ve emailed a verification code to <?=$_SESSION['userDtls']['email'];?>. Enter the code below to continue with your COSMO device activation.</p>
                                    <div class="form-wrapper">
                                        <form method="post" id="otpform">
                                            <div class="verify-in d-flex justify-content-md-center justify-content-sm-start align-items-center">
                                                <input type="tel" class="inputs required form-control text-center" id="otp1"  maxlength="1"  onkeypress="return isNumber(event)" autocomplete="off">
                                                <input type="tel" class="inputs required form-control text-center" id="otp2"  maxlength="1"  onkeypress="return isNumber(event)" autocomplete="off">
                                                <input type="tel" class="inputs required form-control text-center" id="otp3"  maxlength="1" onkeypress="return isNumber(event)" autocomplete="off">
                                                <input type="tel" class="inputs required form-control text-center" id="otp4"  maxlength="1" onkeypress="return isNumber(event)" autocomplete="off">
                                                <input type="tel" class="inputs required form-control text-center" id="otp5"  maxlength="1" onkeypress="return isNumber(event)" autocomplete="off">
                                                <input type="tel" class="inputs required form-control text-center" id="otp6"  maxlength="1" onkeypress="return isNumber(event)" autocomplete="off">
                                            </div>
                                            <a href="javascript:void(0)" id="resend" class="resend link-color2 text-center d-block mt-md-5 mt-4">Resend code</a>
                                            <div class="bottom-fixed-btns d-flex justify-content-between">
                                                <div class="fixed-btn-wrap d-flex justify-content-between">
                                                    <button type="button" class="text-left mr-4 pl-2" onclick="window.location.href='https://activate.cosmotogether.com/activatedataplans/user.php'"><i class='fas fa-arrow-left' ></i> Back</button>
                                                   
                                                    <button type="button" class="active" id="submitform">Next <i class='fas fa-arrow-right'></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="sc-pVTFL cYosFl" id="incorrect_msg_block" style="display:none !important; ">
                                <div class="sc-jrQzAO bSuipU">
                                    <div class="sc-kDTinF fqlkth">
                                        <div class="sc-iqseJM dKTPEg" id="message">The security code is empty or incorrect</div>
                                        <div class="sc-crHmcD dPPCDC"><button class="sc-egiyK gxhdhz" onclick="hideIncorrect()">DISMISS</button></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                <!--verify form end-->
            </div>
             
            <!--verfication content end-->
        </main>
        <!--main section end-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.js"></script>


<script src="asset/js/otp.js"></script>

<script type="text/javascript">
    $('.inputs').keyup(function(e)
     {
       if(e.keyCode == 8)
       {
          $(this).prev('.inputs').focus();
       }

     });


</script>
    </body>
</html>