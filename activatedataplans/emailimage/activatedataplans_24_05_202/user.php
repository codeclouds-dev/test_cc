<?php
@session_start();
@ob_start();

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';


?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<title>User</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= IMAGE_PATH.'favicon.png' ?>">
  <!--google font-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
  <!--font-awesome cdn--->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Stylesheets -->
  <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
  <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style1.css' ?>"/>
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style-speedtalk1.css?v=1.6' ?>">

  <style type="text/css">
    body { font-family: 'Roboto', sans-serif; }
    .email-main h1 {
        font-family: 'Neuzeit Grotesk', sans-serif !important;
    }
    .email-main p {
        font-family: 'Roboto', sans-serif !important;
    }
    .btn-blue, .btn-verify {
        font-family: 'Neuzeit Grotesk', sans-serif !important;
    }
    /*section.email-main {
        padding-top: 3rem;
    }
*/
   /* @media not all and (min-resolution:.001dpcm) {
      @media {
          button.btn-verify.activate_btn{
            padding: 17px 30px 12px 30px !important;
          }
        }
    }
    @media not all and (min-resolution:.001dpcm) {
      @media screen and (max-width: 767px) {
          button.btn-verify.activate_btn{
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
//print_r($_SESSION);
if(!isset($_SESSION['did']))
{
     header('location:index.php');
}
?>
    <!--main section start-->
      <main>
         <!--sanner content start-->
           <div class="email-section">
             <div class="newpgressbar">
               <div class="newprogress-bar nunq-prgbar" style="width: 0%;"></div>
            </div>
              <!--sanner main start-->
              <section class="email-main email-main-user">
                <div class="">
                  <div class="enter_email_cont enter_email_cont_new">
                    <div class="row no-gutters">
                      <div class="col-md-12 col-12">
                        <!--<div class="hero-logo-wrap text-left">
                          <img src="<?= IMAGE_PATH.'logo-gray@2x.png' ?>" srcset="<?= IMAGE_PATH.'logo-gray@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-gray@3x.png 3x' ?>" alt="gray-logo" class="img-fluid hero-logo">
                        </div>-->
                      </div>
                      <div class="col-md-12 col-lg-5">
                            <div class="image">
                                <!-- <img src="<?= IMAGE_PATH.'nactvuserbg.png' ?>" srcset="<?= IMAGE_PATH.'nactvuserbg@2x.png 2x' ?>, <?= IMAGE_PATH.'nactvuserbg@3x.png 3x' ?>" alt="side image" class=""> -->
                            </div>
                        </div>
                      <div class="col-md-12 col-lg-7">
                        <div class="newactivationcontent">
                          <div class="enter_user_box">
                             <div class="row justify-content-center align-items-center">
                                  <div class="col-10 col-md-9">

                        <h1> Enter email </h1>
                        <!-- <p> To continue activation, a verification code will be sent to the email you enter below. </p> -->
                        <p>We will use your email to send you payment and activation details. </p>

                       <!--  <form method="post"  id="basic-form" >
                          <input type="text" name="dd">
                          <input type="submit" name="submitform" value="submitform">
                        </form> -->
                         <form  id="basic-form" action="javascript:void(0);" method="post">
                        <div class="form-group">
                         
                                  <input type="email" name="email" id="email" placeholder="Email" class="form-control required">
                                  <!-- <button type="submit" id="submitform" class="activate_btn">Start activation</button> -->
                             

                          <!-- <input type="email" placeholder="Email" /> -->
                        </div>

                        <button class="btn-verify activate_btn" type="submit" id="submitform">Next </button>
                         </form>
                        <p class="terms"> By continuing, you confirm to have read and agreed to our <a href="https://cosmotogether.com/policies/terms-of-service" target="_blank">Terms of Service</a> and <a href="https://cosmotogether.com/pages/privacy" target="_blank">Privacy Policy</a>. </p>
                        <div class="bottom-fixed-btns fixed-bottom-new d-flex justify-content-between">
                            <div class="fixed-btn-wrap d-flex justify-content-between">
                              <button type="button" class="text-left mr-4 pl-2" onclick="window.location.href='https://activate.cosmotogether.com/activatedataplans/index.php'"><i class='fas fa-arrow-left' ></i> Back</button>
                                                   
                            </div>
                        </div>
                         </div>
                      </div>



                      </div>
                      </div>
                     </div>
                    </div>
                    <!-- new section for progress bar start --->
                    <!-- <div class="row fxd-lowres">
                         <div class="col-md-12">
                             <div class="nwprogress-bar">
                                <div class="progress">
                                   <div class="progress-bar unq-prgbar" style="width: 20%"></div>
                                </div>
                             </div>
                         </div>
                     </div> -->
                    <!-- new section for progress bar end --->
                  </div>
                </div>
              </section>
              <!--sanner main end-->
           </div>
         <!--sanner content end-->
      </main>
    <!--main section end-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="asset/js/index_js/index.js<?=VERSION ?>"></script>
<script src="//fw-cdn.com/2239608/2902551.js" chat="true"></script>

<script>
        $( document ).ready(function() {
           $(".nunq-prgbar").css("width", "40%");
        });
    </script>
</body>
</html>