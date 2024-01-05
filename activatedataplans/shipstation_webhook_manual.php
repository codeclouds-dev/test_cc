<?php 
@session_start();
@ob_start();


//print_r($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "countries.php";
include_once "states.php";
//echo $us_state_abbrevs_names['NEW YORK'];
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'ShipstationApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'ShopifyApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\ShipstationApi;
use Application\ShopifyApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$ShipstationApi=new ShipstationApi();
$ShopifyApi=new ShopifyApi();


//$data = file_get_contents('php://input');
//$arr=json_decode($data,true);

// $order_dtls=$recharge_api->getOrderDtlsbyShopifyOrder($_GET['order_number']);
$order_dtls=$recharge_api->getOrderDtlsbyShopifyOrder($_POST['order_number']);

//if(isset($order_dtls['orders'][0]['shopify_order_id']))

/* $shopify_res=$ShopifyApi->getOrderDetails($order_dtls['orders'][0]['shopify_order_id']);
                echo "<pre>";
                print_r($shopify_res);
                echo "</pre>"; 
                exit();
*/

// $textDataOrder=PHP_EOL."=> Shopify Order Number => ".$_GET['order_number']." date ".date('Y-m-d H:i:s');
$textDataOrder=PHP_EOL."=> Shopify Order Number => ".$_POST['order_number']." date ".date('Y-m-d H:i:s');


//if(isset($arr['resource_url']))
if(isset($order_dtls['orders'][0]['shopify_order_id']))
{

        $arr['table']=REFURBEDACTIVATION;
        $arr['selector']="id";
        $arr['condition']="where order_number='".$_POST['order_number']."'";//$_GET['order_number']."'"
        $getdevicedtls=$db->Select($arr);

        if(count($getdevicedtls)>0) {

                $textDataOrder.=PHP_EOL."=> already exist";
                // echo "<pre>";
                // print_r($getdevicedtls);
                // echo "</pre>"; 
                echo "exists";
                exit();

        }else{

		        $textDataOrder.=PHP_EOL."=> Shopify Order Id => ".$order_dtls['orders'][0]['shopify_order_id'];

		        //$result=$ShipstationApi->shipstationWebhookResourceURL($arr['resource_url']);
		        // print_r($result);

		        //$order_number=$result['shipments'][0]['orderNumber'];
		        //$shopify_order_id=$result['shipments'][0]['orderKey'];

		        $order_number=$_POST['order_number'];
		        $shopify_order_id=$order_dtls['orders'][0]['shopify_order_id'];

		        $shopify_res=$ShopifyApi->getOrderDetails($shopify_order_id);
		        //print_r($shopify_res);

		        $product_arr=$shopify_res['order']['line_items'];
		        // print_r($product_arr);
		        $product_id=checkRefurbedProduct($product_arr);

		        $product_id_jt2=checkJt2seInstallmentProduct($product_arr);
		        if($product_id or $product_id_jt2)
		        {
		            $order_dtls=$recharge_api->getOrderDtlsbyShopifyOrder($order_number);
                    // print_r($order_dtls);

                    $address_id=$order_dtls['orders'][0]['address_id'];//echo
                    $email=$order_dtls['orders'][0]['email'];//echo
                    $first_name=$order_dtls['orders'][0]['shipping_address']['first_name'];//echo
                    $last_name=$order_dtls['orders'][0]['shipping_address']['last_name'];//echo
                    $phone=$order_dtls['orders'][0]['shipping_address']['phone'];//echo
                    $created_at=date('Y-m-d',strtotime($order_dtls['orders'][0]['created_at']));//echo

                    $full_name=$first_name.' '.$last_name;

                    $arr['table']=USERTABLE;
                    $arr['selector']="id";
                    $arr['condition']="where email='".$email."'";
                    $getUserDtls=$db->Select($arr);
                    // print_r($getUserDtls);
                    if(count($getUserDtls)>0)
                    {
                        // echo "string";
                        $user_id=$getUserDtls[0]['id'];//echo
                    }
                    else
                    {
                        $user_arr=array("fullName"=>$full_name,"email"=>$email,"phoneNumber"=>$phone);
                        //print_r($user_arr);
                        $user_id=$db->Insert(USERTABLE,$user_arr);//echo
                    }

                    $arr['table']=REFURBEDACTIVATION;
                    $arr['selector']="id";
                    $arr['condition']="where address_id='".$address_id."'";
                    $getrefurbed=$db->Select($arr);
                    // print_r($getrefurbed);

                    if(count($getrefurbed)==0)
                    {
                        $device_type='';
                        $refurbed_arr=array();

                        if($product_id==8074743152861)
                        {
                                $device_type='refurbed';
                                $pid=8074743152861;
                        }
                        else if($product_id_jt2==8173820575965)
                        {
                                $device_type='jt2se_ins';
                                $pid=8173820575965;
                        }

                        $refurbed_arr=array("address_id"=>$address_id,"order_number"=>$order_number,"shopify_product_id"=>$pid,"user_id"=>$user_id,'payment_date'=>$created_at,"shopify_order_id"=>$shopify_order_id,"device_type"=>$device_type,'webhook'=>1);

                        //print_r($user_arr);
                        // echo $refurb_id=$db->Insert(REFURBEDACTIVATION,$refurbed_arr);
                        $refurb_id=$db->Insert(REFURBEDACTIVATION,$refurbed_arr);
                        if(!empty($refurb_id) && $refurb_id>=1){
                            echo "success";
                        } else {
                            echo "error";
                        }

                    } else {
                        echo "addressid already exists";
                    }

            
                }

        }

}


    $orderfile = fopen("shipstation_webhook_manual.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);

//$data = json_encode($data);
//print_r($arr);



?>