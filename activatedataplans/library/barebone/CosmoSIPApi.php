<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for Gigs API Call
 */

namespace Application;

error_reporting(E_ALL);

ini_set( 'display_errors', '1' );
@ob_start();
@session_start();


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';
require_once 'CosmoSipHttp.php';

use Application\SpeedtalkHttp;


class CosmoSipApi
{

	function __construct() 
	{

		return;

	}

	public function IMEIcheck($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='IMEIcheck';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	

	public function IMEIactivate($data=array())
	{
		$Http=new CosmoSipHttp();
		$endpoint='IMEIactivate';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	
	public function IMEIDeactivate($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='IMEIdisactivate';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function updateInternalStatus($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='UpdateInternalStatus';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function updateEmail($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='UpdateEmail';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function updateAddressId($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='UpdateAddressId';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function getDevice($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='GetDevice';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function getDevice2($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='GetDevice2';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function updateOnEmailMismatch($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='UpdateOnEmailMismatch';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	public function updateInternalStatus2($data)
	{
		$Http=new CosmoSipHttp();
		$endpoint='UpdateInternalStatus2';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	
	
	

}

//$CosmoApi=new CosmoApi();





?>