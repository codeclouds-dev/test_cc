<?php
//header('Content-Type: text/plain');
// $phone='(443) 756-0961 ';
//  $phone = preg_replace( '/[^0-9]/', '', $phone );
// echo $phone;
// echo "<br>";
// $activation_date=date('Y-m-d H:i:s');
// function obfuscate_email($email)
// {
//     $em   = explode("@",$email);
//     echo $name = implode('@', array_slice($em, 0, count($em)-1));
//    echo $len  = floor(strlen($name)/2);

//     return substr($name,0, 2) . str_repeat('*', $len) . "@" . end($em);   
// }

// // to see in action:
// $emails = ['vijaya.jha@codeclouds.com'];

// foreach ($emails as $email) 
// {
//     echo obfuscate_email($email) . "\n";
// }


error_reporting(E_ALL);
ini_set('display_errors', '1');
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

// include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'WebMail.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
 include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'WebMail.php';

 include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'WebMail2.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'speedtalktestapi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'TelnyxApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'CosmoSipApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'CosmoNetworkApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'FreshDeskApi.php';


 // use Application\WebMail;
 use Application\Database;
 use Application\WebMailNew;
use Application\KlaviyoApi;
use Application\SpeedtalkApi1;
use Application\WebMail;
use Application\TelnyxApi;
use Application\CosmoSipApi;
use Application\CosmoNetworkApi;
use Application\FreshDeskApi;

$klaviyo_api=new KlaviyoApi();
$speedtalk_test_api=new SpeedtalkApi1();
$TelnyxApi=new TelnyxApi();
$cosmosipapi=new CosmoSipApi();
$cosmonetworkapi=new CosmoNetworkApi();
$FreshDeskApi=new FreshDeskApi();

// $json='{"description": "Details about the issue...", "subject": "Support Needed...", "email": "vijaya.jha@codeclouds.com", "priority": 1, "status": 2}';
// $arr=json_decode($json);
// //print_r($arr);

// $res=$FreshDeskApi->createTicket($arr);
// print_r($res);
// exit;

$explode=explode("+1","+16183661936");
//print_r($explode);

$watch_phone_number="+13344598339";
     $phn1=substr($watch_phone_number,0,2);
     $phn2=substr($watch_phone_number,2,3);
     $phn3=substr($watch_phone_number,5,3);
      $phn4=substr($watch_phone_number,8,4);
   $phone_format=$phn1. "($phn2)" .$phn3."-".$phn4;


$Res=$cosmosipapi->getAuthToken(array("imei"=>"sss"));
echo "ss";print_r($Res);
exit;


$res=$cosmonetworkapi->getAuthToken();
print_r($res);


    echo "string";
    // $res=$cosmonetworkapi->defaultNetworkType(array("imei"=>"123456789123470"),$res['accessToken']);
// print_r($res);
$res2=$cosmonetworkapi->getNetworkType(array("imei"=>"123456789123647"),$res['accessToken']);
print_r($res2);

echo $res2['default_call_network'];
     
$res3=$cosmonetworkapi->setPurchase(array("imei"=>"123456789123647"),$res['accessToken']);
print_r($res3);

$res4=$cosmonetworkapi->setActivation(array("imei"=>"123456789123647","activation"=>false),$res['accessToken']);
print_r($res4);

exit;
// $res1=$cosmonetworkapi->setActivation(array("imei"=>"123456789123647","network"=>"standard"),$res['accessToken']);
// print_r($res1);

$res=$cosmosipapi->getAuthToken("123456789123470");

$arr=array();
$arr['imei']="123456789123470";
$res1=$cosmosipapi->generateSip($arr,$res['accessToken']);
$res1=$cosmosipapi->cancelSip($arr,$res['accessToken']);

print_r($res1);
exit;

//$response1=$TelnyxApi->getSimCardDtls("1111111");
//print_r($response1);
// checkTelnyxResponse($dev_arr=array(),$response1);
// checkCurlResponseNew($response1,1);
 $response2=$TelnyxApi->deleteSimCard("89311210000000185745");
 //print_r($response2);
//checkTelnyxResponse($dev_arr=array(),$response2);

// $response3=$TelnyxApi->registerSimCard("3579639125");
// print_r($response3);

exit();
$activation_arr['fname']='Reine Queen ';
$activation_arr['lname']='Momo Brown';
$activation_arr['cxemail']='QUEENMOMO20@GMAIL.COM';
$activation_arr['zip']='20905';
$activation_arr['state']='CA';
$activation_arr['phone']='+1 240-478-7574';
$activation_arr['address1']='1925 Mayflower Dr';
$activation_arr['city']='Silver Spring';
$sim_no='8901240204213803413F';

// $response=$speedtalk_test_api->stActivate($sim_no,$activation_arr);
// print_r($response);
$text="how's you";
echo $text = str_replace("'", "-", $text);

$createlistto_klaviyo=array();
$createlistto_klaviyo['email']='sdriggers12@gmail.com';
$createlistto_klaviyo['fullName']='Sarah Driggers';
//echo $createlistto_klaviyo['phone_number']=$getUserDtls[0]['phoneNumber'];
$createlistto_klaviyo['phone_number']='+16232054043';

