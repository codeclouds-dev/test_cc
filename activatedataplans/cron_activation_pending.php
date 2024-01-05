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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'SipConnection.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'CosmoNetworkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'ShopifyApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\CosmoSipApi;
use Application\CosmoNetworkApi;
use Application\ShopifyApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$ShopifyApi=new ShopifyApi();

$CosmoSipApi=new CosmoSipApi();
$CosmoNetworkApi=new CosmoNetworkApi();

 $query="select user_mstr.id as user_id,email,fullName,user_mstrr.createdDate,pending.id as actv_id,device_details_new.id as device_id,device_details_new.imei,device_details_new.sim_no,channel,address_id,phone_number,provider_phone_number,device_details_new.refurbed,product from pending join device_details_new on pending.device_id=device_details_new.id join user_mstr on user_mstr.id=device_details_new.user_id where pending.status=1   and api='activation pending' order by pending.id desc limit 1";
$arr=array();
$arr['query']=$query;
$get_actv_pending=$db->SelectRaw($arr);
//print_r($get_actv_pending);

$activated=0;
//$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
  //$plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan");
	  //$plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract","8173820575965"=>"1 Year Plan (Monthly)");
 $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract","8173820575965"=>"1 Year Plan (Monthly)","8199866679517"=>"Monthly Membership - No Contract","8271818096861"=>"Monthly Plan","8271832711389"=>"6 Month Prepaid Plan");
