
<?php 

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

?><!DOCTYPE html>
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style-speedtalk.css?v=1.6' ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'refurb.css' ?>">
</head>
<body>
   <section class="refurb-topsec">
       <div class="container">
           <h1>It’s time to<br class="d-block d-md-none"> download the app!</h1>
           <p>You already purchased a plan when you bought the watch. Now you can download the app, create an account, and pair with the watch!</p>
       </div>
   </section>

   <section class="refurb-app-sec">
       <div class="container">
           <div class="row justify-content-center align-items-center">
               <div class="col-md-10 col-lg-8">
                   <h1>Download the app</h1>
                   <p>Download the COSMO: Mission Control parental controls app to set up your watch.</p>
                   <div class="app-dwnldbx">
                       <img src="<?=IMAGE_PATH. "cosmo-logo@2x.png"; ?>" alt="">
                       <h2>COSMO: Mission Control</h2>
                       <p>The app for parental controls</p>
                       <div class="appbx">
                           <img src="<?=IMAGE_PATH. "apple-app-store@2x.png"; ?>" alt="">
                           <img src="<?=IMAGE_PATH. "paly-store@2x.png"; ?>" alt="">
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
</body>
</html>