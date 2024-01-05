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



	$device_arr=array();
    $device_arr['table']='cancellation_recharge';
    $device_arr['selector']="phone";
    $device_arr['condition']="where status=0 limit 15";

    $getDeviceDtls=$db->Select($device_arr);
print_r($getDeviceDtls);
    if(count($getDeviceDtls)>0)
    {
    	for($i=0;$i<15;$i++)
    	{

    		//echo $getDeviceDtls[$i]['phone'].'<br>';
    		 $res=$speedtalkapi->stAutorefillDeactivate($getDeviceDtls[$i]['phone']);
	     	 $db->Update('cancellation_recharge',array('status'=>1),array("where phone='".$getDeviceDtls[$i]['phone']."'"));

    	}
	   
    	
      
    }



?>