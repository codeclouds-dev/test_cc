<?php

//header('Access-Control-Allow-Origin: *');

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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'TelnyxApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'CosmoNetworkApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\TelnyxApi;
use Application\CosmoSipApi;
use Application\CosmoNetworkApi;


$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$TelnyxApi=new TelnyxApi();
$CosmoSipApi=new CosmoSipApi();
$CosmoNetworkApi=new CosmoNetworkApi();



 		$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=7 and web_credit.created_date < DATE_SUB(now(), INTERVAL 24 HOUR) ";
	$arr=array();
	$arr['query']=$query;
  	$getDeviceDtls=$db->SelectRaw($arr);
//print_r($getDeviceDtls);
  	if(count($getDeviceDtls)==0)
  	{
  		
  		$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=6 and web_credit.created_date < DATE_SUB(now(), INTERVAL 12 HOUR) ";
  		$arr=array();
		$arr['query']=$query;
	  	$getDeviceDtls=$db->SelectRaw($arr);

	  	if(count($getDeviceDtls)==0)
  		{
  			$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=5 and web_credit.created_date < DATE_SUB(now(), INTERVAL 6 HOUR) ";
	  		$arr=array();
			$arr['query']=$query;
		  	$getDeviceDtls=$db->SelectRaw($arr);

		  	if(count($getDeviceDtls)==0)
	  		{
	  			$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=4 and web_credit.created_date < DATE_SUB(now(), INTERVAL 3 HOUR) ";
		  		$arr=array();
				$arr['query']=$query;
			  	$getDeviceDtls=$db->SelectRaw($arr);
			  	if(count($getDeviceDtls)==0)
		  		{
		  			$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=3 and web_credit.created_date < DATE_SUB(now(), INTERVAL 2 HOUR) ";
			  		$arr=array();
					$arr['query']=$query;
				  	$getDeviceDtls=$db->SelectRaw($arr);
				  	if(count($getDeviceDtls)==0)
			  		{
			  			$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=2 and web_credit.created_date < DATE_SUB(now(), INTERVAL 1 HOUR) ";
				  		$arr=array();
						$arr['query']=$query;
					  	$getDeviceDtls=$db->SelectRaw($arr);
					  	
					  	if(count($getDeviceDtls)==0)
				  		{
				  			$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=1 and web_credit.created_date < DATE_SUB(now(), INTERVAL 0.5 HOUR) ";
					  		$arr=array();
							$arr['query']=$query;
						  	$getDeviceDtls=$db->SelectRaw($arr);
						  	
						  	if(count($getDeviceDtls)==0)
					  		{
						  		$query="select device_details_new.id,web_credit.id as web_credit_id,user_mstr.id as user_id,email,imei,sim_no,address_id,phone_number,web_credit.status as web_status,provider,reg_code FROM web_credit join device_details_new on device_details_new.id=web_credit.device_id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.status='5' and web_credit.status=0 and web_credit.created_date < DATE_SUB(now(), INTERVAL 10 MINUTE) ";
							  		$arr=array();
									$arr['query']=$query;
								  	$getDeviceDtls=$db->SelectRaw($arr);
								  
					  		}


				  		}

			  		}
		  		}

	  		}

  		}

  	}

  	echo $query;
