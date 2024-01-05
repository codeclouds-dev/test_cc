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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'SipConnection.php';

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

  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'ShopifyApi.php';

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
use Application\ShopifyApi;

$klaviyo_api=new KlaviyoApi();
$speedtalk_test_api=new SpeedtalkApi1();
$TelnyxApi=new TelnyxApi();
$cosmosipapi=new CosmoSipApi();
$cosmonetworkapi=new CosmoNetworkApi();
$FreshDeskApi=new FreshDeskApi();
$db=new Database();
$ShopifyApi=new ShopifyApi();

insertPhoneNoToShopifyNote("5429243871453","808758062133ddddd");
exit;

            $getshopifytags=$ShopifyApi->getOrderDetailsbyOrderNo("257553");

print_r($getshopifytags);
echo $order_tag=$getshopifytags['orders'][0]['tags'];
echo $order_tag=$getshopifytags['orders'][0]['id'];

exit;

$res=$ShopifyApi->getOrderDetails("5376517079261");
echo $order_tag=$res['order']['tags'];

$tags_arr=explode(",",$order_tag);
print_r($tags_arr);
$tags_arr=array_merge($tags_arr,array("Walmart"));
print_r($tags_arr);


$data=array("order"=>array("id"=>5376517079261,"tags"=>$tags_arr));

$res=$ShopifyApi->createTag(5376517079261,$data);

exit;

$mail=new WebMail();
$dev_arr=array();
$telnyx_res=array();

$res=$cosmosipapi->getAuthToken("123456789123470");

$arr=array();
$arr['imei']="123456789123470";
//$res1=$cosmosipapi->generateSip($arr,$res['accessToken']);
$res1=$cosmosipapi->cancelSip($arr,$res['accessToken']);
print_r($res1);
exit;

echo $query="select device_details_new.*,user_mstr.email,fullName,user_mstr.id as user_id,pending.id as pending_id,pending.status as pending_status  from pending join device_details_new on device_details_new.id=pending.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_id=60305";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);

$state="Hawaii";
$city="test";
$phone="testtttttttttt";
$sip_res=sipConnectionCreate($getdevdtls[0]['imei'],$state,$city,$phone,$getdevdtls[0]['sim_no'],"optimized",$getdevdtls[0]['id'],$getdevdtls[0]['email']);

exit;

$dev_arr['email']="vijaya.jha@codeclouds.com";
$dev_arr['imei']="111111111";
$dev_arr['iccid']="test";
$telnyx_res['api']='test';
$dev_arr['subject']="test error";
$mail->sendAlertSetActivation($dev_arr,$telnyx_res);
$mail->sendAlertTelnyx($dev_arr,$telnyx_res);

$speedtalk_res['retmess']="test";
$speedtalk_res['ret']="test";
$mail->sendAlert("shil@cosmotogether.com",$dev_arr,$speedtalk_res,"test");
exit;

$res=$db->Update(DEVICETABLE,array('status'=>5,'user_id'=>6),array("where imei='123456789123645' and refurbed=1"));
print_r($res);