if(count($get_actv_pending)>0)
{


			$watch_phone_number=$get_actv_pending[0]['provider_phone_number'];
	
			 $textDataOrder=PHP_EOL.'----------------------------------------';
		    $textDataOrder.=PHP_EOL."device_id => ".$get_actv_pending[0]['device_id'];
    
		 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
		    fwrite($orderfile, $textDataOrder);
		    fclose($orderfile);



			$order_dtl=$recharge_api->listSubscription($get_actv_pending[0]['address_id']);
			//print_r($order_dtl);
			
			$shopify_product_id=$order_dtl['subscriptions'][0]['shopify_product_id'];




		    $order_dtl2=$recharge_api->getfirstChargebyAddrId($get_actv_pending[0]['address_id']);
		    // print_r($order_dtl2);
		     $fullname=$order_dtl2['orders'][0]['first_name']." ".$order_dtl2['orders'][0]['last_name'];
		     $shopify_order_number=$order_dtl2['orders'][0]['shopify_order_number'];
			 $shopify_order_id=$order_dtl2['orders'][0]['shopify_order_id'];
			 $cust_phone=$order_dtl2['orders'][0]['shipping_address']['phone'];

	  $email=$order_dtl2['orders'][0]['email'];
							$phone=$order_dtl2['orders'][0]['shipping_address']['phone'];
							$phone = preg_replace( '/[^0-9]/', '', $phone );
							$addr1=$order_dtl2['orders'][0]['shipping_address']['address1'];
							$addr2=$order_dtl2['orders'][0]['shipping_address']['address2'];
							$city=$order_dtl2['orders'][0]['shipping_address']['city'];
							$poststate=strtoupper($order_dtl2['orders'][0]['shipping_address']['province']);
							$postalcode=$order_dtl2['orders'][0]['shipping_address']['zip'];
							if(strpos($postalcode, "-") !== false){
							  $postalcode=explode("-",$postalcode);
								//print_r($postalcode);
							 $postalcode=$postalcode[0];
							
							}
							//$country=$order_dtl['orders'][0]['shipping_address']['country'];
							$country='US';
							//$product_id=$_POST['product_id'];

							$state=$us_state_abbrevs_names[$poststate];
		  

		  

	if($order_dtl['subscriptions'][0]['status']=='ACTIVE')
	{
			

    	

		    $db->Update(USERTABLE,array('status'=>2),array("where id='".$get_actv_pending[0]['user_id']."'"));

		

				$autorefill_res=$speedtalk->stAutorefill($watch_phone_number);
				$textDataOrder=PHP_EOL."stAutorefill on";
    			$autorefill_res=array();
    			$autorefill_res['ret']=0;
			 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, $textDataOrder);
			    fclose($orderfile);

				if($autorefill_res['ret']==0)
				{
						$getauthtoken_api=$CosmoNetworkApi->getAuthToken();
						//print_r($getauthtoken_api);
						$getnetworktype=$CosmoNetworkApi->getNetworkType(array("imei"=>$get_actv_pending[0]['imei']),$getauthtoken_api['accessToken']);
						//print_r($res);


						$getnetworktype_res=array("device_id"=>$get_actv_pending[0]['device_id'],"api"=>$getnetworktype['api'],"response"=>json_encode($getnetworktype));

						//print_r($api_log_arr);
						$db->Insert(APILOG,$getnetworktype_res);


						$db->update(DEVICETABLE,array('network_type_cosmo'=>$getnetworktype['default_call_network']),array("where id='".$get_actv_pending[0]['device_id']."'"));
				//	$getnetworktype['default_call_network']='optimized';
						if($getnetworktype['default_call_network']=='optimized')
						{	
						//	$sip_res=sipConnectionCreate($get_actv_pending[0]['imei'],$state,$city,$phone,$get_actv_pending[0]['sim_no'],"optimized",$get_actv_pending[0]['device_id'],$get_actv_pending[0]['email']);

								$sip_array=array("imei"=>$get_actv_pending[0]['imei'],"sim_no"=>$get_actv_pending[0]['sim_no'],"device_id"=>$get_actv_pending[0]['device_id'],"network_type"=>"optimized");

								$sip_addr_array=array("state"=>$state,"city"=>$city,"phone"=>$phone,"email"=>$get_actv_pending[0]['email'],"fullName"=>$fullname,"created_at"=>$get_actv_pending[0]['createdDate'],"addressCreatedAt"=>date('Y-m-d H:i:s'),"line1"=>$addr1,"line2"=>$addr2,"postalCode"=>$postalcode,"country"=>$country);


								$sip_res=sipConnectionCreate($sip_array,$sip_addr_array);


							if(is_array($sip_res))
							{
									if($sip_res['response']==1)
									{
											$activated=1;
											$encrypted_order_email=PHP_AES_Cipher::encrypt(KEY,IV,$get_actv_pending[0]['email']);
											$watch_phone_number=$sip_res['watch_phone_number'];
												$db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,'network_type'=>'optimized','activation_date'=>date('Y-m-d H:i:s')),array("where id='".$get_actv_pending[0]['device_id']."'"));
											$response_mail=$mail->sendConfirmationMailNew($get_actv_pending[0]['email'],$plan_array[$shopify_product_id],$watch_phone_number,$get_actv_pending[0]['refurbed'],$encrypted_order_email);

									}
								
							}
						}
						else
						{
							
							$activated=1;
							$encrypted_order_email=PHP_AES_Cipher::encrypt(KEY,IV,$get_actv_pending[0]['email']);
							$db->update(DEVICETABLE,array('network_type'=>'standard','phone_number'=>$watch_phone_number,'activation_date'=>date('Y-m-d H:i:s')),array("where id='".$get_actv_pending[0]['device_id']."'"));
							setActivation(array("imei"=>$get_actv_pending[0]['imei'],"device_id"=>$get_actv_pending[0]['device_id'],"iccid"=>$get_actv_pending[0]['sim_no'],"email"=>$get_actv_pending[0]['email'],"network"=>"standard"));
							$response_mail=$mail->sendConfirmationMailNew($get_actv_pending[0]['email'],$plan_array[$shopify_product_id],$watch_phone_number,$get_actv_pending[0]['refurbed'],$encrypted_order_email);

						}

				}
				


				if($activated==1)
				{
					  $createlistto_klaviyo=array();
			$createlistto_klaviyo['email']=$get_actv_pending[0]['email'];
			$createlistto_klaviyo['fullName']=$fullname;
			$createlistto_klaviyo['phone_number']=$cust_phone;
			
			$createlistto_klaviyo['plan_type']=$plan_array[$shopify_product_id];
			$createlistto_klaviyo['plan_order_number']=$shopify_order_number;
			$createlistto_klaviyo['watch_phone_number']=$watch_phone_number;
			$klaviyo=array();
			$klaviyo['profiles']=$createlistto_klaviyo;
			$res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
			//print_r($res_klaviyo);

			 $textDataOrder=PHP_EOL."klaviyo list 1 created";
    
		 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
		    fwrite($orderfile, $textDataOrder);
		    fclose($orderfile);
if($get_actv_pending[0]['product']=='JT3')
{
    $product_type='JT3';
}
else
{
    $product_type='JT2';
}

			$createlistto_klaviyo1=array();
			$createlistto_klaviyo1['email']=$get_actv_pending[0]['email'];
			$createlistto_klaviyo1['fullName']=$fullname;
			$createlistto_klaviyo1['phone_number']=$cust_phone;
			
			$createlistto_klaviyo1['plan_type']=$plan_array[$shopify_product_id];
			$createlistto_klaviyo1['plan_order_number']=$shopify_order_number;
			$createlistto_klaviyo1['watch_phone_number']=$watch_phone_number;
			$createlistto_klaviyo1['sim_type']='Speedtalk';
			$createlistto_klaviyo1['product_type']=$product_type;

			$klaviyo1=array();
			$klaviyo1['profiles']=$createlistto_klaviyo1;
		

                     if($get_actv_pending[0]['product']=='JT3')
                  {
                      $res_klaviyo1=$klaviyo_api->jt3MemberMasterList($klaviyo1);

                  }
                  else
                  {
                      $res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);

                  }

			//$res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
			//print_r($res_klaviyo1);

			$textDataOrder=PHP_EOL."klaviyo list 2 created";
    
		 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
		    fwrite($orderfile, $textDataOrder);
		    fclose($orderfile);


			insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);

											$getshopifytags=$ShopifyApi->getOrderDetails($shopify_order_id);
											$order_tag=$getshopifytags['order']['tags'];

											$tags_arr=explode(",",$order_tag);
											//print_r($tags_arr);
											$tags_arr=array_merge($tags_arr,array($get_actv_pending[0]['channel']));
											//print_r($tags_arr);


						    			//$data=array("order"=>array("id"=>$shopify_order_id,"tags"=>["Subscription","Subscription First Order",$getDeviceDtls[0]['channel']]));
						    			$data=array("order"=>array("id"=>$shopify_order_id,"tags"=>$tags_arr));

											$res=$ShopifyApi->createTag($shopify_order_id,$data);

		     $textDataOrder=PHP_EOL."shopify note created";
    
		 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
		    fwrite($orderfile, $textDataOrder);
		    fclose($orderfile);
				}

    		
    		if($response_mail>=200 and $response_mail<=299)
			{
				
				$textDataOrder=PHP_EOL."mail sent";
    
			 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, $textDataOrder);
			    fclose($orderfile);
			   $db->update(PENDING,array('status'=>4,'updated_date'=>date('Y-m-d H:i:s')),array("where id='".$get_actv_pending[0]['actv_id']."'"));

			   $textDataOrder=PHP_EOL."activation pending data updated";
    
			 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, $textDataOrder);
			    fclose($orderfile);



			}
			else
			{
				
				$textDataOrder=PHP_EOL."mail error-".$response_mail;
    			$db->update(PENDING,array('status'=>3,'updated_date'=>date('Y-m-d H:i:s')),array("where id='".$get_actv_pending[0]['actv_id']."'"));

			 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, $textDataOrder);
			    fclose($orderfile);

			}
			
		

	}
	else if($order_dtl['subscriptions'][0]['status']=='CANCELLED')
	{
	

			 $updated_date=$order_dtl['subscriptions'][0]['cancelled_at'];
			 $db->update(DEVICETABLE,array('status'=>6,"updated_date"=>$updated_date),array("where id='".$get_actv_pending[0]['device_id']."'"));


			
			$speedtalk->stAutorefillDeactivate($watch_phone_number);
			
		  		$textDataOrder=PHP_EOL."speedtalk deactive";
    
			 	$orderfile = fopen("cron_activation_pending.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, $textDataOrder);
			    fclose($orderfile);


			$db->update(PENDING,array('status'=>4,'updated_date'=>date('Y-m-d H:i:s')),array("where id='".$get_actv_pending[0]['actv_id']."'"));


		
	}


}
	$orderfile = fopen("test.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, "cron activation pending \n");
			    fclose($orderfile);


?>