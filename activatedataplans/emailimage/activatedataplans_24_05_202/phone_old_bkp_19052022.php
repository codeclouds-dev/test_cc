<?php
@session_start();
@ob_start();
//print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
use Application\Database;

$user_exists=0;
if(!isset($_SESSION['phone_details']))
{
    header('location: index.php');
}
else
{
     $phone=str_replace(" ","+",$_REQUEST['pn']);

     $phone = PHP_AES_Cipher::decrypt(KEY, $phone);
   // unset($_SESSION['phone_details']);
}

if(isset($_GET['uid']))
{
    //echo $_GET['uid'];
    $uid=str_replace(" ","+",$_REQUEST['uid']);

    $uid = PHP_AES_Cipher::decrypt(KEY, $uid);

   $db=new Database();
    $user_arr=array();
    $user_arr['table']=USERTABLE;
    $user_arr['selector']="count(id) as count";
    $user_arr['condition']="where id='".$uid."'";

    $getUserDtls=$db->Select($user_arr);
    //print_r($getUserDtls);
    if($getUserDtls[0]['count']>0)
    {
        $user_exists=1;
    }

}

//echo $user_exists;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <title>Confirmation</title>
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

             <form method="post" id="form" action="scan.php">
            <input type="hidden" name="uid" id="uid" value="<?=md5($uid);?>">
        </form>
            <!--confirmation content start-->
            <div class="confirmation_content">
                <!--top section start-->
                <section class="top-con pt-md-5 pt-sm-4 pt-4 text-lg-center text-md-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <img src="<?= IMAGE_PATH.'logo-white.png'?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x'?>, <?= IMAGE_PATH.'logo-white@3x.png 3x'?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                                <h2 class="my-lg-4 my-3">Device is already activated!</h2>
                                <p class="mb-lg-4 mb-md-4 mb-3">Thank you for your joining COSMO. Your JrTrack2 is now activated.</p>
                                <p class="mb-lg-4 mb-md-4 mb-3">The following number has been assigned to your watch.</p>
                                <h3 class="pl-md-3 pl-3"><a href="tel:(812) 829-0173"><?=$phone; ?></a></h3>
                                <div class="activate-ot text-lg-center text-md-left">
                                    <a  onclick="submitform()" style="cursor:pointer;" class="act-ot-btn d-block mx-lg-auto">Activate another device</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--top section end-->
                <!--bottom section start-->
                <section class="bottom-con">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="bottom-main mx-auto">
                                    <div class="bottom-head text-lg-center text-md-left">
                                        <h2>Download the app</h2>
                                        <p class="my-lg-4 my-4">Download the COSMO: Mission Control parental controls app to set up your watch.</p>
                                    </div>
                                    <div class="bottom-foot text-center pt-lg-5 pt-5 pb-lg-4 pb-3">
                                        <img src="<?= IMAGE_PATH.'cosmo-icon.png'?>" srcset="<?= IMAGE_PATH.'cosmo-icon@2x.png 2x'?>, <?= IMAGE_PATH.'cosmo-icon@3x.png 3x'?>" alt="cosmo-icon" class="img-fluid cosmo-icon d-block mx-auto mt-3">
                                        <div class="bottom-info my-lg-5 my-md-5 my-4">
                                            <h4>COSMO: Mission Control</h4>
                                            <p class="mt-1">The app for parental controls</p>
                                        </div>
                                        <div class="download-btns pt-lg-2 pt-md-2 pt-3">
                                            <a href="#">
                                                <button class="app-store d-inline-block">
                                                    <img src="<?= IMAGE_PATH.'app-store.png'?>" srcset="<?= IMAGE_PATH.'app-store@2x.png 2x'?>, <?= IMAGE_PATH.'app-store@3x.png 3x'?>" alt="app-store-icon" class="img-fluid app-store-icon d-block mx-auto w-100">
                                                </button>
                                            </a>
                                            <a href="#">
                                                <button class="play-store d-inline-block">
                                                    <img src="<?= IMAGE_PATH.'play-store.png'?>" srcset="<?= IMAGE_PATH.'play-store@2x.png 2x'?>, <?= IMAGE_PATH.'play-store@3x.png 3x'?>" alt="play-store-icon" class="img-fluid play-store-icon d-block mx-auto w-100">
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
        </main>
        <!--main section end-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            

            function submitform()
            {

                var user_exists='<?=$user_exists;?>';
                if(user_exists==1)
                {
                    $("#form").submit();
                }
                else
                {
                    window.location.href='index.php';
                }
                
            }

        </script>
    </body>
</html>