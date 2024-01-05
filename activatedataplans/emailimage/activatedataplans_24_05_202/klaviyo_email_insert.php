<?php
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';


 use Application\Database;
 use Application\KlaviyoApi;
 use Application\RechargeApi;


 $db = new Database;

 $start = $_GET['start'];
 $end = $_GET['end'];

/*-----------------------------------Fetching data from email_db_klaviyo table -----------------------------------*/
$check_user_arr=array();
$check_user_arr['table']='email_db_klaviyo';
$check_user_arr['selector']='id,user_id, email';
$check_user_arr['condition']="where status=0 and id between $start and $end  order by id asc LIMIT 1";
$checkUserExists=$db->Select($check_user_arr);

// echo "<pre>";
 //print_r($checkUserExists);

if(count($checkUserExists)>0){

$email_klaviyo_id=$checkUserExists[0]['id'];
$db->Update('email_db_klaviyo',array('status'=>5),array("where id='$email_klaviyo_id'"));

$user_id = $checkUserExists[0]['user_id'];
$email = $checkUserExists[0]['email'];


/*-----------------------------------Fetching data from device_details_new-----------------------------------*/
$check_device_arr=array();
$check_device_arr['table']='device_details_new';
$check_device_arr['selector']='phone_number, address_id';
$check_device_arr['condition']="where user_id='$user_id' order by activation_date desc LIMIT 1";
$checkDeviceExists=$db->Select($check_device_arr);

// echo "<pre>";
// print_r($checkDeviceExists);

$phone_number = $checkDeviceExists[0]['phone_number'];
$address_id = $checkDeviceExists[0]['address_id'];


/*-----------------------------------Fetching data from recharge api-----------------------------------*/
$RechargeApi = new RechargeApi();
$order_dtl = $RechargeApi->getChargeIdbyAddrId($address_id);

// echo "<pre>";
// print_r($order_dtl);

$shopify_order_number = $order_dtl['orders'][0]['shopify_order_number'];
// $shopify_product_id = $order_dtl['orders'][0]['line_items'][0]['shopify_product_id'];

$product_arr=$order_dtl['orders'][0]['line_items'];
$product_id=checkSubscriptionProductRecharge($product_arr); 

// echo $product_id;


/*-----------------------------------creating new member in klaviyo list-----------------------------------*/
$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");

$klaviyo_api = new KlaviyoApi();
$createlistto_klaviyo1=array();
$createlistto_klaviyo1['email']=$email;
$createlistto_klaviyo1['plan_type']=$plan_array[$product_id];
$createlistto_klaviyo1['plan_order_number']=$shopify_order_number;
$createlistto_klaviyo1['watch_phone_number']=$phone_number;
$createlistto_klaviyo1['sim_type']='Speedtalk';
$klaviyo1=array();
$klaviyo1['profiles']=$createlistto_klaviyo1;

$res_klaviyo1=$klaviyo_api->createMembertoKlaviyoList($klaviyo1);

$res_klaviyo_json = json_encode($res_klaviyo1);

// echo "<pre>";
 //print_r($res_klaviyo1);

/*-----------------------------------updating email_db_klaviyo table with response from klaviyo-----------------------------------*/
if(isset($res_klaviyo1[0]['id'])){
    
$db->Update('email_db_klaviyo',array('status'=>1,'response'=>$res_klaviyo_json),array("where id='$email_klaviyo_id'"));

}else{
$db->Update('email_db_klaviyo',array('status'=>2,'response'=>$res_klaviyo_json),array("where id='$email_klaviyo_id'"));

}


}
?>