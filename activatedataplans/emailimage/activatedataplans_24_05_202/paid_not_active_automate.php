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

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\CosmoSipApi;
use Application\CosmoNetworkApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();

$CosmoSipApi=new CosmoSipApi();
$CosmoNetworkApi=new CosmoNetworkApi();

 $query="select device_details_new.* FROM `device_details_new` left JOIN activation_pending on activation_pending.device_id=device_details_new.id left JOIN pending on pending.device_id=device_details_new.id and api='activation pending' WHERE activation_pending.device_id is NULL and device_details_new.status='5' and pending.device_id is NULL";
$arr=array();
$arr['query']=$query;
$get_actv_pending=$db->SelectRaw($arr);
//print_r($get_actv_pending);

$activated=0;
//$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
  $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan");

if(count($get_actv_pending)>0)
{


	if($get_actv_pending[0]['provider']=='speedtalk')
	{
						  $stsimcheck=$speedtalk->stSIM($get_actv_pending[0]['sim_no']);

							if (strpos($stsimcheck['retmess'], 'was used, phone#')) { 
								$explode_phone=explode("#",$response['retmess']);
					    		//print_r($explode_phone);
					    		$phone=rtrim($explode_phone[1],'.');
					    		$phone =trim($phone," ");

					    		$activation_date=date('Y-m-d H:i:s');

					    		$db->update(DEVICETABLE,array('status'=>2,'provider_phone_number'=>$phone,'transaction_id'=>'manual automation','plan_id'=>'manual automation','activation_date'=>$activation_date),array("where id='".$val['device_id']."'"));
					    		
					    		
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
								    					$db->update(DEVICETABLE,array('provider_phone_number'=>$watch_phone_number,'plan_id'=>$plan_id,"transaction_id"=>$trxid),array("where id='".$getDeviceDtls[0]['id']."'"));
								    					



													}
							    				else
							    				{
							    					//$response['retmess']
							    					if($response['ret']==1)
							    					{
								    						 
							    						if(strpos($response['retmess'], "Zip code no valid") !== false)
							    						{
								    							$json_arr=array("response"=>7,"message"=>"016 | Activation Pending","block"=>"activation_pending");
															}
															else if(strpos($response['retmess'], "No web-credit available.") !== false)
															{


															

										    					$dev_arr=array();

								                                $dev_arr['imei']=$getDeviceDtls[0]['imei'];
								                                $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
								                                $dev_arr['email']=$getUserDtls[0]['email'];
								                                
								                                $json_arr=alert("shil@cosmotogether.com",$dev_arr,$response,'stActivate');

								    							$arr=array();
											            $arr['table']=PENDING;
											            $arr['selector']="id";
											            $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."' and api='Web Credit'";
											            $getactivationdtls=$db->Select($arr);
											            //print_r($getactivationdtls);

											            if(count($getactivationdtls)==0)
											            {
											            	 $web_credit=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>"Web Credit","priority"=>1);
																		 //print_r($web_credit);
																		 $db->Insert(PENDING,$web_credit);
											            }
							    						
											            

																
															}
							    						
							    						else if(strpos($response['retmess'], "Already submitted or not available.") !== false)
							    						{
							    							$mail->activationPending($getUserDtls[0]['email']);
								    						//$mail->activationPending("vijaya.jha@codeclouds.com");

							    							$arr=array();
												            $arr['table']=PENDING;
												            $arr['selector']="id";
												            $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."' and api='activation pending'";
												            $getactivationdtls=$db->Select($arr);
												            //print_r($getactivationdtls);

												            if(count($getactivationdtls)==0)
												            {
												            	 $actv_pend=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>"activation pending","priority"=>1);
																 //print_r($actv_pend);
																 $db->Insert(PENDING,$actv_pend);
												            }

							    						
							    						}
							    					
							    						
							    					}
							    					else
							    					{
							    						$json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");

								    					$dev_arr=array();

		                          $dev_arr['imei']=$getDeviceDtls[0]['imei'];
		                          $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
		                          $dev_arr['email']=$getUserDtls[0]['email'];
		                          
		                          $json_arr=alert("shil@cosmotogether.com",$dev_arr,$response,'stActivate');
								    					$json_arr=array_merge(array("block"=>"response_block2"),$json_arr);
							    					}
							    					


							    				}

										}
															    			
									}
							}

															$autorefill_res=$speedtalk->stAutorefill($watch_phone_number);
								    					$api_log_autorefill_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$autorefill_res['api'],"response"=>$autorefill_res['retmess'],'data'=>$autorefill_res['payload']);
		                          				
							                              //print_r($api_log_arr);
							                              $db->Insert(APILOG,$api_log_autorefill_arr);

							                             // $autorefill_res['ret']=0;
								    					if($autorefill_res['ret']==0)
								    					{
																						    					
											    				 $getauthtoken_api=$CosmoSipApi->getAuthToken();
																		//print_r($getauthtoken_api);
											    				  $dev_arr=array();
											    				  $dev_arr['device_id']=$getDeviceDtls[0]['id'];
		                                $dev_arr['imei']=$getDeviceDtls[0]['imei'];
		                                $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
		                                $dev_arr['email']=$getUserDtls[0]['email'];
											    				 $network=checkNetworkResponse($getauthtoken_api,$dev_arr);
																		//echo $net;
																		if($network=="")
																		{
																				$getnetworktype=$CosmoSipApi->getNetworkType(array("imei"=>$getDeviceDtls[0]['imei']),$getauthtoken_api['accessToken']);
																				$network=$getnetworktype['default_call_network'];
																				//print_r($res);
																					$getnetworktype_res=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$getnetworktype['api'],"response"=>json_encode($getnetworktype),'data'=>$getnetworktype['payload']);
		                          				
							                              //print_r($api_log_arr);
							                              $db->Insert(APILOG,$getnetworktype_res);
																		}
																																																				
																				$db->update(DEVICETABLE,array('network_type_cosmo'=>$network),array("where id='".$getDeviceDtls[0]['id']."'"));
																				//$getnetworktype['default_call_network']='optimized';
 
																				if($network=='optimized')
																				{	
																    					$sip_res=sipConnectionCreate($getDeviceDtls[0]['imei'],$getDeviceDtls[0]['sim_no'],"optimized",$getDeviceDtls[0]['id'],$getUserDtls[0]['email']);

																    					//print_r($sip_res);

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
																						$db->update(DEVICETABLE,array('network_type'=>'standard','phone_number'=>$watch_phone_number),array("where id='".$getDeviceDtls[0]['id']."'"));
																						setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"device_id"=>$getDeviceDtls[0]['id'],"iccid"=>$getDeviceDtls[0]['sim_no'],"email"=>$getUserDtls[0]['email'],"network"=>"standard"));

																						$json_arr=array("response"=>true,"phone"=>$watch_phone_number);
																					
																				}

																						    					//	
																}
									    					

															}
								    					else
								    					{

								    							$mail->activationPending($getUserDtls[0]['email']);
								    						
								    							$arr=array();
											            $arr['table']=PENDING;
											            $arr['selector']="id";
											            $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
											            $getactivationdtls=$db->Select($arr);
											            //print_r($getactivationdtls);

											            if(count($getactivationdtls)==0)
											            {
													            	 $actv_pend=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>"activation pending","priority"=>1);
																				 //print_r($actv_pend);
																				 $db->Insert(PENDING,$actv_pend);
											            }

								    					}


							else if($order_dtl['subscriptions'][0]['status']=='ACTIVE')
							{
								

								

							}
	else
	{

	}

		
			$watch_phone_number=$get_actv_pending[0]['provider_phone_number'];
	
		


		  

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