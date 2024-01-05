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
    $device_arr['condition']="where address_id='".$addr_id."'";

    $getDeviceDtls=$db->Select($device_arr);
	//print_r($getDeviceDtls);
    if(count($getDeviceDtls)>0)
    {

    	$user_arr=array();
	    $user_arr['table']=USERTABLE;
	    $user_arr['selector']="email";
	    $user_arr['condition']="where id='".$getDeviceDtls[0]['user_id']."'";

	    $getUserDtls=$db->Select($user_arr);
	    //echo $getUserDtls[0]['email'];
	    // if($getUserDtls[0]['email']=='vijaya.jha@codeclouds.com' or $getUserDtls[0]['email']=='ssondagar@gmail.com')
	    // {
	    	if(strtolower($getDeviceDtls[0]['provider'])=='speedtalk' and $getDeviceDtls[0]['status']==2)
	    	{
	    		//echo "string2";
	    		if($getDeviceDtls[0]['phone_number']!="")
	    		{
	    			$res=$speedtalkapi->stAutorefillDeactivate($getDeviceDtls[0]['phone_number']);
	    			//print_r($res);
	    			if($res['ret']==0)
	    			{
	    				//echo "string";
	    				$updated_date=date('Y-m-d H:i:s');
	    				$db->Update(DEVICETABLE,array('status'=>'6','updated_date'=>$updated_date),array("where id='".$getDeviceDtls[0]['id']."'"));
	     
	    			}
	    			else
	    			{
	    				
	    				$updated_date=date('Y-m-d H:i:s');
	    				$db->Update(DEVICETABLE,array('status'=>'6','updated_date'=>$updated_date),array("where id='".$getDeviceDtls[0]['id']."'"));
	    				
	    				   	$dev_arr=array();
	                        $dev_arr['imei']=$getDeviceDtls[0]['imei'];
	                        $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
	                        $dev_arr['email']=$getUserDtls[0]['email'];
	                        // print_r($dev_arr);
	                        // print_r($res);
	                        
	    				$arr=alert("shil@cosmotogether.com",$dev_arr,$res,'stAutorefill Deactivate');

	    			}
	    			  $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$res['api'],"response"=>$res['retmess']);
                            
			          //print_r($api_log_arr);
			          $db->Insert(APILOG,$api_log_arr);
	    		}
	    		else
	    		{
	    			$updated_date=date('Y-m-d H:i:s');
	    			$db->Update(DEVICETABLE,array('status'=>'6','updated_date'=>$updated_date),array("where id='".$getDeviceDtls[0]['id']."'"));
	    		}
	    		
	    	}
	    	else
	    	{
	    		$updated_date=date('Y-m-d H:i:s');
	    		$db->Update(DEVICETABLE,array('status'=>'6','updated_date'=>$updated_date),array("where id='".$getDeviceDtls[0]['id']."'"));
	    	}
	   // }
    	
      
    }

}
   



	// $textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."tttttttttttttt";
	 $textDataOrder=PHP_EOL."arr => ".$data."addr_id==".$addr_id;
    	
 	$orderfile = fopen("webhook_response_subscription_cancellation.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);


?>