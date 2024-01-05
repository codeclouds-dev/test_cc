<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for Gigs API Call
 */
namespace Application;

include_once  'Database.php';
use Application\Database;


error_reporting(E_ALL);

ini_set( 'display_errors', '1' );
@ob_start();
@session_start();


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';
require_once 'CosmoNetworkHttp.php';

use Application\SpeedtalkHttp;


class CosmoNetworkApi
{

	function __construct() 
	{

		return;

	}

	public function getAuthToken()
	{
		$Http=new CosmoNetworkHttp();
		$endpoint='token';
		$data['username']=COSMOSIP_USERNAME;
		$data['password']=COSMOSIP_PASSWORD;

		$sim_dtls=$Http->PostToken($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	

	public function defaultNetworkType($data=array(),$apikey)
	{
		$Http=new CosmoNetworkHttp();
		$endpoint='network/defaultNetwork';
		$sim_dtls=$Http->Post($endpoint,$data,$apikey);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	
	public function getNetworkType($data=array(),$apikey)
	{
		$Http=new CosmoNetworkHttp();
		$endpoint='activation/getNetwork';
		$sim_dtls=$Http->Post($endpoint,$data,$apikey);

		$checkerror=$this->checkAnyCosmoNetworkError($data,$sim_dtls);
		
		if(is_array($checkerror))
		{
			//return standard network type
			return $checkerror;
		}
		else
		{
			return $sim_dtls;
		}
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		
	}
	
	public function checkAnyCosmoNetworkError($data,$array)
	{
		
		if(array_key_exists('error_message', $array))
		{

			//print_r($data);
			$db=new Database();
			$device_arr=array();
		    $device_arr['table']=DEVICETABLE;
		    $device_arr['selector']="id";
		    $device_arr['condition']="where imei='".$data['imei']."'";
		    $getDeviceDtls=$db->Select($device_arr);
		    if(count($getDeviceDtls)>0)
		    {
		    	 $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$array['api'],"response"=>json_encode($array),'data'=>$array['payload']);
				 //print_r($api_log_arr);
				 $db->Insert(APILOG,$api_log_arr);
		    }
			
		    $array_new=array_merge($array,array("default_call_network"=>"standard"));
			//return array("default_call_network"=>"standard");
			return $array_new;
		}
	}

	public function setActivation($data,$apikey)
	{
		
		$Http=new CosmoNetworkHttp();
		$endpoint='activation/setActivation';
		$sim_dtls=$Http->Post($endpoint,$data,$apikey);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
		
	}
	
	public function setPurchase($data,$apikey)
	{
		
		$Http=new CosmoNetworkHttp();
		$endpoint='activation/setPurchase';
		$sim_dtls=$Http->Post($endpoint,$data,$apikey);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
		
	}

}

//$CosmoApi=new CosmoApi();





?>