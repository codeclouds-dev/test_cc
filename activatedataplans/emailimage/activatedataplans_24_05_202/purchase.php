<?php
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

if(!empty($_REQUEST['pn']))
{
  $phone=str_replace(" ","+",$_REQUEST['pn']);
  $phone = PHP_AES_Cipher::decrypt(KEY, $phone);
}
else
{
   header("Location: https://activate.cosmotogether.com/activate_dataplans/");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <title>Purchase Confirmation</title>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
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
         <!--purchase confirmation content start-->
           <div class="purchase_content">
               <section class="top-purs pt-md-4 pt-sm-3 pt-3 text-lg-center text-md-left">
                 <div class="container">
                   <div class="row">
                     <div class="col-md-12 col-12 p-0">
                       <div class="purchase-head">Your plan is already activated!</div>
                     </div>
                     <div class="col-md-12 col-12">
                        <div class="purchase-in">
                          <div class="cosmo-mob-wrap text-lg-center text-sm-left">
                            <img src="<?=IMAGE_PATH. "cosmo-mob.png"; ?>" srcset="<?=IMAGE_PATH. "cosmo-mob@2x.png 2x"; ?>, <?=IMAGE_PATH. "cosmo-mob@3x.png 3x"; ?>" alt="cosmo-mobile-image" class="img-fluid cosmo-mob">
                          </div>
                          <h2 class="my-lg-4 my-3">Lets continue by pairing your StartPhone</h2>
                          <!-- <p class="mb-lg-4 mb-md-4 mb-3">A confirmation of your subscription plan has been emailed to <a href="mailto:johnsmith@gmail.com">johnsmith@gmail.com</a>.</p> -->
                          <p class="mb-lg-3 mb-md-2 mb-1">Your StartPhone’s phone number is</p>
                          <h3 class="p-0"><a href="tel:(812) 829-0173"><?=$phone;?></a></h3>
                          <!-- <div class="purchase-btn text-lg-center text-md-left">
                             <a href="#" class="purchase-btn-in d-block mx-lg-auto">Pair my StartPhone</a>
                          </div> -->
                        </div>
                     </div>
                   </div>
                 </div>
               </section>
           </div>
         <!--purchase confirmation content end-->
      </main>
    <!--main section end-->
  
</body>
</html>