<?php 

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
if(!isset($_REQUEST['pn']))
{
   header("location: index.php");

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Success</title>
	<meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width"/>
      <link rel="shortcut icon" href="images/icon-180x180-08f3b9876667.png" type="image/x-icon">
      <!--css-->
       <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Open+Sans:wght@400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" rel="stylesheet">
        <!--font-awesome cdn--->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."bootstrap.min.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?=CSS_PATH."main-style.css"; ?>">
        
      <link rel="stylesheet" href="<?= CSS_PATH.'register.css' ?>"/>
      <link rel="stylesheet" href="<?= CSS_PATH.'main.css' ?>"/>
      
</head>
 <body class="text-gray-800">
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
                        <div class="sc-jObWnj cnsYCp">Success</div>
                     </div>
                  </div>
                  <div class="sc-jeraig fiCoxp">

                     <img src="<?= IMAGE_PATH.'loader.gif'?>" alt="loader">
                     
                  </div>
               </div>
            </main>
        </div>
    </div>
</body>
</html>