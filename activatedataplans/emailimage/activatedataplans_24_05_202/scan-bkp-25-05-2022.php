<?php
@session_start();
@ob_start();

//print_r($_SESSION);
//print_r($_POST);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

// include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';

// use Application\Database;
if(isset($_POST['uid']))
{
    //$_SESSION['active_user']=$_POST['uid'];
    $_SESSION['ud']=$_POST['uid'];
}
//print_r($_SESSION);
$checkuserexists=checkUserActive();
if(!$checkuserexists )
{
  
    header('location: index.php');
    exit();

}
if(!isset($_SESSION['ud']))
{
    header('location: index.php');
    exit();
}
if(!empty($_SESSION['userDtls']))
{
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <title>Activating</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= IMAGE_PATH.'favicon.png' ?>">
        <!-- Stylesheets -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style.css' ?>">
        

        <style type="text/css">
            body {
                font-family: 'Lato', sans-serif;
            }
         
            /*.qrcode_box p:nth-child(1) {
                font-size: 24px;
                line-height: normal;
                font-weight: bold;
            }
            .qrcode_box p:nth-child(2) {
                margin-bottom: 60px;
                font-size: 18px;
                line-height: normal;
            }

            .qrcode_box {
                display: flex;
                width: 100%;
                height: 100vh;
                align-items: center;
                flex-direction: column;
            }
            #qr-reader {
                margin: 0 auto;
            }*/
        </style>


    </head>
    <body>
        <!--main section start-->
        <main>
            <!--scanner content start-->
            <div class="scanner_content">
                <!--scanner main start-->
                <section class="scanner-main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-12 position-relative">
                                <div class="scan-in text-center">
                                    <img src="<?= IMAGE_PATH.'qr-icon.png' ?>" srcset="<?= IMAGE_PATH.'qr-icon@2x.png 2x' ?>, <?= IMAGE_PATH.'qr-icon@3x.png 3x' ?> " alt="qr-icon" class="img-fluid qr-icon mb-lg-3 mb-2">
                                    <p class="my-2">Scan the QR code located on the back of your device</p>
                                    <!-- <div class="scanner-box">
                                        <div class="inner-scan mx-auto"></div>
                                    </div> -->
                                    <div id="qr-reader"></div>

                                    <button class="manual-btn" onclick="showImeiBox()">Enter code manually</button>
                                    <!-- <div id="imeiBox" style="display:none;">
                                        <form method="post" id="basic-form" action="verify.php">
                                            <input type="text" name="imei_no" id="imei_no" maxlength="19" class="required hBuAsr " value="">
                                            <button type="button" class="sc-bdvvtL llgOpg " style="transform: none;" id="submitform">Submit</button>
                                        </form>
                                    </div> -->

                                    <div class="scan-fxdbtn">
                                        <button class="text-left mr-4 pl-2" onclick="window.location.href='https://cosmotogether.com/pages/mission-control-new'"><i class='fas fa-arrow-left'></i> Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="manual_imei_box position-absolute">
                        <div class="container">
                            <p class="text-center">Enter code manually</p>
                            
                                <!-- <div class="imei_box_btns d-flex justify-content-between">
                                     <button type="button" class="cancel_btn">Cancel</button> -->

                                    <form method="post" id="basic-form" action="verify.php">
                                        <input type="text" name="imei_no" id="imei_no" maxlength="19" class="form-control required " value="" placeholder="Enter IMEI" >
                                        <div class="imei_box_btns d-flex justify-content-between">
                                            <button type="button" class="cancel_btn">Cancel</button>
                                            <button type="button" class="connect_btn" style="transform: none;" id="submitform">Connect</button>
                                        </div>
                                    </form>

                                <!-- </div> -->
                           
                        </div>
                    </div>
                </section>
                <!--scanner main end-->
            </div>
            <!--scanner content end-->
        </main>
        <!--main section end-->

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
                            <h4>Oh no, something went wrong</h4>
                            <p class="p1" id="error_message"></p>
                           
                            <p class="p2"><a onclick="location.reload();" style="color:blue; cursor: pointer;" id="scan_link">Scan IMEI Again</a></p>
                            <!-- <p class="p3"><a href="#" class="support_popup_btn" onclick="location.reload();">Try again</a></p> -->
                        </div>
                        <div class="error_support_popup_box d-none d-md-block">
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(555) 555-5555">(555) 555-5555</a></span></p>
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
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(555) 555-5555">(555) 555-5555</a></span></p>
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

            
<!-- <script src="https://unpkg.com/html5-qrcode"></script> -->
<script src="asset/js/html5-qrcode.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="asset/js/qr2.js"></script>

<script>
   // A $( document ).ready() block.
    $( document ).ready(function() {


        $("#qr-reader__dashboard_section_swaplink").hide();
       // $("#qr-reader__dashboard_section_csr").children('span').eq(1).children('button').eq(1).attr('id','stop_scanning');
        $("#qr-reader__dashboard_section_csr").children('span').eq(1).children('button').eq(1).attr('id','ssss');

    //     $('#stop_scanning').on('click',function(){

    //     $("#qr-reader__dashboard_section_swaplink").hide();

    // });
    });





    function  showImeiBox() {
        $("#imeiBox").show();
    }
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);

                if(decodedText != null){


                    $('#imei_no').val(decodedText);

                    if ($('#imei_no').val() !== null) {

                       // $('#basic-form').submit();
                         checkImeiExists();
                    }
                }

            }
        }

        function onScanError(errorMessage) {
            
            console.log('Something went wrong! Please type the IMI number manually')
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 200, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    });




</script>


        <!-- Scripts -->
        <!-- <script type="text/javascript" src="asset/js/jquery-3.6.0.min.js"></script> -->
        <script type="text/javascript" src="asset/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.manual-btn').click(function(){
                    $('.manual_imei_box').css('bottom','0');
                });
                $('.cancel_btn').click(function(){
                    $('.manual_imei_box').css('bottom','-100%');
                });
            });
        </script>
    </body>
</html>