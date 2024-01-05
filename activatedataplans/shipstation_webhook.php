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


$data = file_get_contents('php://input');
$arr=json_decode($data,true);

$textDataOrder=PHP_EOL."arr => shipstation => ".$data."date ".date('Y-m-d H:i:s');
$textDataOrder.=PHP_EOL."arr => shipstation array => ".print_r($arr,true);
   $orderfile = fopen("shipstation_webhook.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);
if(isset($arr['resource_url']))
{
        $result=$ShipstationApi->shipstationWebhookResourceURL($arr['resource_url']);
        // print_r($result);

        $order_number=$result['shipments'][0]['orderNumber'];
        $shopify_order_id=$result['shipments'][0]['orderKey'];

        /*Test purpose*/
        // $order_number=$_GET['orderNumber'];
        // $shopify_order_id=$_GET['orderKey'];


        $shopify_res=$ShopifyApi->getOrderDetails($shopify_order_id);
        //print_r($shopify_res);

        $product_arr=$shopify_res['order']['line_items'];
        // print_r($product_arr);
        $product_id=checkRefurbedProduct($product_arr);
        $product_id_jt2=checkJt2seInstallmentProduct($product_arr);


        /* Check if data already exists in table */
        if((isset($shopify_order_id)) && (!empty($shopify_order_id)))
        {

               $arr['table']=REFURBEDACTIVATION;
               $arr['selector']="id";
               $arr['condition']="where order_number='".$order_number."'";
               $getdevicedtls=$db->Select($arr);

               /*If data does not exist in table , only then insert (start)*/
               if(count($getdevicedtls)<=0) {

                    /* Insert data function (start) */
                    if($product_id or $product_id_jt2)
                    {
                            $order_dtls=$recharge_api->getOrderDtlsbyShopifyOrder($order_number);
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

                            $arr['table']=REFURBEDACTIVATION;
                            $arr['selector']="id";
                            $arr['condition']="where address_id='".$address_id."'";
                            $getrefurbed=$db->Select($arr);
                           // print_r($getrefurbed);

                            if(count($getrefurbed)==0)
                            {
                                   $device_type='';
                                   $refurbed_aRrr=array();
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
                                   $refurbed_arr=array("address_id"=>$address_id,"order_number"=>$order_number,"shopify_product_id"=>$pid,"user_id"=>$user_id,'payment_date'=>$created_at,"shopify_order_id"=>$shopify_order_id,"device_type"=>$device_type,'webhook'=>0);

                                   //print_r($user_arr);
                                   echo $refurb_id=$db->Insert(REFURBEDACTIVATION,$refurbed_arr);
                            }
                    }
                    /* Insert data function (end) */

                } else {
                    //Write in log that this record already exists
                    $textDataOrder.=PHP_EOL."This Order Number already exists in table.";       
               }
               /*If does not exist in table, only then insert (end)*/
        } 
        /*End of inserting data after checking*/

}


 

//$data = json_encode($data);
//print_r($arr);



?>