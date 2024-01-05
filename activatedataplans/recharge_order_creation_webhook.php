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



$data = file_get_contents('php://input');
$arr=json_decode($data,true);
$addr_id=$arr['order']['address_id'];
$charge_id=$arr['order']['charge_id'];
$email=$arr['order']['email'];
$shopify_order_number=$arr['order']['shopify_order_number'];
$type=$arr['order']['type'];


$product_arr=$arr['order']['line_items'];
$product_id=checkSubscriptionProductRecharge($product_arr); 
$refurbed_product_id=checkRefurbedProductRecharge($product_arr);
$jtse_ins_product_id=checkJt2seInstallmentProductRecharge($product_arr);

$first_name=$arr['order']['first_name'];

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

        
       //$plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
        // $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan");
        

        $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8199866679517"=>"Monthly Membership - No Contract","8271818096861"=>"Monthly Plan","8271832711389"=>"6 Month Prepaid Plan");

       $encrypted_email=PHP_AES_Cipher::encrypt(KEY,IV,$email);

       $mail->sendPlanPurchaseConfirmationMail($email,$shopify_order_number,$plan_array[$product_id],$encrypted_email);
    }
}
if($refurbed_product_id and $type=='CHECKOUT')
{
    $mail->sendrefurbedPlanPurchaseConfirmationMail($email,$first_name,$shopify_order_number,$product_arr);

}
if($jtse_ins_product_id and $type=='CHECKOUT')
{
    $mail->sendrefurbedPlanPurchaseConfirmationMail($email,$first_name,$shopify_order_number,$product_arr);

}
//$data = json_encode($data);
//print_r($arr);

    $textDataOrder=PHP_EOL."arr => ".print_r($product_arr,true)."==product_id==".$product_id."==type==".$type."==address_id==".$addr_id." refurbed_product_id".$refurbed_product_id;
    
 	$orderfile = fopen("webhook_response_order.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);


?>