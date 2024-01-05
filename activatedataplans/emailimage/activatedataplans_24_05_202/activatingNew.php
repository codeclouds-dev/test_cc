<?php 
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

if(isset($_GET['charge_id']) and $_GET['charge_id']!="")
{
     $charge_id=$_GET['charge_id'];
}
else
{
    ?>

    <p>Something went wrong!</p>
    <?php
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
    </head>
    <body>
        <!--main section start-->
        <main>
            <!--activating content start-->
            <div class="activating_content">
                <!--activate main-body start-->
                <section class="activate-main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <img src="<?=IMAGE_PATH. "logo-white.png"; ?>" srcset="<?=IMAGE_PATH. "logo-white@2x.png 2x"; ?>, <?=IMAGE_PATH. "logo-white@3x.png 3x"; ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                            </div>
                        </div>
                    </div>
                </section>
                <!--activate main-body end-->
                <!--activate signal popup start-->
                <div class="signal-popup">
                    <div class="spopup-box">
                        <div class="popup-info text-center px-2">
                            <img src="<?=IMAGE_PATH. "signal.png"; ?>" srcset="<?=IMAGE_PATH. "signal@2x.png 2x"; ?>, <?=IMAGE_PATH. "signal@3x.png 3x"; ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4>Activating plan...</h4>
                            <p>This may take a minute</p>
                        </div>
                    </div>
                </div>
                <!--activate signal popup end-->
            </div>
            <!--activating content end-->

<form method="post" id="form" action="scan.php">
    <input type="hidden" name="uid" id="uid">
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
                                <h3 class="pl-md-3 pl-3"><a href="tel:(812) 829-0173" class="phone_number">(812) 829-0173</a></h3>
                                <div class="activate-ot text-lg-center text-md-left">
                                    <a onclick="submitform()" class="act-ot-btn d-block mx-lg-auto">Activate another device</a>
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
                          <h3 class="p-0"><a href="tel:(812) 829-0173" class="phone_number">(812) 829-0173</a></h3>
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
                            <h4 >Oh no, something went wrong</h4>
                            <p class="p1" id="error_message" >401 | Server connection error</p>
                            <a href="#" class="try_btn" >Try again</a>
                            <p class="p2">Not activating?</p>
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn">Contact customer support for assistance.</a></p>
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

              <!-- Error Content Start -->
            <div class="error_content" id="response_block" style="display:none;">
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
                            <h4 >Oh no, something went wrong</h4>
                            <p class="p1" id="message1">401 | Server connection error</p>
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

    $( document ).ready(function() {
        
     activateDataplan();

       $('.support_popup_btn2').click(function(){
                    $('.error_support_popup_box').addClass('active');
                    $('.error_support_popup').css('bottom','0');
                });

     });

function activateDataplan()
{
    var charge_id='<?=$charge_id?>';
    $(".activating_content").show();
 //   $("#activate_btn").hide();
   $.ajax({
            type: 'POST',
            url: 'activateDataplanNew.php',
            data: {"charge_id":charge_id},
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
               console.log(jqXHR.status);
               console.log(data.data);
                //alert(data.phone);
                if(data.response==true)
                {
                   // window.history.replaceState(null, null, "?response=success");
                   $("#uid").val(data.uid);
                    $(".activating_content").hide();
                    $(".phone_number").text(data.phone);
                  
                    if(data.referrer=='Web')
                    {
                        $(".confirmation_content").show();
                        $("#downloadapp").show();
                    }
                    else
                    {
                       
                        $(".purchase_content").show();
                        $("#downloadapp").hide();
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
                    $("#response_block").show();
                   
                }
                else
                {
                    //window.history.replaceState(null, null, "?response=fail");
                    $(".activating_content").hide();
                   // $("#error_code").text(data.error_code);
                    $("#error_message").text(data.error_code+' | '+data.error_message);
                    $(".error_content").hide();
                    $("#error_curl").show();
                }
                
            },

             error : function(jqXHR,request,error)
             {

                //window.history.replaceState(null, null, "?response=fail");
                    console.log(jqXHR.status);
                    //alert(error);
                    
                   if(jqXHR.status==404)
                   {
                    alert('ss');
                   }
                  
                   
             }



          });
}


function submitform()
{
    $("#form").submit();
}
</script>


    </body>
</html>