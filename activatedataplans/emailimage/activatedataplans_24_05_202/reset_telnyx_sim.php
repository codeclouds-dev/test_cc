<?php





error_reporting(E_ALL);

ini_set('display_errors', '1');

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';



include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';



include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'TelnyxApi.php';





 // use Application\WebMail;

 use Application\Database;

 use Application\TelnyxApi;



$db=new Database();

$TelnyxApi=new TelnyxApi();
$class='';
$message='';

if(isset($_POST['submit']))

{
    $class="error";
    $iccid=$_POST['iccid'];



    $check_device=array();

    $check_device['table']='device_details_new';

    $check_device['selector']='id,status,sim_no';

    $check_device['condition']="where sim_no='".$iccid."'";

    

    $checkDeviceExists=$db->Select($check_device);

    if(count($checkDeviceExists)>0)

    {

        if($checkDeviceExists[0]['status']==2)

        {

              $db->Update(DEVICETABLE,array('status'=>4,'address_id'=>NULL,'status'=>0,'phone_number'=>NULL,'provider_phone_number'=>NULL,'activation_date'=>NULL,'payment_date'=>NULL,'shopify_product_id'=>NULL,'network_type_cosmo'=>NULL,'network_type'=>NULL,'shopify_order_number'=>NULL),array("where sim_no='".$iccid."'"));



              $telnyx_res=$TelnyxApi->deleteSimCard($checkDeviceExists[0]['sim_no']);

              if(count($telnyx_res['data'])>0)

              {

                   $message="Data Reset";
                   $class="noError";
              }

              

        }

        else

        {

            $message="Data Not Valid";

        }

    }

    else

    {

        $message="Device Not Found";

    }

}



?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, user-scalable=no">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <!-- Optional theme -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .wrapper {
            height: 100vh;
        }
        input[type="submit"].submit_btn {
            background: #004feb;
            color: #fff;
            border: transparent;
            border-radius: 5px;
            font-size: 0.875rem;
            line-height: 1;
            font-weight: 500;
            animation: none;
            animation-duration: 1s;
            animation-delay: 0.4s;
            animation-fill-mode: forwards;
            text-transform: capitalize;
            padding: 0.875rem 4rem;
            transition: all 0.3s linear;
            -webkit-transition: all 0.3s linear;
            -moz-transition: all 0.3s linear;
            -ms-transition: all 0.3s linear;
        }
        input[type="submit"].submit_btn:hover {
            background: #0a3c9b;
        }
        .error {
            background: #ba3131;
            text-align: center;
            color: #fff;
            padding: 0.5rem;
            border: transparent;
            border-radius: 5px;
        }
        .noError {
            background: #1a961a;
            text-align: center;
            color: #fff;
            padding: 0.5rem;
            border: transparent;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="wrapper d-flex justify-content-center align-content-center flex-column">
                    <?php if(isset($message) and $message!="")

                    {

                        ?>

                    <p class="<?=$class?>"><?=$message?></p>

                        <?php

                    }

                    ?>

                    <form id="basic-form" action="" method="post" class="d-flex justify-content-center align-content-center flex-column">
                        <p>Reset Telnyx Sim</p>
                        <p>
                            <label for="iccid">Enter ICCID to reset Telnyx SIM<span>(required)</span></label>
                            <br>
                            <input id="iccid" type="text" name="iccid" class="form-control mt-2" required>
                        </p>
                        <p>
                            <input type="submit" name="submit" value="submit" class="submit_btn">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
