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
require_once 'RechargeHttp.php';

use Application\RechargeHttp;


class RechargeApi
{

	function __construct() 
	{

		return;

	}

	public function getOrder($charge_id)
	{
		$Http=new RechargeHttp();

		$endpoint='orders?charge_id='.$charge_id;
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
	public function getChargeIdbyAddrId($address_id)
	{
		$Http=new RechargeHttp();

		$endpoint='orders?address_id='.$address_id;
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	public function getfirstChargebyAddrId($address_id)
	{
		$Http=new RechargeHttp();

		$endpoint='orders?address_id='.$address_id.'&sort_by=id-asc';
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	public function listSubscription($address_id)
	{
		$Http=new RechargeHttp();

		$endpoint='subscriptions?address_id='.$address_id;
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}

	public function cancelSubscription($subscription_id)
	{
		$Http=new RechargeHttp();

		$endpoint='subscriptions/'.$subscription_id.'/cancel';
		$order_dtls=$Http->Post($endpoint,array('cancellation_reason'=>'other reason'));
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	public function getUpcomingOrder($startDate, $endDate){
		$Http=new RechargeHttp();

		$endpoint='charges?scheduled_at_min='.$startDate.'&scheduled_at_max='.$endDate.'&status=queued&limit=250';
		$order_dtls=$Http->getRecharge($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
		public function getOrderDtlsbyShopifyOrder($order_number){
		$Http=new RechargeHttp();

		$endpoint='orders?shopify_order_number='.$order_number;
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
	
	
}

// $recharge=new RechargeApi();
// $dv=$recharge->findDevicebyIMEI('867798041154809');
// print_r($dv);
?>