$order='{
    "orders": [
        {
            "address_id": 134902586,
            "address_is_active": 1,
            "billing_address": {
                "address1": "3318 De Coronado Trl",
                "address2": null,
                "city": "Round Rock",
                "company": null,
                "country": "United States",
                "first_name": "Eileen",
                "last_name": "Cable",
                "phone": null,
                "province": "Texas",
                "zip": "78665"
            },
            "browser_ip": "209.107.186.122",
            "charge_id": 912630507,
            "charge_status": "SUCCESS",
            "created_at": "2023-09-22T12:21:12",
            "currency": "USD",
            "customer": {
                "accepts_marketing": true,
                "email": "ecable07@gmail.com",
                "first_name": "Eileen",
                "last_name": "Cable",
                "phone": null,
                "send_email_welcome": false,
                "verified_email": true
            },
            "customer_id": 123301901,
            "discount_codes": [],
            "email": "ecable07@gmail.com",
            "error": null,
            "first_name": "Eileen",
            "hash": "e53395c7058ab38e4d006d611e2d3d",
            "id": 600381662,
            "is_prepaid": 0,
            "last_name": "Cable",
            "line_items": [
                {
                    "external_inventory_policy": "decrement_obeying_policy",
                    "grams": 0,
                    "images": {
                        "large": "",
                        "medium": "",
                        "original": "",
                        "small": ""
                    },
                    "original_price": "9.99",
                    "price": "9.99",
                    "product_title": "Activation Fee",
                    "properties": [],
                    "quantity": 1,
                    "shopify_product_id": 8045562298589,
                    "shopify_variant_id": 43795278954717,
                    "sku": "COSMO-ACT-FEE",
                    "subscription_id": 408443837,
                    "tax_lines": [],
                    "title": "Activation Fee",
                    "variant_title": ""
                },
                {
                    "external_inventory_policy": "decrement_obeying_policy",
                    "grams": 152,
                    "images": {
                        "large": "",
                        "medium": "",
                        "original": "",
                        "small": ""
                    },
                    "original_price": "0.00",
                    "price": "0.00",
                    "product_title": "JrTrack 2 SE (Renewed)",
                    "properties": [],
                    "quantity": 1,
                    "shopify_product_id": 8078383022301,
                    "shopify_variant_id": 43891885899997,
                    "sku": "R-JT2SE-Black",
                    "subscription_id": 408443838,
                    "tax_lines": [],
                    "title": "JrTrack 2 SE (Renewed)",
                    "variant_title": "Black"
                },
                {
                    "external_inventory_policy": "decrement_obeying_policy",
                    "grams": 0,
                    "images": {
                        "large": "https://cdn.shopify.com/s/files/1/0420/6949/1880/files/image_29_c7825f81-33a1-4bb3-bad0-03e118092d54_large.png",
                        "medium": "https://cdn.shopify.com/s/files/1/0420/6949/1880/files/image_29_c7825f81-33a1-4bb3-bad0-03e118092d54_medium.png",
                        "original": "https://cdn.shopify.com/s/files/1/0420/6949/1880/files/image_29_c7825f81-33a1-4bb3-bad0-03e118092d54.png",
                        "small": "https://cdn.shopify.com/s/files/1/0420/6949/1880/files/image_29_c7825f81-33a1-4bb3-bad0-03e118092d54_small.png"
                    },
                    "original_price": "14.99",
                    "price": "14.99",
                    "product_title": "Monthly (1 Year Contract)",
                    "properties": [],
                    "quantity": 1,
                    "shopify_product_id": 8074743152861,
                    "shopify_variant_id": 43869694591197,
                    "sku": "",
                    "subscription_id": 408443840,
                    "tax_lines": [],
                    "title": "Monthly (1 Year Contract) (Ships every 1 Months)",
                    "variant_title": ""
                }
            ],
            "note": "",
            "note_attributes": [],
            "payment_processor": "stripe",
            "processed_at": "2023-09-22T12:21:12",
            "scheduled_at": "2023-09-22T00:00:00",
            "shipped_date": "2023-09-22T12:21:12",
            "shipping_address": {
                "address1": "3318 De Coronado Trl",
                "address2": null,
                "city": "Round Rock",
                "company": null,
                "country": "United States",
                "first_name": "Eileen",
                "last_name": "Cable",
                "phone": "1527968204",
                "province": "Texas",
                "zip": "78665"
            },
            "shipping_date": "2023-09-22T00:00:00",
            "shipping_lines": [
                {
                    "code": "Standard (5-9 Business Days)",
                    "price": "0.00",
                    "tax_lines": [],
                    "title": "Standard (5-9 Business Days)"
                }
            ],
            "shopify_cart_token": "9c4c6d8a650da182e9aed59a4003be56",
            "shopify_customer_id": "6913051295965",
            "shopify_id": "5315394175197",
            "shopify_order_id": "5315394175197",
            "shopify_order_number": 194946,
            "status": "SUCCESS",
            "subtotal_price": "24.98",
            "tags": "Subscription, Subscription First Order",
            "tax_lines": [],
            "total_discounts": "0.00",
            "total_duties": null,
            "total_line_items_price": null,
            "total_price": "24.98",
            "total_refunds": null,
            "total_tax": "0.00",
            "total_weight": 152,
            "transaction_id": "ch_3NtC6JJ0sJX9krb70WriKDmw",
            "type": "CHECKOUT",
            "updated_at": "2023-09-22T12:21:12"
        }
    ]
}';

        $order_dtls=json_decode($order,true);
