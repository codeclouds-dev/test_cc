<?php 


//header('Access-Control-Allow-Origin: *');

@session_start();
@ob_start();

//print_r($_SESSION);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include_once "countries.php";
include_once "states.php";
//echo $us_state_abbrevs_names['NEW YORK'];
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();



// $data = file_get_contents('php://input');
// $arr=json_decode($data,true);
// $addr_id=$arr['order']['address_id'];
// $charge_id=$arr['order']['charge_id'];
// $email=$arr['order']['email'];
// $shopify_order_number=$arr['order']['shopify_order_number'];
// $type=$arr['order']['type'];
$order_dtl=$recharge_api->getOrder($_GET['charge_id']);
if(count($order_dtl['orders'])>0)
{
$product_arr=$order_dtl['orders'][0]['line_items'];
print_r($order_dtl);
$type=$order_dtl['orders'][0]['type'];
$email=$order_dtl['orders'][0]['email'];
 $addr_id=$order_dtl['orders'][0]['address_id'];
 $shopify_order_number=$order_dtl['orders'][0]['shopify_order_number'];
//$product_arr=$arr['order']['line_items'];
$product_id=checkSubscriptionProductRecharge($product_arr); 

if($product_id and $type=='CHECKOUT')
{
    $user_arr=array();
    $user_arr['table']=USERTABLE;
    $user_arr['selector']="id";
    $user_arr['condition']="where email='".$email."'";

    $getUserDtls=$db->Select($user_arr);

    if(count($getUserDtls)>0)
    {

       $db->Update(DEVICETABLE,array('address_id'=>$addr_id,'status'=>'5',"shopify_product_id"=>$product_id,'payment_date'=>date('Y-m-d H:i:s'),'shopify_order_number'=>$shopify_order_number),array("where user_id='".$getUserDtls[0]['id']."' and status='1'"));
       $plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
              $encrypted_email=PHP_AES_Cipher::encrypt(KEY,IV,$email);

       $mail->sendPlanPurchaseConfirmationMail($email,$shopify_order_number,$plan_array[$product_id],$encrypted_email);
    }
}

//$data = json_encode($data);
//print_r($arr);
}

?>