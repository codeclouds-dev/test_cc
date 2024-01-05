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
require_once 'RechargeWebhookHttp.php';

use Application\RechargeWebhookHttp;


class RechargeWebhookApi
{

	function __construct() 
	{

		return;

	}

	
	public function createWebhook($data)
	{
		$Http=new RechargeWebhookHttp();

		$endpoint='webhooks';
		$createWebhook=$Http->WebhookPost($endpoint,$data);
		$webhook_dtls=json_decode($createWebhook,true);
		return $webhook_dtls;
	}

	public function testWebhook($data)
	{
		$Http=new RechargeWebhookHttp();

		$endpoint='webhooks/1322149';
		$testWebhook=$Http->WebhookGet($endpoint);
		$webhook_dtls=json_decode($testWebhook,true);
		return $webhook_dtls;
	}
	public function listWebhook()
	{
		$Http=new RechargeWebhookHttp();

		$endpoint='webhooks';
		$testWebhook=$Http->WebhookGet($endpoint);
		$webhook_dtls=json_decode($testWebhook,true);
		return $webhook_dtls;
	}

	public function cancelSubscription($subscription_id)
	{
		$Http=new RechargeWebhookHttp();

		$endpoint='subscriptions/'.$subscription_id.'/cancel';
		$order_dtls=$Http->WebhookPost($endpoint,array('cancellation_reason'=>'other reason'));
		$order_dtls_arr=json_decode($order_dtls,true);
		return $order_dtls_arr;
	}
	
	

}

// $recharge=new RechargeApi();
// $dv=$recharge->findDevicebyIMEI('867798041154809');
// print_r($dv);
?>