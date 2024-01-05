<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for Gigs API Call
 */

namespace Application;

//error_reporting(E_ALL);

//ini_set( 'display_errors', '1' );
@ob_start();
@session_start();


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';
require_once 'TelnyxHttp.php';

use Application\TelnyxHttp;


class TelnyxApi
{

	function __construct() 
	{

		return;

	}

	public function getSimCardDtls($iccid)
	{
		$Http=new TelnyxHttp();

		$endpoint="sim_cards?filter[iccid]=".$iccid;
		$sim_dtls=$Http->Get($endpoint);
		$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls_arr;
	}
	
	public function deleteSimCard($iccid)
	{
		
		$Http=new TelnyxHttp();

		$endpoint1="sim_cards?filter[iccid]=".$iccid;
		$get_sim_dtls=$Http->Get($endpoint1);
		$sim_dtls_arr=json_decode($get_sim_dtls,true);
		//print_r($sim_dtls_arr);
		if(isset($sim_dtls_arr['data']) and count($sim_dtls_arr['data'])>0)
		{

			 $sim_id=$sim_dtls_arr['data'][0]['id'];
			 $endpoint="sim_cards/".$sim_id;
			 $sim_dtls=$Http->Delete($endpoint);
			 $sim_dtls_arr=json_decode($sim_dtls,true);
			
		}
		
		
		

		
		return $sim_dtls_arr;
	}
	
	public function registerSimCard($registration_code)
	{
		$Http=new TelnyxHttp();
		$data=array();
		$data["registration_codes"]=[$registration_code];

		$endpoint="actions/register/sim_cards";
		$sim_dtls=$Http->Post($endpoint,$data);
		//print_r($sim_dtls);
		
		$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls_arr;
	}

	

}

// $recharge=new RechargeApi();
// $dv=$recharge->findDevicebyIMEI('867798041154809');
// print_r($dv);
?>