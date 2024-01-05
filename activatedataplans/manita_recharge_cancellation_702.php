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

$start=$_GET['start'];
$end=$_GET['end'];


 echo $query="select imei_manita_recharge_cancellation.* FROM `imei_manita_recharge_cancellation` join device_details_new on device_details_new.imei=imei_manita_recharge_cancellation.imei WHERE device_details_new.status='6' and imei_manita_recharge_cancellation.imei not in('867798043140053','867798043106856','867798043106856','867798043117044','867798043131136','867798043117663') and remarks!='No Event after cancellation' and imei_manita_recharge_cancellation.status=0 and imei_manita_recharge_cancellation.id between ".$start." and ".$end." order by imei_manita_recharge_cancellation.id asc limit 1";

//  echo $query="select imei_manita_recharge_cancellation.* FROM `imei_manita_recharge_cancellation` join device_details_new on device_details_new.imei=imei_manita_recharge_cancellation.imei WHERE device_details_new.status='6' and imei_manita_recharge_cancellation.imei not in('867798043140053','867798043106856','867798043106856','867798043117044','867798043131136','867798043117663') and remarks!='No Event after cancellation' and imei_manita_recharge_cancellation.status=1 and imei_manita_recharge_cancellation.id between ".$start." and ".$end." order by imei_manita_recharge_cancellation.id asc limit 1
// ";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);


if(count($getdevdtls)>0)
{
		//print_r($arr);
	$db->update('imei_manita_recharge_cancellation',array('status'=>$getdevdtls[0]['status']+1,"updated_date"=>date('Y-m-d H:i:s')),array("where id='".$getdevdtls[0]['id']."'"));

	$get_authtoken_network=$CosmoSipApi->getAuthToken($getdevdtls[0]['imei']);

	
		  //echo "string";
		  $set_cancel_arr=array();
		  $set_cancel_arr['imei']=$getdevdtls[0]['imei'];
		  $getauthtoken_api=$CosmoNetworkApi->getAuthToken();

		  // $getnetworktype=$CosmoNetworkApi->getNetworkType(array("imei"=>$getdevdtls[0]['imei']),$getauthtoken_api['accessToken']);
		  // $network=$getnetworktype['default_call_network'];

          $res2=$CosmoNetworkApi->getCurrentNetworkType(array("imei"=>$getdevdtls[0]['imei']),$getauthtoken_api['accessToken']);
        	//print_r($res2);
          $network=$res2['current_call_network'];

            $checksip=$CosmoSipApi->checkSIP(array("imei"=>$getdevdtls[0]['imei']),$getauthtoken_api['accessToken']);


 			$sip=$checksip['sip'];
          $db->Update("device_details_new",array('current_call_network_cosmo'=>$network,'response'=>json_encode($checksip)),array("where imei='".$getdevdtls[0]['imei']."'"));

		  if($sip==1)
		  {


		  	 $set_cancel=$CosmoSipApi->cancelSip($set_cancel_arr,$get_authtoken_network['accessToken']);
		  	//print_r($set_cancel);
			 
		
		  		$db->update('imei_manita_recharge_cancellation',array('network_cosmo'=>$network,'status'=>4,"updated_date"=>date('Y-m-d H:i:s'),'api'=>$set_cancel['api'],"data"=>$set_cancel['payload'],"response"=>json_encode($set_cancel)),array("where id='".$getdevdtls[0]['id']."'"));

		 }
		 
		

	
	

	

}


?>