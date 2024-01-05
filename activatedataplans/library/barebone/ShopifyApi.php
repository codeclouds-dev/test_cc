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
require_once 'ShopifyHttp.php';

use Application\ShopifyHttp;


class ShopifyApi
{

	function __construct() 
	{

		return;

	}

	public function getOrder($order_id,$data)
	{
		$Http=new ShopifyHttp();

		$endpoint='orders/='.$order_id.'.json';
		$order_dtls=$Http->Get($endpoint,$data);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
	public function getOrderDetails($shopify_order_id)
	{
		$Http=new ShopifyHttp();

		$endpoint='orders/'.$shopify_order_id.'.json';
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
	public function createTag($shopify_order_id,$data)
	{
		$Http=new ShopifyHttp();

		$endpoint='orders/'.$shopify_order_id.'.json';
		$order_dtls=$Http->Put($endpoint,$data);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	public function getOrderDetailsbyOrderNo($shopify_order_no)
	{
		$Http=new ShopifyHttp();

		$endpoint='orders.json?name='.$shopify_order_no.'&status=any';
		$order_dtls=$Http->Get($endpoint);
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
	

}

// $recharge=new RechargeApi();
// $dv=$recharge->findDevicebyIMEI('867798041154809');
// print_r($dv);
?>