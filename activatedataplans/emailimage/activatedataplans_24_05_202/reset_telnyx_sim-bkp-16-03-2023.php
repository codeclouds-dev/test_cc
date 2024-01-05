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

if(isset($_POST['submit']))
{
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


  <title></title>

</head>
<body>
    <?php if(isset($message) and $message!="")
    {
        ?>
<p><?=$message?></p>
        <?php
    }
    ?>
<form id="basic-form" action="" method="post">
 <p>Reset Telnyx Sim</p>
    <p>
      <label for="iccid">Enter ICCID to reset Telnyx SIM<span>(required)</span></label>
      <input id="iccid" type="text" name="iccid" required>
    </p>
    <p>
      <input type="submit" name="submit" value="submit">
    </p>
</form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

</body>
</html>
