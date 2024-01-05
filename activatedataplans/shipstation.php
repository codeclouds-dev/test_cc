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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'TelnyxApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\ShipstationApi;
use Application\TelnyxApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$ShipstationApi=new ShipstationApi();
$TelnyxApi=new TelnyxApi();


if(isset($_GET['var']) and $_GET['var']==0)
{
    $where=" date_add(created_date, INTERVAL 5 MINUTE) < NOW() and status=0";
    
}
else if(isset($_GET['var']) and $_GET['var']==1)
{
        $where=" date_add(created_date, INTERVAL 1 HOUR) < NOW()  and status=1";

}
else if(isset($_GET['var']) and $_GET['var']==2)
{
        $where=" date_add(created_date, INTERVAL 2 HOUR) < NOW()   and status=2";

}
else if(isset($_GET['var']) and $_GET['var']==3)
{
        $where=" date_add(created_date, INTERVAL 3 HOUR) < NOW()  and status=3";

}

echo $query="select * from refurbed_activation where  ".$where;

$arr=array();
$arr['query']=$query;
$result=$db->SelectRaw($arr);
// print_r($result);

$getdevicedtls='';

if(count($result)>0)
{

   $db->Update(REFURBEDACTIVATION,array('status'=>$result[0]['status']+1,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));

    $res=$ShipstationApi->getOrderDetails($result[0]['order_number']);
    //print_r($res);

    echo $imei=trim($res['orders'][0]['advancedOptions']['customField1']);
    echo strlen($imei);

    $whereImei = "imei = '".$imei;
    $getIccidQuery = "select id,sim_no from device_details_new where ".$whereImei."' ";
    $arr1 = array();
    $arr1['query']=$getIccidQuery;
    $resIccid=$db->SelectRaw($arr1);
    $device_id = $resIccid[0]['id'];
    $iccid = $resIccid[0]['sim_no'];

    /*Check if device-id is already present in activate_out_of_flow_devices table (start)*/
    $whereDeviceId = "device_id = '".$device_id;
    $getDeviceQuery = "select id,device_id from activate_out_of_flow_devices where ".$whereDeviceId."' ";
    $arr2 = array();
    $arr2['query']=$getDeviceQuery;
    $resDeviceData=$db->SelectRaw($arr2);
    /*Check if device-id is already present in activate_out_of_flow_devices table (end)*/
    

    if(strlen($imei)==15)
    {
       
            $chkActivation = $TelnyxApi->getSimCardDtls($iccid);/*checking if sim is already activated in TelnyxAPI*/

            if($result[0]['device_type']=='refurbed')
            {
                    $arr['table']=DEVICETABLE;
                    $arr['selector']="id";
                    $arr['condition']="where imei='".$imei."' and refurbed=1";
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

                        //if result not empty from TenyxAPI (start) 
                        if(!empty($chkActivation["data"]) && count($chkActivation["data"])>0) {
                            $db->Update(REFURBEDACTIVATION,array('status'=>11,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));

                            if(count($resDeviceData) == 0){//to prevent double entry of device in table
                                $db->Insert(ACTIVATEOUTOFFLOWDEVICES,array('device_id'=>$device_id));
                            }
                            
                        } else {
                            $db->Update(REFURBEDACTIVATION,array('status'=>10,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));
                        }
                        //if result not empty from TenyxAPI (end)                                                             
                    }

            }
            // else if($result[0]['device_type']=='jt2se_ins')
            else {

                    $arr['table']=DEVICETABLE;
                    $arr['selector']="id";
                    $arr['condition']="where imei='".$imei."'";
                    $getdevicedtls=$db->Select($arr);

                    if(count($getdevicedtls)>0)
                    {

                        $arr['table']=DEVICETABLE;
                        $arr['selector']="id";
                        $arr['condition']="where address_id=".$result[0]['address_id']."";
                        $getaddress=$db->Select($arr);
                        if(count($getaddress)==0)
                        {

                            $db->Update(DEVICETABLE,array('status'=>5,'user_id'=>$result[0]['user_id'],'address_id'=>$result[0]['address_id'],'shopify_product_id'=>$result[0]['shopify_product_id'],'payment_date'=>$result[0]['payment_date'],'shopify_order_number'=>$result[0]['order_number']),array("where imei='".$imei."'"));
                        }

                        //if result not empty from TenyxAPI (start) 
                        if(!empty($chkActivation["data"]) && count($chkActivation["data"])>0) {
                            $db->Update(REFURBEDACTIVATION,array('status'=>11,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));

                            if(count($resDeviceData) == 0){//to prevent double entry of device in table
                                $db->Insert(ACTIVATEOUTOFFLOWDEVICES,array('device_id'=>$device_id));
                            }
                            
                        } else {
                            $db->Update(REFURBEDACTIVATION,array('status'=>10,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$result[0]['id'].""));
                        }
                        //if result not empty from TenyxAPI (end)      

                    }
            }        

    }
    

}


$textDataOrder=PHP_EOL."arr => shipstation => ".print_r($getdevicedtls,true);
    
    $orderfile = fopen("shipstation.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);

//$data = json_encode($data);
//print_r($arr);



?>