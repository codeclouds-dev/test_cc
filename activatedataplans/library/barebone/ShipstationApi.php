<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for Shipstation API Call
 */
namespace Application;

include_once  'Database.php';
use Application\Database;


error_reporting(E_ALL);

ini_set( 'display_errors', '1' );
@ob_start();
@session_start();


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';
require_once 'ShipstationHttp.php';

use Application\ShipstationHttp;


class ShipstationApi
{

	function __construct() 
	{

		return;

	}


	public function getOrderDetails($order_no)
	{
		$Http=new ShipstationHttp();
		$endpoint='orders?orderNumber='.$order_no;
		$order_dtls=$Http->Get($endpoint);
		//$sim_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls;
	}
	public function shipstationWebhookResourceURL($resource_url)
	{
		$Http=new ShipstationHttp();
		$order_dtls=$Http->GetResource($resource_url);
		//$sim_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls;
	}
	


}

$ShipstationApi=new ShipstationApi();
$ShipstationApi->getOrderDetails("145564");




?>