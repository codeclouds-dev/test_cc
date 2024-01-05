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

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\CosmoNetworkApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$CosmoNetworkApi=new CosmoNetworkApi();
$address_id=file_get_contents("set_cancelation.txt");

// echo $query="select * from device_details_new where date(payment_date)='".date('Y-m-d')."' and address_id!='' and address_id>$address_id order by id asc limit 1";
echo $query="select * from device_details_new where  address_id!='' and address_id>$address_id and status='6' order by id asc limit 1";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);


if(count($getdevdtls)>0)
{

	$device_id=$getdevdtls[0]['id'];

	echo "string";
	$getauthtoken=$CosmoNetworkApi->getAuthToken();
	$res1=checkNetworkApiResponse($getauthtoken);
	if($res1)
	{

					$arr_cancel=array();
			        $arr_cancel['table']=SETCANCELLATION;
			        $arr_cancel['selector']="id";
			        $arr_cancel['condition']="where device_id='".$device_id."'";
			        $getactivationdtls=$db->Select($arr_cancel);
			        //print_r($getactivationdtls);

			        if(count($getactivationdtls)==0)
			        {
			        			
		            	 $actv_pend=array("device_id"=>$device_id);
						 //print_r($actv_pend);
						 $db->Insert(SETCANCELLATION,$actv_pend);
			        }
							
	}
	else
	{
		
		$setactivation=$CosmoNetworkApi->setActivation(array("imei"=>$getdevdtls[0]['imei'],"activation"=>false),$getauthtoken['accessToken']);
		print_r($setactivation);
		$api_log_arr=array("device_id"=>$getdevdtls[0]['id'],"api"=>$setactivation['api'],"response"=>json_encode($setactivation),'data'=>$setactivation['payload']);
		//print_r($api_log_arr);
		$db->Insert(APILOG,$api_log_arr);
		$res=checkNetworkApiResponse($setactivation);

		if($res)
		{

						$arr1=array();
				        $arr1['table']=SETCANCELLATION;
				        $arr1['selector']="id";
				        $arr1['condition']="where device_id='".$device_id."'";
				        $getactivationdtls=$db->Select($arr1);
				        //print_r($getactivationdtls);

				        if(count($getactivationdtls)==0)
				        {
				        			
			            	 $actv_pend=array("device_id"=>$device_id);
							 //print_r($actv_pend);
							 $db->Insert(SETCANCELLATION,$actv_pend);
				        }
								
		}
	}
	
	

}
if(count($getdevdtls)>0)
{

	if($getdevdtls[0]['address_id']!="")
	{
		//file_put_contents("set_cancelation.txt",$getdevdtls[0]['address_id']);

	}
	
}

?>