<?php 


//header('Access-Control-Allow-Origin: *');

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

$order_no=$arr['order_number'];
$shopify_order_id=$arr['id'];

// $email=$arr['email'];
$created_at=$arr['created_at'];
$product_arr=$arr['line_items'];
$product_id=checkRefurbedProduct($product_arr);
        $product_id_jt2=checkJt2seInstallmentProduct($product_arr);

$textDataOrder=PHP_EOL."data =>".$data."arr => ".print_r($product_arr,true)." order ".$order_no." product_id ".$product_id." product_id_jt2 ".$product_id_jt2;
    
    $orderfile = fopen("order_fullfillment.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);
    
if($product_id or $product_id_jt2)
{
        $order_dtls=$recharge_api->getOrderDtlsbyShopifyOrder($order_no);
        print_r($order_dtls);



        echo $address_id=$order_dtls['orders'][0]['address_id'];
        echo $email=$order_dtls['orders'][0]['email'];
        echo $first_name=$order_dtls['orders'][0]['shipping_address']['first_name'];
        echo $last_name=$order_dtls['orders'][0]['shipping_address']['last_name'];
        echo $phone=$order_dtls['orders'][0]['shipping_address']['phone'];
        echo $created_at=date('Y-m-d',strtotime($order_dtls['orders'][0]['created_at']));
        $phone = preg_replace( '/[^0-9]/', '', $phone );
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
                    $refurbed_arr=array();
                    $refurbed_arr=array("address_id"=>$address_id,"order_number"=>$order_no,"shopify_product_id"=>$pid,"user_id"=>$user_id,'payment_date'=>$created_at,"shopify_order_id"=>$shopify_order_id,"device_type"=>$device_type,'webhook'=>2);

                     echo $refurb_id=$db->Insert(REFURBEDACTIVATION,$refurbed_arr);
                }

    
}


   
?>