print_r($order_dtls);
  echo $address_id=$order_dtls['orders'][0]['address_id'];
        echo $email=$order_dtls['orders'][0]['email'];
        echo $first_name=$order_dtls['orders'][0]['billing_address']['first_name'];
        echo $last_name=$order_dtls['orders'][0]['billing_address']['last_name'];
        echo $phone=$order_dtls['orders'][0]['billing_address']['phone'];
        echo $created_at=date('Y-m-d',strtotime($order_dtls['orders'][0]['created_at']));
        $full_name=$first_name.' '.$last_name;



        $arr['table']=USERTABLE;
        $arr['selector']="id";
        $arr['condition']="where email='".$email."'";
        $getUserDtls=$db->Select($arr);
        print_r($getUserDtls);
        if(count($getUserDtls)>0)
        {
              echo "string";
            echo $user_id=$getUserDtls[0]['id'];
        }
        else
        {

             $user_arr=array("fullName"=>$full_name,"email"=>$email,"phoneNumber"=>$phone);
             //print_r($user_arr);
             echo $user_id=$db->Insert(USERTABLE,$user_arr);
          

        }

exit;

$mail->sendConfirmationMailNew("vijaya.jha@codeclouds.com","1 Year Prepaid Plan","555555555","0");

$mail->sendConfirmationMailNew("JJadams0328@gmail.com","1 Year Prepaid Plan","6308812910","0");
exit;

// 
// $mail->sendConfirmationMailNew("rituparna.chakraborty@codeclouds.com","1 Month Dataplan","5756915780","1");
// $mail->sendAlertDataplan("rituparna.chakraborty@codeclouds.com",array("product_name"=>"Monthly Membership", "product_id"=>"8054644113629", "scheduled_at"=>"07-21-2023"));
// echo "phone==".PHP_AES_Cipher::encrypt(KEY, IV, "rituparna.chakraborty@codeclouds.com");
//$mail->sendPlanPurchaseConfirmationMail("rituparna.chakraborty@codeclouds.com","578456","1 Month Dataplan","phone==g4wJCegIXuttRAVd/eHhux9ZjyZNl+MMA0ciP/XvpfIX75uJ2x07YAg8ZWzhE71s:ZmVkY2JhOTg3NjU0MzIxMA==");
// $mail->activationPending("rituparna.chakraborty@codeclouds.com");
// exit;


// $json='{"description": "Details about the issue...", "subject": "Support Needed...", "email": "vijaya.jha@codeclouds.com", "priority": 1, "status": 2}';
// $arr=json_decode($json);
// //print_r($arr);

// $res=$FreshDeskApi->createTicket($arr);
// print_r($res);
// exit;
// echo $_GET['email'];

$explode=explode("+1","+16183661936");
//print_r($explode);

$watch_phone_number="+13344598339";
     $phn1=substr($watch_phone_number,0,2);
     $phn2=substr($watch_phone_number,2,3);
     $phn3=substr($watch_phone_number,5,3);
      $phn4=substr($watch_phone_number,8,4);
   $phone_format=$phn1. "($phn2)" .$phn3."-".$phn4;


$res=$cosmosipapi->getAuthToken();
$arr=array();
$arr['imei']="123456789123646";
$arr['address']=array("phone_number"=>"2525252525","locality"=>"New York","administrative_area"=>"NY");

$res1=$cosmosipapi->generateSip($arr,$res['accessToken']);
echo "string";
print_r($res1);

exit;
$res=$cosmonetworkapi->getAuthToken();


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

//exit;
// $res1=$cosmonetworkapi->setActivation(array("imei"=>"123456789123647","network"=>"standard"),$res['accessToken']);
// print_r($res1);

$res=$cosmosipapi->getAuthToken("123456789123470");

$arr=array();
$arr['imei']="123456789123470";
$res1=$cosmosipapi->generateSip($arr,$res['accessToken']);
$res1=$cosmosipapi->cancelSip($arr,$res['accessToken']);

print_r($res1);
//exit;

//$response1=$TelnyxApi->getSimCardDtls("1111111");
//print_r($response1);
// checkTelnyxResponse($dev_arr=array(),$response1);
// checkCurlResponseNew($response1,1);
 $response2=$TelnyxApi->deleteSimCard("89311210000000185745");
 //print_r($response2);
//checkTelnyxResponse($dev_arr=array(),$response2);

// $response3=$TelnyxApi->registerSimCard("3579639125");
// print_r($response3);

//exit();
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
 $dev_arr=array();
                                $dev_arr['device_id']="123";
                                $dev_arr['imei']="12345";
                                $dev_arr['iccid']="12345";
                                $dev_arr['email']="abc";
                               $dev_arr['subject']='Test Tenyx Error';   
$response['api']="error";

$response['errors'][0]['detail']="error";
$mail->sendAlertTelnyx($dev_arr,$response);
// $db=new Database();

//$mail->sendAlertDataplan("eric@cosmotogether.com",array("product_name"=>"Monthly Membership"));
$mail->sendAlertDataplan("vijaya.jha@codeclouds.com",array("product_name"=>"Monthly Membership"));
exit();
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
