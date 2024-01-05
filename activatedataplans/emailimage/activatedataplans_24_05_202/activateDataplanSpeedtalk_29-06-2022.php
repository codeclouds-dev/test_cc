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



if(isset($_POST['charge_id']) and $_POST['charge_id']!="" and isset($_POST['email']) and $_POST['email']!="")
{
	//echo "ss";
	//$_GET['charge_id']=512839181
	$activated=0;
	$order_dtl=$recharge_api->getOrder($_POST['charge_id']);
	//print_r($order_dtl);
	checkCurlResponseRecharge($order_dtl,$_POST['email']);
	


	//if(count($order_dtl['orders'])>0 and $order_dtl['orders'][0]['charge_status']=='SUCCESS')
	if(count($order_dtl['orders'])>0)
	{	
		$address_id=$order_dtl['orders'][0]['address_id'];
		$shopify_order_number=$order_dtl['orders'][0]['shopify_order_number'];
		$shopify_order_id=$order_dtl['orders'][0]['shopify_order_id'];

		$charge_id_created_at=$order_dtl['orders'][0]['created_at'];
		$timestamp_charge = strtotime($charge_id_created_at);
		//echo date('Y-m-d H:i:s');

		$timestampnow= strtotime(date('Y-m-d H:i:s'));
		$hour_diff=round(abs($timestampnow-$timestamp_charge)/(60*60));

		if($hour_diff<1 or 1==1)
		{
			//echo "string";
			$arr=array();
            $arr['table']=DEVICETABLE;
            $arr['selector']="id";
            $arr['condition']="where address_id='".$address_id."' and status!='5'";

            $getAddrDtls=$db->Select($arr);
            //print_r($getAddrDtls);
			if(empty($getAddrDtls))
			{
				//echo "string";


				
					$product_arr=$order_dtl['orders'][0]['line_items'];
					//print_r($product_arr);
					//echo $order_number=$_POST['order_number'];

					 $product_id=checkSubscriptionProductRecharge($product_arr); // return product id exists in the line_items array

					$plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
					if($product_id)
				    {
				    	//echo "string if ";

						    $email=$order_dtl['orders'][0]['email'];
							$phone=$order_dtl['orders'][0]['shipping_address']['phone'];
							$phone = preg_replace( '/[^0-9]/', '', $phone );
							$addr1=$order_dtl['orders'][0]['shipping_address']['address1'];
							$addr2=$order_dtl['orders'][0]['shipping_address']['address2'];
							$city=$order_dtl['orders'][0]['shipping_address']['city'];
							$poststate=strtoupper($order_dtl['orders'][0]['shipping_address']['province']);
							$postalcode=$order_dtl['orders'][0]['shipping_address']['zip'];
							//$country=$order_dtl['orders'][0]['shipping_address']['country'];
							$country='US';
							//$product_id=$_POST['product_id'];

							$state=$us_state_abbrevs_names[$poststate];

							//check user in local db

							$user_arr=array();
						    $user_arr['table']=USERTABLE;
						    $user_arr['selector']="id,fullName,phoneNumber,email";
						    $user_arr['condition']="where email='".$email."'";

						    $getUserDtls=$db->Select($user_arr);
						    //print_r($getUserDtls);

						    if(count($getUserDtls)>0)
						    {
						    	//echo "email";
						    
						    	
						    	$device_arr=array();
							    $device_arr['table']=DEVICETABLE;
							    $device_arr['selector']="id,imei,referrer,phone_number,sim_no";
							    //$device_arr['condition']="where user_id='".$getUserDtls[0]['id']."' and status in ('1','5')";
							    $device_arr['condition']="where user_id='".$getUserDtls[0]['id']."' and status='5'";
							    $getDeviceDtls=$db->Select($device_arr);
								//print_r($getDeviceDtls);
							    $fullname=$order_dtl['orders'][0]['first_name'].' '.$order_dtl['orders'][0]['last_name'];
							    $gigs_user_array['fullName']=$fullname;
							    if(count($getDeviceDtls)>0)
							    {
							    	//echo "device ";
							    	$device_id=$getDeviceDtls[0]['id'];
							    	// recharge api response
							    	 $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$order_dtl['api'],"response"=>json_encode($order_dtl));
									 //print_r($api_log_arr);
									 $db->Insert(APILOG,$api_log_arr);


							    	$referrer=$getDeviceDtls[0]['referrer'];
							    	$watch_phone_number=$getDeviceDtls[0]['phone_number'];

							    	if($getUserDtls[0]['phoneNumber']!="")
							    	{
							    		$db->Update(USERTABLE,array('phoneNumber'=>$phone,'fullName'=>$fullname),array("where id='".$getUserDtls[0]['id']."'"));
							    	}
							    	
							    	

						    		if($addr2=="")
						    		{
						    			$addr2=$addr1;

						    		}

						    			$user_addr_ldb_arr=array();
									    $user_addr_ldb_arr['table']=USERADDRESS;
									    $user_addr_ldb_arr['selector']="count(id) as count";
									    $user_addr_ldb_arr['condition']="where lower(line1)='".strtolower($addr1)."' and lower(line2)='".strtolower($addr1)."' and lower(city)='".strtolower($city)."' and state='".$state."' and country='".$country."' and user_id=".$getUserDtls[0]['id'];

									    $getUserAddrLdbDtls=$db->Select($user_addr_ldb_arr);
									    //print_r($getUserAddrLdbDtls);

									    if($getUserAddrLdbDtls[0]['count']==0)
									    {
									    	$user_addr_ldb=array("line1"=>$addr1,"line2"=>$addr2,"city"=>$city,"state"=>$state,"postalCode"=>$postalcode,"country"=>$country,"user_id"=>$getUserDtls[0]['id']);
						    				$last_id=$db->Insert(USERADDRESS,$user_addr_ldb);
									    }
						    			

						    			$sim_no=$getDeviceDtls[0]['sim_no'];

						    			if($getDeviceDtls[0]['phone_number']=="" or $getDeviceDtls[0]['phone_number']==NULL  or $getDeviceDtls[0]['phone_number']==0)
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

						    				$api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$response['api'],"response"=>$response['retmess']);
                            				
				                              //print_r($api_log_arr);
				                              $db->Insert(APILOG,$api_log_arr);



						    				if(array_key_exists('ret',$response))
						    				{
							    				if($response['ret']==0)
							    				{
							    					$watch_phone_number=$response['phone'];
							    					$plan_id=$response['Plan'];
							    					$trxid=$response['trxid'];
							    					
							    					$db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,'plan_id'=>$plan_id,"transaction_id"=>$trxid),array("where id='".$getDeviceDtls[0]['id']."'"));
							    					$autorefill_res=$speedtalk->stAutorefill($watch_phone_number);


							    					$api_log_autorefill_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$autorefill_res['api'],"response"=>$autorefill_res['retmess']);
                            				
						                              //print_r($api_log_arr);
						                              $db->Insert(APILOG,$api_log_autorefill_arr);

						                             // $autorefill_res['ret']=0;
							    					if($autorefill_res['ret']==0)
							    					{
							    						$activated=1;
							    						$json_arr=array("response"=>true,"phone"=>$watch_phone_number);
							    					}
							    					else
							    					{
							    						//Error Activation: Unable to Auto Refill
							    						$json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");
							    					}
							    				}
							    				else
							    				{
							    					//$response['retmess']
							    					$json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");
							    				}

						    				}
						    				else
						    				{
						    					//Error #111: Unable to activate
						    					$json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");
						    				}

						    			}
						    			else
						    			{
						    				$autorefill_response=$speedtalk->stAutorefill($watch_phone_number);

						    				$api_log_autorefill_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$autorefill_response['api'],"response"=>$autorefill_response['retmess']);
                            				
						                              //print_r($api_log_autorefill_arr);
						                              $db->Insert(APILOG,$api_log_autorefill_arr);


						    				//print_r($autorefill_response);
						    				//$autorefill_response['ret']=0;
						    				if($autorefill_response['ret']==0)
					    					{
					    						$activated=1;
					    						$json_arr=array("response"=>true,"phone"=>$getDeviceDtls[0]['phone_number']);
					    					}
					    					else
					    					{
					    						//Unable to Auto Refill
					    						$json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");
					    					}

						    			}
						    		
						    			if($activated)
						    			{
						    			
						    			$activation_date=date('Y-m-d H:i:s');

						    			$db->Update(DEVICETABLE,array('status'=>2,'address_id'=>$address_id,'activation_date'=>$activation_date),array("where id='".$getDeviceDtls[0]['id']."'"));

						    			$db->Update(USERTABLE,array('status'=>2),array("where id='".$getUserDtls[0]['id']."'"));
						    			
						    			$createlistto_klaviyo=array();
						    			$createlistto_klaviyo['email']=$getUserDtls[0]['email'];
						    			$createlistto_klaviyo['fullName']=$fullname;
						    			//echo $createlistto_klaviyo['phone_number']=$getUserDtls[0]['phoneNumber'];
						    			$createlistto_klaviyo['phone_number']=$phone;
						    			
						    			$createlistto_klaviyo['plan_type']=$plan_array[$product_id];
						    			$createlistto_klaviyo['plan_order_number']=$shopify_order_number;
						    			$createlistto_klaviyo['watch_phone_number']=$watch_phone_number;
						    			$klaviyo=array();
						    			$klaviyo['profiles']=$createlistto_klaviyo;
						    			$res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
						    			//print_r($res_klaviyo);

						    			$createlistto_klaviyo1=array();
						    			$createlistto_klaviyo1['email']=$getUserDtls[0]['email'];
						    			$createlistto_klaviyo1['fullName']=$fullname;
						    			//echo $createlistto_klaviyo1['phone_number']=$getUserDtls[0]['phoneNumber'];
						    			$createlistto_klaviyo1['phone_number']=$phone;
						    			
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
						    			//$response=$mail->sendConfirmationMail($getUserDtls[0]['email'],$shopify_order_number,$plan_array[$product_id],$watch_phone_number);
						    			//$response=$mail->sendConfirmationMailNew($getUserDtls[0]['email'],$shopify_order_number,$plan_array[$product_id],$watch_phone_number);

						    			$response=$mail->sendConfirmationMailNew($getUserDtls[0]['email'],$plan_array[$product_id],$watch_phone_number);
						    			//print_r($response);
						    			if($response>=200 and $response<=299)
						    			{
						    				$status=1;
						    			}
						    			else
						    			{
						    				$status=0;
						    			}
						    			
						    			$mail_details=array("device_id"=>$getDeviceDtls[0]['id'],"mail_id"=>$getUserDtls[0]['email'],"status"=>$status,"response"=>$response);
						    			$db->Insert(MAILDETAILS,$mail_details);

						    			insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);
							    		$json_arr=array("response"=>true,"phone"=>$watch_phone_number,"encrypted_phone"=>$encrypted_phone,"email"=>$email,"referrer"=>$referrer,"imei"=>$encrypted_imei,"uid"=>md5($getUserDtls[0]['id']));
										}
							    }
							    else
							    {
							    	//No IMEI Found for Mapping
							    	$json_arr=array("response"=>false,"message"=>"005 | Email mismatch","block"=>"response_block");
							    }

						    	
						    }
						    else
						    {
						    	//Account Mapping
						    	$json_arr=array("response"=>false,"message"=>"004 | Email mismatch","block"=>"response_block");
						    }

				    }
				    else
				    {
				    	//Error 005, Product Id not found
				    	$json_arr=array("response"=>false,"message"=>"010 | Activation error","block"=>"response_block");
				    }



			}
			else
			{

				//Error 004, Activation done with this Charge Id
				$json_arr=array("response"=>false,"message"=>"009 | Activation error","block"=>"response_block");

			}

		}
		else
		{
			$json_arr=array("response"=>false,"message"=>"003 | Something wrong with Charge Id","block"=>"response_block");

		}
	}
	else
	{

		//Error 002, Charge Id not found in Recharge or Charge CANCELLED
		$json_arr=array("response"=>false,"message"=>"008 | Activation error","block"=>"response_block");
	}
	

}
else
{

	//Error 001, Charge Id Not found
	$json_arr=array("response"=>false,"message"=>"007 | Activation error","block"=>"response_block");
}

echo json_encode($json_arr);
?>