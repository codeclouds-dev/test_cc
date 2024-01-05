<?php 
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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'ShipstationApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\ShipstationApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$ShipstationApi=new ShipstationApi();



echo $query="select * from refurbed_activation where  status=4 and user_id!=6 and order_number in (
167178,167154,167602,167930,167929,167926,169269,174325,181624,185258,186044,188083,190134,190132,190193,190242,190267,190687,190688,190708,190715,190889,191971,192462) order by id asc limit 1";

$arr=array();
$arr['query']=$query;
$result=$db->SelectRaw($arr);
print_r($result);

if(count($result)>0)
{
echo "string";

    $res=$ShipstationApi->getOrderDetails($result[0]['order_number']);
    //print_r($res);

    echo $imei=trim($res['orders'][0]['advancedOptions']['customField1']);
    echo strlen($imei);
                            $db->Update(REFURBEDACTIVATION,array('status'=>12,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));


   if(strlen($imei)==15)
   {
        // echo "string";


        if($result[0]['device_type']=='refurbed')
        {
                $arr['table']=DEVICETABLE;
                $arr['selector']="id";
                $arr['condition']="where imei='".$imei."' and refurbed=1 and status not in('2','5')";
                $getdevicedtls=$db->Select($arr);
                //print_r($getdevicedtls);

                if(count($getdevicedtls)>0)
                {


                    $arr['table']=DEVICETABLE;
                    $arr['selector']="id";
                    $arr['condition']="where address_id=".$result[0]['address_id']."";
                    $getaddress=$db->Select($arr);
                    if(count($getaddress)==0)
                    {

                      $db->Update(DEVICETABLE,array('status'=>5,'user_id'=>$result[0]['user_id'],'address_id'=>$result[0]['address_id'],'shopify_product_id'=>$result[0]['shopify_product_id'],'payment_date'=>$result[0]['payment_date'],'shopify_order_number'=>$result[0]['order_number']),array("where imei='".$imei."' and refurbed=1"));
                    }

                     

                    $db->Update(REFURBEDACTIVATION,array('status'=>11,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));
                                                        
                }

        }
        // else if($result[0]['device_type']=='jt2se_ins')
        else {

                $arr['table']=DEVICETABLE;
                $arr['selector']="id";
                $arr['condition']="where imei='".$imei."' and status not in('2','5')";
                $getdevicedtls=$db->Select($arr);
                //print_r($getdevicedtls);

                if(count($getdevicedtls)>0)
                {

            echo "string2";

                $arr['table']=DEVICETABLE;
                $arr['selector']="id";
                $arr['condition']="where address_id=".$result[0]['address_id']."";
                $getaddress=$db->Select($arr);
                if(count($getaddress)==0)
                {

                  $db->Update(DEVICETABLE,array('status'=>5,'user_id'=>$result[0]['user_id'],'address_id'=>$result[0]['address_id'],'shopify_product_id'=>$result[0]['shopify_product_id'],'payment_date'=>$result[0]['payment_date'],'shopify_order_number'=>$result[0]['order_number']),array("where imei='".$imei."'"));
                }

                 

                $db->Update(REFURBEDACTIVATION,array('status'=>11,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));
            }
        }
   }
    

}




?>