$createlistto_klaviyo['plan_type']='12 Month Annual Dataplan';
$createlistto_klaviyo['plan_order_number']='50203';
$createlistto_klaviyo['watch_phone_number']='4244685588';
$createlistto_klaviyo['sim_type']='Speedtalk';

$klaviyo=array();
$klaviyo['profiles']=$createlistto_klaviyo;
$res_klaviyo=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo);
print_r($res_klaviyo);


$mail=new WebMail();
// $db=new Database();
//$mail->sendAlertDataplan("eric@cosmotogether.com",array("product_name"=>"Monthly Membership"));
$mail->sendAlertDataplan("vijaya.jha@codeclouds.com",array("product_name"=>"Monthly Membership"));

$mail->activationPending("vijaya.jha@codeclouds.com");
//  $query="select activation_pending.id as actv_id,device_details_new.id as device_id,device_details_new.sim_no from activation_pending join device_details_new on activation_pending.device_id=device_details_new.id where device_details_new.status='2' and activation_pending.status=0";

// $arr=array();
// $arr['query']=$query;
// $get_actv_pending=$db->SelectRaw($arr);
// echo $get_actv_pending[0]['actv_id'];
// if(count($get_actv_pending)>0)
// {

//   foreach($get_actv_pending as $val)
//   {
//     echo $val['actv_id'];
//     $res= $db->update(ACTIVATION_PENDING,array('status'=>1),array("where id='".$val['actv_id']."'"));
//     print($res);
//   }
  
// }


echo "--------------------------------";
//$db->Update(DEVICETABLE,array('activation_date'=>$activation_date),array("where id=1"));
 $mail=new WebMail();
// $mail->activationPending('vijaya.jha@codeclouds.com');

 //$mail->sendOTP('vijaya.jha@codeclouds.com');
  //$mail->sendPhoneNumber('vijaya.jha@codeclouds.com','monthly','2135252566');
// $mail->sendPlanPurchase('vijaya.jha@codeclouds.com','monthly','12345677');
//$res=$mail->sendConfirmationMailNew("vijaya.jha@codeclouds.com","33333","Monthly","655566565656");
$mail->sendConfirmationMailNew("leahrose217@gmail.com","1 Month Dataplan","5756915780");
//print_r($res);
// $mail->sendPlanPurchaseConfirmationMail("vijaya.jha@codeclouds.com","122555","Monthly");


//$mail->sendConfirmationMail("vijaya.jha@codeclouds.com","12345","Monthly","968244455555");
// echo "email==".PHP_AES_Cipher::encrypt(KEY, IV, "test3@test.com");
// echo "<br>";
// echo "imei==".PHP_AES_Cipher::encrypt(KEY, IV, "867798040000121");

// echo "decode imei==".PHP_AES_Cipher::decrypt(KEY, "IJqJSuQ3QyzwqNAEqPi0Fw==:ZmVkY2JhOTg3NjU0MzIxMA==");
// echo "<br>";
echo "phone==".PHP_AES_Cipher::encrypt(KEY, IV, "4242492891");

// echo "decode imei==".PHP_AES_Cipher::decrypt(KEY, "LMZckShhdmwG28mKFLzU31XngHGAxF2BenmDnreeT1o=:ZmVkY2JhOTg3NjU0MzIxMA==");

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

  <style type="text/css">
    
    .box{
    border: 1px solid red;
    margin-left: 100px; 
      position: relative;
    
}
.link{
      
}

.popup{    
    width: 300px;
    height: 300px;
    background: green;
    color: #FFFFFF;
    display: none;
    position: absolute;
    left: -30px;
     outline:0;
}



  </style>
</head>
<body>
<form id="basic-form" action="" method="post">
    <p>
      <label for="name">Name <span>(required, at least 3 characters)</span></label>
      <input id="name" name="name" minlength="3" type="text" required>
    </p>
    <p>
      <label for="email">E-Mail <span>(required)</span></label>
      <input id="email" type="email" name="email" required>
    </p>
    <p>
      <button type="submit"></button>
    </p>
</form>
<div class="container">
    <div class="box">
        <a href="#" class="link">Open</a>
         <div class="popup" tabindex="-1">
             Hello world
             <a class="close" href="#">Close</a>
        </div>
    </div>
  </div>
<a href="https://cosmotogether.com/pages/purchase-dataplans-1">Purchase Dataplans</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script type="text/javascript">
 $(document).ready(function() {
//  alert('dd');
var date=new Date();
//alert(date);
localStorage.setItem("email", "vijaya.jha@codeclouds.com");
localStorage.setItem("imei", "65566");
localStorage.setItem("date", date);

// alert(localStorage.getItem('email'));
// alert(localStorage.getItem('imei'));
// alert(localStorage.getItem('date'));


  $("#basic-form").validate();
});


 $(".link").click(function(e){
    e.preventDefault();
    $(".popup").fadeIn(300,function(){$(this).focus();});
});

$('.close').click(function() {
   $(".popup").fadeOut(300);
});
$(".popup").on('blur',function(){
    $(this).fadeOut(300);
});




</script>
</body>
</html>
