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
require_once 'FreshDeskHttp.php';

use Application\SpeedtalkHttp;


class FreshDeskApi
{

	function __construct() 
	{

		return;

	}

	public function createTicket($data)
	{
		$Http=new CosmoHttp();
		$endpoint='tickets';
		$sim_dtls=$Http->Post($endpoint,$data);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	

	

}

//$CosmoApi=new CosmoApi();





?>