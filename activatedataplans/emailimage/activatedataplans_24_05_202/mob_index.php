<?php

unset($_SESSION);
@session_start();
@ob_start();

//print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="COSMO Smart Watch For Kids">
    <meta property="og:title" content="COSMO Smart Watch For Kids">
    <meta property="og:description" content="COSMO Smart Watch For Kids">
    <meta property="og:image" content="">
    <meta property="og:type" content="website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="<?= IMAGE_PATH. "favicon.png";?>" type="image/png">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <title>Activate | Set Up Your COSMO Membership Plan - COSMO Technologies, Inc.</title>
	<!-- Stylesheets -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style.css' ?>">
</head>
<body>
	<!-- Main Starts Here -->
	<main>
        <div class="scanner_mobile1 scanner_content">
            <section class="container px-0" id="demo-content" class="scanner_content">
                <!---- new scan info start--->
                    <div class="newscan-info">
                        <div class="scaninfo-txtholder">
                            <h2>Tap “Scan” to scan the <br /> QR on the back of the watch</h2>
                            
                        </div>
                        <div class="scanimg-wraper">
                            <img src="<?= IMAGE_PATH.'static-scannerimgnew@2x.png' ?>" alt="Scan details" class="img-fluid d-block mx-auto">
                        </div>
                        <button class="btn scannew-btn" onclick="window.location.replace('https://activate.cosmotogether.com/activatedataplans/')">Scan</button>
                    </div>
                <!---- new scan info end--->
            </section>
        </div> 
	</main>
	<!-- Main Ends Here -->
</body>
</html>