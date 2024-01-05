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

$start=$_GET['start'];
$end=$_GET['end'];

  $query="select device_details_new.id as device_id,address_id,sim_no,device_details_new.user_id,activation_pending.id as actv_id,email from device_details_new join (select DISTINCT(device_id) from api_log where response like '%No web-credit available. %' and date(date_time) between '2022-12-25' and '2022-12-26' group by device_id) as api_log on api_log.device_id=device_details_new.id join activation_pending on activation_pending.device_id=device_details_new.id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and device_details_new.id>=$start and device_details_new.id<=$end order by device_details_new.id asc limit 1";

$arr=array();
$arr['query']=$query;
$get_device_dtls=$db->SelectRaw($arr);
//print_r($get_device_dtls);



$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
if(count($get_device_dtls)>0)
{



			$order_dtl=$recharge_api->listSubscription($get_device_dtls[0]['address_id']);
			//print_r($order_dtl);
			
			$shopify_product_id=$order_dtl['subscriptions'][0]['shopify_product_id'];




		    $order_dtl2=$recharge_api->getfirstChargebyAddrId($get_device_dtls[0]['address_id']);
		   //print_r($order_dtl2);

		     $email=$order_dtl2['orders'][0]['email'];
		     $fullname=$order_dtl2['orders'][0]['first_name']." ".$order_dtl2['orders'][0]['last_name'];
		     $shopify_order_number=$order_dtl2['orders'][0]['shopify_order_number'];
			 $shopify_order_id=$order_dtl2['orders'][0]['shopify_order_id'];

			 $phone=$order_dtl2['orders'][0]['shipping_address']['phone'];
			 $phone = preg_replace( '/[^0-9]/', '', $phone );
			 $addr1=$order_dtl2['orders'][0]['billing_address']['address1'];
			 $addr2=$order_dtl2['orders'][0]['billing_address']['address2'];
			 $city=$order_dtl2['orders'][0]['billing_address']['city'];
			 $poststate=$order_dtl2['orders'][0]['billing_address']['province'];
			 $postalcode=$order_dtl2['orders'][0]['billing_address']['zip'];

			 if(strpos($postalcode, "-") !== false)
			 {
			  	$postalcode=explode("-",$postalcode);
				//print_r($postalcode);
				$postalcode=$postalcode[0];
				
			 }
			 $country='US';

			 $poststate=strtoupper($poststate);
			 $state=$us_state_abbrevs_names[$poststate];


	if($order_dtl['subscriptions'][0]['status']=='ACTIVE')
	{
			//echo "string";
			$db->Update(USERTABLE,array('phoneNumber'=>$phone,'fullName'=>$fullname),array("where id='".$get_device_dtls[0]['user_id']."'"));
    	
			$activation_arr=array();

			$activation_arr['fname']=$order_dtl2['orders'][0]['first_name'];
			$activation_arr['lname']=$order_dtl2['orders'][0]['last_name'];
			$activation_arr['cxemail']=$email;
			$activation_arr['zip']=$postalcode;
			$activation_arr['state']=$state;
			$activation_arr['phone']=$phone;
			$activation_arr['address1']=$addr1;
			$activation_arr['city']=$city;

			$response_stsim=$speedtalk->stSIM($get_device_dtls[0]['sim_no']);

			//print_r($response_stsim);

			if($response_stsim['ret']==0)
			{
				 $response=$speedtalk->stActivate($get_device_dtls[0]['sim_no'],$activation_arr);

				 $api_log_arr=array("device_id"=>$get_device_dtls[0]['device_id'],"api"=>$response['api'],"response"=>$response['retmess']);
                            				
                  //print_r($api_log_arr);
                  $db->Insert(APILOG,$api_log_arr);


				 if($response['ret']==0)
				 {
				 	$watch_phone_number=isset($response['phone'])?$response['phone']:0;
				 	$plan_id=$response['Plan'];
					$trxid=isset($response['trxid'])?$response['trxid']:0;
					if($watch_phone_number!=0 and $trxid!=0)
					{

						 $autorefill_res=$speedtalk->stAutorefill($watch_phone_number);

					 	 $db->Update(USERTABLE,array('status'=>2),array("where id='".$get_device_dtls[0]['user_id']."'"));
					 
						 $response_mail=$mail->sendConfirmationMailNew($get_device_dtls[0]['email'],$plan_array[$shopify_product_id],$watch_phone_number);
						 $db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,'plan_id'=>$plan_id,"transaction_id"=>$trxid),array("where id='".$get_device_dtls[0]['device_id']."'"));

						 $api_log_autorefill_arr=array("device_id"=>$get_device_dtls[0]['device_id'],"api"=>$autorefill_res['api'],"response"=>$autorefill_res['retmess']);
				
	                      //print_r($api_log_arr);
	                      $db->Insert(APILOG,$api_log_autorefill_arr);
	                       insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);

	    			}
	    			else
	    			{
	    				$db->Update(ACTIVATION_PENDING,array('status'=>0),array("where id='".$get_device_dtls[0]['actv_id']."'"));
	    			}  					
				 	 
				 }
				 else
				 {
				 	 $db->Update(ACTIVATION_PENDING,array('status'=>0),array("where id='".$get_device_dtls[0]['actv_id']."'"));
				 }
				 

			}
			else
			{


				if (strpos($response_stsim['retmess'], 'was used, phone#')) { 
		    		
		    		$explode_phone=explode("#",$response_stsim['retmess']);
		    		//print_r($explode_phone);
		    		$watch_phone_number=rtrim($explode_phone[1],'.');
		    		$watch_phone_number =trim($watch_phone_number," ");

		    		//echo "string2";

					 $activation_date=date('Y-m-d H:i:s');
		    		 $db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,"transaction_id"=>"manual","plan_id"=>"manual","activation_date"=>$activation_date,'status'=>2),array("where id='".$get_device_dtls[0]['device_id']."'"));
				     $db->Update(USERTABLE,array('status'=>2),array("where id='".$get_device_dtls[0]['user_id']."'"));
 					 $response_mail=$mail->sendConfirmationMailNew($get_device_dtls[0]['email'],$plan_array[$shopify_product_id],$watch_phone_number);

					 $autorefill_res=$speedtalk->stAutorefill($watch_phone_number);
					 insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);

				}


				 
			}

			
		

				
			

		

	}
	else if($order_dtl['subscriptions'][0]['status']=='CANCELLED')
	{
			$db->Update(USERTABLE,array('phoneNumber'=>$phone,'fullName'=>$fullname),array("where id='".$get_device_dtls[0]['user_id']."'"));
    	
			$updated_date=$order_dtl['subscriptions'][0]['cancelled_at'];
			$db->update(DEVICETABLE,array('status'=>6,"updated_date"=>$updated_date),array("where id='".$get_device_dtls[0]['device_id']."'"));
			
			$response=$speedtalk->stSIM($get_device_dtls[0]['sim_no']);


		if (strpos($response['retmess'], 'was used, phone#')) { 
    		
    		$explode_phone=explode("#",$response['retmess']);
    		//print_r($explode_phone);
    		$watch_phone_number=rtrim($explode_phone[1],'.');
    		$watch_phone_number =trim($watch_phone_number," ");


			 $activation_date=date('Y-m-d H:i:s');
    		 $db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,"transaction_id"=>"manual","activation_date"=>$updated_date),array("where id='".$get_device_dtls[0]['device_id']."'"));
		     $db->Update(USERTABLE,array('status'=>2),array("where id='".$get_device_dtls[0]['user_id']."'"));


			 $speedtalk->stAutorefillDeactivate($watch_phone_number);
			 insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);

		}


			



		
	}


}
	


?>