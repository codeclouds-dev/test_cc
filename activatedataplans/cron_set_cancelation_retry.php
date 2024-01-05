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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoNetworkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\CosmoNetworkApi;
use Application\CosmoSipApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$CosmoNetworkApi=new CosmoNetworkApi();
$CosmoSipApi=new CosmoSipApi();

echo $query="select pending.*,imei,sim_no,email,device_details_new.id as device_id,address_id,network_type,pending.status as status from pending join device_details_new on device_details_new.id=pending.device_id join user_mstr on user_mstr.id=device_details_new.user_id where date(created_date)='".date('Y-m-d')."' and pending.status<=2 and pending.id>2510 and api='cancel cosmo' order by id asc limit 1";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);


if(count($getdevdtls)>0)
{
		//print_r($arr);
	  if(strrpos($getdevdtls[0]['imei'],'-duplicate'))
                              {

                              	$db->update('recharge_cancellation',array('cosmo_status'=>9,"updated_date"=>date('Y-m-d')),array("where id='".$getdevdtls[0]['id']."'"));
                                       $check_imei_arr=array();
                            			$check_imei_arr['table']='imei_duplicate_cancel_req';
			                            $check_imei_arr['selector']='id';
			                            $check_imei_arr['condition']="where device_id='".$getdevdtls[0]['device_id']."'";
			                            
			                            $checkIMEIExists=$db->Select($check_imei_arr);
			                            if(count($checkIMEIExists)==0)
			                            {

												  $api_log_arr=array("device_id"=>$getdevdtls[0]['device_id'],"imei"=>$getdevdtls[0]['imei'],"address_id"=>$getdevdtls[0]['address_id']);
                                        
				                                   //print_r($api_log_arr);
				                                   $db->Insert("imei_duplicate_cancel_req",$api_log_arr);
			                            }

                              }
                              else
                              {
	$CosmoNetworkApi=new CosmoNetworkApi();
	$get_authtoken_network=$CosmoNetworkApi->getAuthToken();
	$api_log_arr=array("device_id"=>$getdevdtls[0]['device_id'],"api"=>$get_authtoken_network['api'],"response"=>json_encode($get_authtoken_network),'data'=>$get_authtoken_network['payload']);
	//print_r($api_log_arr);
	$db->Insert(APILOG,$api_log_arr);

	  $dev_arr=array();
			$dev_arr['device_id']=$getdevdtls[0]['device_id'];
			$dev_arr['imei']=$getdevdtls[0]['imei'];
			$dev_arr['iccid']=$getdevdtls[0]['sim_no'];
			$dev_arr['email']=$getdevdtls[0]['email'];
			$dev_arr['subject']='COSMO Network Set Cancelation Error';


	$res_auth=checkNetworkApiResponseNew($get_authtoken_network,$dev_arr);
	$db->update('pending',array('status'=>$getdevdtls[0]['status']+1,"updated_date"=>date('Y-m-d')),array("where id='".$getdevdtls[0]['id']."'"));

	if($res_auth!=true)
	{

		  echo "string";
		  $set_pur_arr=array();
		  $set_pur_arr['imei']=$getdevdtls[0]['imei'];
		  $set_pur_arr['activation']=false;
		 
		  $setpurchase=$CosmoNetworkApi->setActivation($set_pur_arr,$get_authtoken_network['accessToken']);
		  print_r($setpurchase);
		  $api_log_arr=array("device_id"=>$getdevdtls[0]['device_id'],"api"=>$setpurchase['api'],"response"=>json_encode($setpurchase),'data'=>$setpurchase['payload']);
		  //print_r($api_log_arr);
		  $db->Insert(APILOG,$api_log_arr);
		  $res=checkNetworkApiResponseNew($setpurchase,$dev_arr);
		  if($res==true)
		  {
		  // 	 echo "string2";
		  		if($getdevdtls[0]['status']==2)
				{
				
					
					$mail->sendAlertTelnyx($dev_arr,$setpurchase);
				}
		  }
		  else
		  {
		  	 echo "string3";
		  		$db->update('pending',array('status'=>4,"updated_date"=>date('Y-m-d')),array("where id='".$getdevdtls[0]['id']."'"));

		  }
	}
	else
	{
			
		if($getdevdtls[0]['status']==2)
		{

		
			
			$mail->sendAlertTelnyx($dev_arr,$get_authtoken_network);
		}
	}
	
}
	

}


?>