print_r($getDeviceDtls);
  	if(count($getDeviceDtls)>0)
  	{
			$activated=0;
			$order_dtl=$recharge_api->getChargeIdbyAddrId($getDeviceDtls[0]['address_id']);

			$status=$getDeviceDtls[0]['web_status'];

			$db->Update(WEBCREDIT,array('status'=>$status+1,'updated_date'=>date('Y-m-d H:i:s')),array("where id='".$getDeviceDtls[0]['web_credit_id']."'"));
								    			

			//if(count($order_dtl['orders'])>0 and $order_dtl['orders'][0]['charge_status']=='SUCCESS')
			if(count($order_dtl['orders'])>0)
			{	
				$address_id=$order_dtl['orders'][0]['address_id'];
				$shopify_order_number=$order_dtl['orders'][0]['shopify_order_number'];
				$shopify_order_id=$order_dtl['orders'][0]['shopify_order_id'];

					$product_arr=$order_dtl['orders'][0]['line_items'];
					//print_r($product_arr);
					//echo $order_number=$_POST['order_number'];

					 $product_id=checkSubscriptionProductRecharge($product_arr); 
					//echo "string";
					$arr=array();
		            $arr['table']=DEVICETABLE;
		            $arr['selector']="id";
		            //$arr['condition']="where address_id='".$address_id."' and status!='5'";
		             $arr['condition']="where address_id='".$address_id."' and status='5'";
		            $getAddrDtls=$db->Select($arr);
		            //print_r($getAddrDtls);
					//if(empty($getAddrDtls))

					if(count($getAddrDtls)>0)
					{
						//echo "string";

							$actv_pend=array();
				            $actv_pend['table']=ACTIVATION_PENDING;
				            $actv_pend['selector']="id";
				            $actv_pend['condition']="where device_id='".$getAddrDtls[0]['id']."'";
				            $getactvpending=$db->Select($actv_pend);
							
							if(count($getactvpending)==0)
							{

						
						
							$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
							
						    	//echo "string if ";

								    $email=$order_dtl['orders'][0]['email'];
									$phone=$order_dtl['orders'][0]['shipping_address']['phone'];
									$phone = preg_replace( '/[^0-9]/', '', $phone );
									$addr1=$order_dtl['orders'][0]['shipping_address']['address1'];
									$addr2=$order_dtl['orders'][0]['shipping_address']['address2'];
									$city=$order_dtl['orders'][0]['shipping_address']['city'];
									$poststate=strtoupper($order_dtl['orders'][0]['shipping_address']['province']);
									$postalcode=$order_dtl['orders'][0]['shipping_address']['zip'];
									if(strpos($postalcode, "-") !== false){
									  $postalcode=explode("-",$postalcode);
										//print_r($postalcode);
									 $postalcode=$postalcode[0];
									
									}
									//$country=$order_dtl['orders'][0]['shipping_address']['country'];
									$country='US';
									//$product_id=$_POST['product_id'];

									$state=$us_state_abbrevs_names[$poststate];

									//check user in local db

								
								    	
								
									    $fullname=$order_dtl['orders'][0]['first_name'].' '.$order_dtl['orders'][0]['last_name'];
									   
									
									    	//echo "device ";
									    	$device_id=$getDeviceDtls[0]['id'];
									    	// recharge api response
									    	 $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$order_dtl['api'],"response"=>json_encode($order_dtl));
											 //print_r($api_log_arr);
											 $db->Insert(APILOG,$api_log_arr);


									    	
									    	$watch_phone_number=$getDeviceDtls[0]['phone_number'];

								

								    			$sim_no=$getDeviceDtls[0]['sim_no'];

								    			if($getDeviceDtls[0]['phone_number']=="" or $getDeviceDtls[0]['phone_number']==NULL  or $getDeviceDtls[0]['phone_number']==0)
								    			{
													
														if(strtolower($getDeviceDtls[0]['provider'])=='telnyx')
														{
																					    				

									    					$response=$TelnyxApi->registerSimCard($getDeviceDtls[0]['reg_code']);
									    					//print_r($response);
									    					
								    					 	$dev_arr=array();
							                                $dev_arr['device_id']=$getDeviceDtls[0]['id'];
							                                $dev_arr['imei']=$getDeviceDtls[0]['imei'];
							                                $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
							                                $dev_arr['email']=$getUserDtls[0]['email'];
                                  
                               

					                                      checkCurlResponseNew($response,$getDeviceDtls[0]['id']);
					                                      checkTelnyxResponse($dev_arr,$response);
					 									  $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$response['api'],"response"=>json_encode($response),'data'=>$response['payload']);
    														
							                              //print_r($api_log_arr);
							                              $db->Insert(APILOG,$api_log_arr);
							                              	

							                              if(isset($response['errors']) and count($response['errors'])>0)
							                              {
							                              	 	if($response['errors'][0]['code']=='20100')
																{
																	$arr=array();
														            $arr['table']=WEBCREDIT;
														            $arr['selector']="id";
														            $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
														            $getactivationdtls=$db->Select($arr);
														            //print_r($getactivationdtls);

														            if(count($getactivationdtls)==0)
														            {
														            	 $web_credit=array("device_id"=>$getDeviceDtls[0]['id']);
																		 //print_r($web_credit);
																		 $db->Insert(WEBCREDIT,$web_credit);
														            }
														         
														            	
																}
							                              }
								                           
														else
														{

															 $watch_phone_number_telnyx=$response['data'][0]['msisdn'];
							                              	 $activation_date=date('Y-m-d H:i:s');	

							                              	// $db->update(DEVICETABLE,array('provider_phone_number'=>$watch_phone_number_telnyx),array("where id='".$getDeviceDtls[0]['id']."'"));
							                              		
														  $db->update(DEVICETABLE,array('provider_phone_number'=>$watch_phone_number_telnyx,'activation_date'=>$activation_date),array("where id='".$getDeviceDtls[0]['id']."'"));
															$db->update(DEVICETABLE,array('network_type_cosmo'=>"optimized"),array("where id='".$getDeviceDtls[0]['id']."'"));
									    					$sip_res=sipConnectionCreate($getDeviceDtls[0]['imei'],"optimized",$getDeviceDtls[0]['id'],$getUserDtls[0]['email']);
									    					//	print_r($sip_res);
									    					if(is_array($sip_res))
									    					{
									    							if($sip_res['response']==1)
									    							{
									    								$activated=1;
									    								$watch_phone_number=$sip_res['watch_phone_number'];
									    									$db->update(DEVICETABLE,array('phone_number'=>$sip_res['watch_phone_number'],'network_type'=>'optimized'),array("where id='".$getDeviceDtls[0]['id']."'"));
									    									$json_arr=array("response"=>true,"phone"=>$watch_phone_number);
									    							}
									    							
									    					}
														}

														
								    					
								    		}
	else
	{


	    				$activation_arr=array();

	    				$activation_arr['fname']=$order_dtl['orders'][0]['first_name'];
	    				$activation_arr['lname']=$order_dtl['orders'][0]['last_name'];
	    				$activation_arr['cxemail']=$email;
	    				$activation_arr['zip']=$postalcode;
	    				$activation_arr['state']=$state;
	    				$activation_arr['phone']=$phone;
	    				$activation_arr['address1']=$addr1;
	    				$activation_arr['city']=$city;
	    				
	    				
	    				$response=$speedtalk->stActivate($sim_no,$activation_arr);
	    				//print_r($response);

	    				checkCurlResponseNew($response,$device_id);

	    				//print_r($response);
	    				// $response['ret']=0;
	    				// $response['phone']='97328283823';
	    				// $response['Plan']='Monthly';
	    				// $response['trxid']='98SHJjhdfshjfj';
	    				//$response['retmess']='error';
	    				//print_r($response);
	    				
                        if(!isset($response['retmess']))
                        {
                            if($response['ret']==99)
                            {
                                $response['retmess']="Error 99";
                            }
                            else
                            {
                                $response['retmess']="Error 404";
                            }
                        }
	    				$api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$response['api'],"response"=>$response['retmess'],'data'=>$response['payload']);
        				
                      //print_r($api_log_arr);
                      $db->Insert(APILOG,$api_log_arr);

	    				if(array_key_exists('ret',$response))
	    				{
		    				if($response['ret']==0)
		    				{
		    					$watch_phone_number=isset($response['phone'])?$response['phone']:0;
		    					$plan_id=$response['Plan'];
		    					$trxid=isset($response['trxid'])?$response['trxid']:0;
		    					

		    					if($watch_phone_number!=0 and $trxid!=0)
		    					{
				    					$db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,'plan_id'=>$plan_id,"transaction_id"=>$trxid),array("where id='".$getDeviceDtls[0]['id']."'"));
				    					$autorefill_res=$speedtalk->stAutorefill($watch_phone_number);


				    					$api_log_autorefill_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$autorefill_res['api'],"response"=>$autorefill_res['retmess'],'data'=>$autorefill_res['payload']);
                				
			                              //print_r($api_log_arr);
			                              $db->Insert(APILOG,$api_log_autorefill_arr);

			                             // $autorefill_res['ret']=0;
				    					if($autorefill_res['ret']==0)
				    					{
					    					
					    				 $getauthtoken_api=$CosmoNetworkApi->getAuthToken();
												
												$getnetworktype=$CosmoNetworkApi->getNetworkType(array("imei"=>$getDeviceDtls[0]['imei']),$getauthtoken_api['accessToken']);
												//print_r($res);
													$db->update(DEVICETABLE,array('network_type_cosmo'=>$getnetworktype['default_call_network']),array("where id='".$getDeviceDtls[0]['id']."'"));

												if($getnetworktype['default_call_network']=='optimized')
												{	
								    					$sip_res=sipConnectionCreate($getDeviceDtls[0]['imei'],"optimized",$getDeviceDtls[0]['id'],$getUserDtls[0]['email']);
								    					if(is_array($sip_res))
								    					{
								    							if($sip_res['response']==1)
								    							{
									    								$activated=1;
									    								$watch_phone_number=$sip_res['watch_phone_number'];
									    									$db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,'network_type'=>'optimized'),array("where id='".$getDeviceDtls[0]['id']."'"));
									    								$json_arr=array("response"=>true,"phone"=>$watch_phone_number);
								    							}
								    							
								    					}
												}
												else
												{
														$activated=1;
														$db->update(DEVICETABLE,array('network_type'=>'standard'),array("where id='".$getDeviceDtls[0]['id']."'"));
														setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"network"=>"standard"));
														// $get_authtoken_network=$CosmoNetworkApi->getAuthToken(array("imei"=>$imei));
														// $CosmoNetworkApi->setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"network"=>'standard'),$get_authtoken_network['accessToken']);
													//	$CosmoNetworkApi->setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"network"=>'standard'));
												}

					    						
				    					}
				    					

		    					}
		    				 

		    				}
		    			

	    				}
	    				

	}
								    		
								    			if($activated)
								    			{
								    			
								    			$activation_date=date('Y-m-d H:i:s');

								    			$db->Update(DEVICETABLE,array('status'=>2,'address_id'=>$address_id,'activation_date'=>$activation_date),array("where id='".$getDeviceDtls[0]['id']."'"));

								    			$db->Update(USERTABLE,array('status'=>2),array("where id='".$getDeviceDtls[0]['user_id']."'"));
								    			$db->Update(WEBCREDIT,array('status'=>9,'updated_date'=>$activation_date),array("where id='".$getDeviceDtls[0]['web_credit_id']."'"));
								    			
								    			$createlistto_klaviyo=array();
								    			$createlistto_klaviyo['email']=$getDeviceDtls[0]['email'];
								    			$createlistto_klaviyo['fullName']=$fullname;
								    			//echo $createlistto_klaviyo['phone_number']=$getDeviceDtls[0]['phoneNumber'];
								    			
								    			
								    			$createlistto_klaviyo['plan_type']=$plan_array[$product_id];
								    			$createlistto_klaviyo['plan_order_number']=$shopify_order_number;
								    			$createlistto_klaviyo['watch_phone_number']=$watch_phone_number;
								    			$klaviyo=array();
								    			$klaviyo['profiles']=$createlistto_klaviyo;
								    			$res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
								    			//print_r($res_klaviyo);

								    			$createlistto_klaviyo1=array();
								    			$createlistto_klaviyo1['email']=$getDeviceDtls[0]['email'];
								    			$createlistto_klaviyo1['fullName']=$fullname;
								    			//echo $createlistto_klaviyo1['phone_number']=$getDeviceDtls[0]['phoneNumber'];
								    			
								    			
								    			$createlistto_klaviyo1['plan_type']=$plan_array[$product_id];
								    			$createlistto_klaviyo1['plan_order_number']=$shopify_order_number;
								    			$createlistto_klaviyo1['watch_phone_number']=$watch_phone_number;
								    			$createlistto_klaviyo1['sim_type']='Speedtalk';
								    			$klaviyo1=array();
								    			$klaviyo1['profiles']=$createlistto_klaviyo1;
											
												$res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
												//print_r($res_klaviyo1);


								    			$encrypted_phone=PHP_AES_Cipher::encrypt(KEY,IV,$watch_phone_number);
								    			$encrypted_imei=PHP_AES_Cipher::encrypt(KEY,IV,$getDeviceDtls[0]['imei']);
								    			
								    			$response=$mail->sendConfirmationMailNew($getDeviceDtls[0]['email'],$plan_array[$product_id],$watch_phone_number);
								    			//print_r($response);
								    			if($response>=200 and $response<=299)
								    			{
								    				$status=1;
								    			}
								    			else
								    			{
								    				$status=0;
								    			}
								    			
								    			$mail_details=array("device_id"=>$getDeviceDtls[0]['id'],"mail_id"=>$getDeviceDtls[0]['email'],"status"=>$status,"response"=>$response);
								    			$db->Insert(MAILDETAILS,$mail_details);

								    			insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);
									    		
												}
												
							
									    
								    	
								  
								    

						    
						   
							}
							

					}
					

				
				
			}
	
	}

?>