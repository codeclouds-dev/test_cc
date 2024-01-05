<?php 


//header('Access-Control-Allow-Origin: *');

@session_start();
@ob_start();

//print_r($_SESSION);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');


include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php' ;



use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\SpeedtalkApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$db=new Database();
$speedtalkapi=new SpeedtalkApi();



$data = file_get_contents('php://input');
$arr=json_decode($data,true);
$addr_id=$arr['subscription']['address_id'];
//$addr_id=97578886;

if($addr_id!="")
{
	$device_arr=array();
    $device_arr['table']=DEVICETABLE;
    $device_arr['selector']="id,provider,phone_number,user_id,status";
    $device_arr['condition']="where address_id='".$addr_id."' and status!='7'";

    $getDeviceDtls=$db->Select($device_arr);
	//print_r($getDeviceDtls);
    if(count($getDeviceDtls)>0)
    {

    	 $recharge_cancellation=array("device_id"=>$getDeviceDtls[0]['id'],"status"=>0,"data"=>$data);
                                
         $last_id=$db->Insert('recharge_cancellation',$recharge_cancellation);
         $updated_date=date('Y-m-d H:i:s');
      	$db->Update(DEVICETABLE,array('status'=>'6','updated_date'=>$updated_date),array("where id='".$getDeviceDtls[0]['id']."'"));
    }

}
   



	// $textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."tttttttttttttt";
	 $textDataOrder=PHP_EOL."arr => ".$data."addr_id==".$addr_id;
    	
 	$orderfile = fopen("webhook_response_subscription_cancellation.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);


?>