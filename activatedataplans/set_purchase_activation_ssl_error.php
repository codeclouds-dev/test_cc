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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\CosmoSipApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$CosmoSipApi=new CosmoSipApi();
$address_id=file_get_contents("set_cancelation.txt");

// echo $query="select * from device_details_new where date(payment_date)='".date('Y-m-d')."' and address_id!='' and address_id>$address_id order by id asc limit 1";
echo $query="select DISTINCT(device_id),device_details_new.* FROM `api_log` JOIN device_details_new on device_details_new.id=api_log.device_id WHERE response like '%SSL Connect%' and date(date_time)='2023-03-30' and device_id>54996 order by api_log.device_id asc limit 5";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);


if(count($getdevdtls)>0)
{

for($i=0;$i<sizeof($getdevdtls);$i++)
{
	$device_id=$getdevdtls[$i]['id'];

	echo "string";
	$getauthtoken=$CosmoSipApi->getAuthToken();
	print_r($getauthtoken);
	if($getdevdtls[$i]['address_id']!="")
	{

		$setpurchaseres=$CosmoSipApi->setPurchase(array("imei"=>$getdevdtls[$i]['imei']),$getauthtoken['accessToken']);
		print_r($setpurchaseres);
	}
	if($getdevdtls[$i]['status']==2)
	{

		$setActivation=$CosmoSipApi->setActivation(array("imei"=>$getdevdtls[$i]['imei'],"network"=>$getdevdtls[$i]['network_type'],'activation'=>true),$getauthtoken['accessToken']);
		print_r($setActivation);

	}
	else if($getdevdtls[$i]['status']==6)
	{
		$setactivation=$CosmoSipApi->setActivation(array("imei"=>$getdevdtls[$i]['imei'],"activation"=>false,"network"=>$getdevdtls[$i]['network_type']),$getauthtoken['accessToken']);
		print_r($setactivation);

	}
	

  	$textDataOrder=PHP_EOL.$device_id;
    
 	$orderfile = fopen("ssl_error_device_id.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);

		
}
	

}

?>