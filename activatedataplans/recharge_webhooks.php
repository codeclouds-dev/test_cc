<?php 
echo dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeWebhookApi.php';

use Application\RechargeApi;
use Application\RechargeWebhookApi;


$recharge_api=new RechargeApi();
$recharge_webhook_api=new RechargeWebhookApi();


// $webhook_array=array();
// $webhook_array['address']="https://activate.cosmotogether.com/activate_dataplans/index.php";
// $webhook_array['topic']="subscription/cancelled";
// $arr=$recharge_api->createWebhook($webhook_array);
// print_r($arr);

// $webhook_array=array();
// $webhook_array['address']="https://activate.cosmotogether.com/activatedataplans/recharge_order_creation_webhook.php";
// $webhook_array['topic']="order/created";
// $arr=$recharge_webhook_api->createWebhook($webhook_array);
// print_r($arr);

$webhook_array=array();
$webhook_array['address']="https://activate.cosmotogether.com/activatedataplans/recharge_subscription_cancellation.php";
$webhook_array['topic']="subscription/cancelled";
$arr=$recharge_webhook_api->createWebhook($webhook_array);
print_r($arr);


$arr=$recharge_webhook_api->listWebhook();
print_r($arr);

?>