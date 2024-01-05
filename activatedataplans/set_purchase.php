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
$address_id=file_get_contents("set_purchase.txt");

// echo $query="select * from device_details_new where date(payment_date)='".date('Y-m-d')."' and address_id!='' and address_id>$address_id order by id asc limit 1";
echo $query="select device_details_new.*,email from device_details_new join user_mstr on user_mstr.id=device_details_new.user_id where  address_id!='' and address_id>$address_id  order by address_id asc limit 1";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);


if(count($getdevdtls)>0)
{

	$device_id=$getdevdtls[0]['id'];

	echo "string";
	$getauthtoken=$CosmoNetworkApi->getAuthToken();
	 $api_log_arr=array("device_id"=>$getdevdtls[0]['id'],"api"=>$getauthtoken['api'],"response"=>json_encode($getauthtoken),'data'=>$getauthtoken['payload']);
		//print_r($api_log_arr);
		$db->Insert(APILOG,$api_log_arr);
	$dev_arr=array();
	$dev_arr['device_id']=$getdevdtls[0]['id'];
	$dev_arr['imei']=$getdevdtls[0]['imei'];
	$dev_arr['iccid']=$getdevdtls[0]['sim_no'];
	$dev_arr['email']=$getdevdtls[0]['email'];
	$dev_arr['subject']='COSMO Network Error';

	$res1=checkNetworkApiResponseNew($getauthtoken,$dev_arr);
	if($res1)
	{

					$arr=array();
			        $arr['table']=PENDING;
			        $arr['selector']="id";
			        $arr['condition']="where device_id='".$device_id."' and api='set purchase'";
			        $getactivationdtls=$db->Select($arr);
			        //print_r($getactivationdtls);

			        if(count($getactivationdtls)==0)
			        {
			        			
		            	 $actv_pend=array("device_id"=>$device_id,"api"=>"set purchase");
						 //print_r($actv_pend);
						 $db->Insert(PENDING,$actv_pend);
			        }
							
	}
	else
	{
		$setpurchaseres=$CosmoNetworkApi->setPurchase(array("imei"=>$getdevdtls[0]['imei']),$getauthtoken['accessToken']);

		 $api_log_arr=array("device_id"=>$getdevdtls[0]['id'],"api"=>$setpurchaseres['api'],"response"=>json_encode($setpurchaseres),'data'=>$setpurchaseres['payload']);
		//print_r($api_log_arr);
		$db->Insert(APILOG,$api_log_arr);
		$res=checkNetworkApiResponseNew($setpurchaseres,$dev_arr);

		if($res)
		{

						$arr=array();
				        $arr['table']=PENDING;
				        $arr['selector']="id";
				        $arr['condition']="where device_id='".$device_id."' and api='set purchase'";
				        $getactivationdtls=$db->Select($arr);
				        //print_r($getactivationdtls);

				        if(count($getactivationdtls)==0)
				        {
				        			
			            	 $actv_pend=array("device_id"=>$device_id,"api"=>"set purchase");
							 //print_r($actv_pend);
							 $db->Insert(PENDING,$actv_pend);
				        }
								
		}
	}
	
	

}
if(count($getdevdtls)>0)
{

	if($getdevdtls[0]['address_id']!="")
	{
		file_put_contents("set_purchase.txt",$getdevdtls[0]['address_id']);

	}
	
}

?>