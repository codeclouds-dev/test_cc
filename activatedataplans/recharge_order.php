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


if($product_id!="")
{
    $created_date=date('Y-m-d', strtotime($arr['order']['created_at']));
    $diff = (isset($arr['order']['created_at']) && $arr['order']['scheduled_at'])?(strtotime($arr['order']['scheduled_at']) - strtotime($created_date)):0;
    $days= ceil(abs($diff / 86400));
    if($days<150)
    {

    }
}


    $textDataOrder=PHP_EOL."days => ".$days."==product_id==".$product_id."==type==".$type."==address_id==".$addr_id;
    
 	$orderfile = fopen("webhook_response_order.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);


?>