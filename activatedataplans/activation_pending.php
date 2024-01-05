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

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();

$array=array("867798041626186","867798041635179","867798041607996","867798041640187","867798041640237","867798041636003","867798041614893","867798041612475","867798041645376","867798041644023","867798041608507");

$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
for($i=0;$i<sizeof($array);$i++)
{
	$arr=array();
	$arr['table']=DEVICETABLE;
	$arr['selector']="id,sim_no,address_id,status,user_id";
	$arr['condition']="where imei='".$array[$i]."'";

	$getDevice=$db->Select($arr);


	$order_dtl=$recharge_api->listSubscription($getDevice[0]['address_id']);
	print_r($order_dtl);
	$shopify_product_id=$order_dtl['subscriptions'][0]['shopify_product_id'];

	if($order_dtl['subscriptions'][0]['status']=='ACTIVE')
	{
		$response=$speedtalk->stSim($getDevice[0]['sim_no']);
		//print_r($response);
		

		if (strpos($response['retmess'], 'was used, phone#')) { 
    		
    		$explode_phone=explode("#",$response['retmess']);
    		//print_r($explode_phone);
    		$phone=rtrim($explode_phone[1],'.');
    		$phone =trim($phone," ");

    		$user_arr=array();
		    $user_arr['table']=USERTABLE;
		    $user_arr['selector']="id,email";
		    $user_arr['condition']="where id='".$getDevice[0]['user_id']."'";

		    $getUserDtls=$db->Select($user_arr);
		    $order_dtl2=$recharge_api->getfirstChargebyAddrId($getDevice[0]['address_id']);
		   // print_r($order_dtl2);
		     $fullname=$order_dtl2['orders'][0]['first_name']." ".$order_dtl2['orders'][0]['last_name'];
		     $shopify_order_number=$order_dtl2['orders'][0]['shopify_order_number'];
			 $shopify_order_id=$order_dtl2['orders'][0]['shopify_order_id'];
			 $cust_phone=$order_dtl2['orders'][0]['shipping_address']['phone'];

			 $activation_date=date('Y-m-d H:i:s');
    		$db->update(DEVICETABLE,array('phone_number'=>$phone,"transaction_id"=>"manual","status"=>2,'activation_date'=>$activation_date),array("where id='".$getDevice[0]['id']."'"));
		      $db->Update(USERTABLE,array('status'=>2),array("where id='".$getUserDtls[0]['id']."'"));


			$arr1=array();
			$arr1['table']=DEVICETABLE;
			$arr1['selector']="status";
			$arr1['condition']="where imei='".$array[$i]."'";

			$getDevice2=$db->Select($arr1);
			if($getDevice2[0]['status']==2)
			{
					 $textDataOrder=PHP_EOL."IMEI => ".$array[$i];
    
				 	$orderfile = fopen("activation_pending.txt", "a") or die("Unable to open file!");
				    fwrite($orderfile, $textDataOrder);
				    fclose($orderfile);

			}


    		$response=$mail->sendConfirmationMailNew($getUserDtls[0]['email'],$plan_array[$shopify_product_id],$phone);
 			// //$response=$mail->sendConfirmationMailNew("vijaya.jha@codeclouds.com",$plan_array[$shopify_product_id],$phone);

		    $createlistto_klaviyo=array();
			$createlistto_klaviyo['email']=$getUserDtls[0]['email'];
			$createlistto_klaviyo['fullName']=$fullname;
			//echo $createlistto_klaviyo['phone_number']=$getUserDtls[0]['phoneNumber'];
			$createlistto_klaviyo['phone_number']=$cust_phone;
			
			$createlistto_klaviyo['plan_type']=$plan_array[$shopify_product_id];
			$createlistto_klaviyo['plan_order_number']=$shopify_order_number;
			$createlistto_klaviyo['watch_phone_number']=$phone;
			$klaviyo=array();
			$klaviyo['profiles']=$createlistto_klaviyo;
			$res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
			//print_r($res_klaviyo);

			$createlistto_klaviyo1=array();
			$createlistto_klaviyo1['email']=$getUserDtls[0]['email'];
			$createlistto_klaviyo1['fullName']=$fullname;
			//echo $createlistto_klaviyo1['phone_number']=$getUserDtls[0]['phoneNumber'];
			$createlistto_klaviyo1['phone_number']=$cust_phone;
			
			$createlistto_klaviyo1['plan_type']=$plan_array[$shopify_product_id];
			$createlistto_klaviyo1['plan_order_number']=$shopify_order_number;
			$createlistto_klaviyo1['watch_phone_number']=$phone;
			$createlistto_klaviyo1['sim_type']='Speedtalk';
			$klaviyo1=array();
			$klaviyo1['profiles']=$createlistto_klaviyo1;
		
			$res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
			//print_r($res_klaviyo1);


			insertPhoneNoToShopifyNote($shopify_order_id,$phone);

		}

	}
	else if($order_dtl['subscriptions'][0]['status']=='CANCELLED')
	{
		// if($getDevice[0]['status']!=6)
		// {

			 $updated_date=date('Y-m-d H:i:s');
			$db->update(DEVICETABLE,array('status'=>6,"updated_date"=>$updated_date),array("where id='".$getDevice[0]['id']."'"));


			$response=$speedtalk->stSim($getDevice[0]['sim_no']);
		//print_r($response);
		

		if (strpos($response['retmess'], 'was used, phone#')) { 
    		
    		$explode_phone=explode("#",$response['retmess']);
    		//print_r($explode_phone);
    		$phone=rtrim($explode_phone[1],'.');
    		$phone =trim($phone," ");

    		$user_arr=array();
		    $user_arr['table']=USERTABLE;
		    $user_arr['selector']="id,email";
		    $user_arr['condition']="where id='".$getDevice[0]['user_id']."'";

		    $getUserDtls=$db->Select($user_arr);
		    $order_dtl2=$recharge_api->getfirstChargebyAddrId($getDevice[0]['address_id']);
		   // print_r($order_dtl2);
		     $fullname=$order_dtl2['orders'][0]['first_name']." ".$order_dtl2['orders'][0]['last_name'];
		     $shopify_order_number=$order_dtl2['orders'][0]['shopify_order_number'];
			 $shopify_order_id=$order_dtl2['orders'][0]['shopify_order_id'];
			 $cust_phone=$order_dtl2['orders'][0]['shipping_address']['phone'];

			 $activation_date=date('Y-m-d H:i:s');
    		$db->update(DEVICETABLE,array('phone_number'=>$phone,"transaction_id"=>"manual","activation_date"=>$updated_date),array("where id='".$getDevice[0]['id']."'"));
		      $db->Update(USERTABLE,array('status'=>2),array("where id='".$getUserDtls[0]['id']."'"));

		    $createlistto_klaviyo=array();
			$createlistto_klaviyo['email']=$getUserDtls[0]['email'];
			$createlistto_klaviyo['fullName']=$fullname;
			//echo $createlistto_klaviyo['phone_number']=$getUserDtls[0]['phoneNumber'];
			$createlistto_klaviyo['phone_number']=$cust_phone;
			
			$createlistto_klaviyo['plan_type']=$plan_array[$shopify_product_id];
			$createlistto_klaviyo['plan_order_number']=$shopify_order_number;
			$createlistto_klaviyo['watch_phone_number']=$phone;
			$klaviyo=array();
			$klaviyo['profiles']=$createlistto_klaviyo;
			$res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
			//print_r($res_klaviyo);

			$createlistto_klaviyo1=array();
			$createlistto_klaviyo1['email']=$getUserDtls[0]['email'];
			$createlistto_klaviyo1['fullName']=$fullname;
			//echo $createlistto_klaviyo1['phone_number']=$getUserDtls[0]['phoneNumber'];
			$createlistto_klaviyo1['phone_number']=$cust_phone;
			
			$createlistto_klaviyo1['plan_type']=$plan_array[$shopify_product_id];
			$createlistto_klaviyo1['plan_order_number']=$shopify_order_number;
			$createlistto_klaviyo1['watch_phone_number']=$phone;
			$createlistto_klaviyo1['sim_type']='Speedtalk';
			$klaviyo1=array();
			$klaviyo1['profiles']=$createlistto_klaviyo1;
		
			$res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
			//print_r($res_klaviyo1);

			$speedtalk->stAutorefillDeactivate($phone);
			insertPhoneNoToShopifyNote($shopify_order_id,$phone);

		}


		//}
	}


}



?>