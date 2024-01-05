<?php

//header('Access-Control-Allow-Origin: *');

@session_start();
@ob_start();

//print_r($_SESSION);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include "countries.php";
include "states.php";
//echo $us_state_abbrevs_names['NEW YORK'];
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();



if(isset($_POST['charge_id']) and $_POST['charge_id']!="")
{
	//echo "ss";
	//$_GET['charge_id']=512839181
	$order_dtl=$recharge_api->getOrder($_POST['charge_id']);
	//print_r($order_dtl);
	if(count($order_dtl['orders'])>0)
	{
		$address_id=$order_dtl['orders'][0]['address_id'];
		$shopify_order_number=$order_dtl['orders'][0]['shopify_order_number'];
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
            $arr['condition']="where address_id='".$address_id."'";

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
							$phone=$order_dtl['orders'][0]['billing_address']['phone'];
							$addr1=$order_dtl['orders'][0]['billing_address']['address1'];
							$addr2=$order_dtl['orders'][0]['billing_address']['address2'];
							$city=$order_dtl['orders'][0]['billing_address']['city'];
							$poststate=strtoupper($order_dtl['orders'][0]['billing_address']['province']);
							$postalcode=$order_dtl['orders'][0]['billing_address']['zip'];
							//$country=$order_dtl['orders'][0]['billing_address']['country'];
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
						    	$gigs_user_array=array();
						    	$gigs_user_array['object']='user';
						    	$gigs_user_array['email']=$email;
						    	//$gigs_user_array['fullName']=$getUserDtls[0]['fullName'];
						    	
						    	$device_arr=array();
							    $device_arr['table']=DEVICETABLE;
							    $device_arr['selector']="id,imei,referrer";
							    $device_arr['condition']="where user_id='".$getUserDtls[0]['id']."' and status=1";
							    $getDeviceDtls=$db->Select($device_arr);
								//print_r($getDeviceDtls);
							    $fullname=$order_dtl['orders'][0]['first_name'].' '.$order_dtl['orders'][0]['last_name'];
							    $gigs_user_array['fullName']=$fullname;
							    if(count($getDeviceDtls)>0)
							    {
							    	//echo "device ";
							    	$referrer=$getDeviceDtls[0]['referrer'];
							    	
							    	if($getUserDtls[0]['phoneNumber']!="")
							    	{
							    		$db->Update(USERTABLE,array('phoneNumber'=>$phone,'fullName'=>$fullname),array("where id='".$getUserDtls[0]['id']."'"));
							    	}
							    	
							    	// check user exits in 

							    	$gigs_user_exist=$gigs->searchUser(array('email'=>$email));
							    	//print_r($gigs_user_exist);
							    	/*if($gigs_user_exist['statusCode']>=300)
							    	{
							    		$json_arr=array("response"=>false,"message"=>$gigs_user_exist['message']);
							    		echo json_encode($json_arr);
							    		exit();
							    	}*/

							    	$check_response_user=checkCurlResponse($gigs_user_exist);
							    	//print_r($check_response_user);
							    	if(count($gigs_user_exist['items'])>0)
							    	{
							    		
							    		$gigs_user_id=$gigs_user_exist['items'][0]['id'];
							    	}
							    	else
							    	{
							    		
							    		$gigs_userdtls=$gigs->createUser($gigs_user_array);
							    		$check_response_crtusr=checkCurlResponse($gigs_userdtls);
							    		//print_r($gigs_userdtls);
							    		$gigs_user_id=$gigs_userdtls['id'];
							    	}
							    	

						    		

							    		$gis_devicedtls=$gigs->findDevicebyIMEI($getDeviceDtls[0]['imei']);
							    		//print_r($gis_devicedtls);
							    		$check_response_devicedtls=checkCurlResponse($gis_devicedtls);
						    		
						    			$gigs_device_id=$gis_devicedtls['items'][0]['id'];
						    			$gigs_sim_id=$gis_devicedtls['items'][0]['sims'][0]['id'];
						    			
						    			$updatedvc=$gigs->updateDevice($gigs_device_id,array("user"=>$gigs_user_id));
						    			$check_response_updatedvc=checkCurlResponse($updatedvc);
						    		
						    			//echo "<br>";
						    			//print_r($updatedvc);
						    			//echo $addr2;

						    			if($addr2=="")
						    			{
						    				$addr2=$addr1;
						    			}
						    			$user_addr_arr=array();
						    			$user_addr_arr['object']='userAddress';
						    			$user_addr_arr['line1']=$addr1;
						    			$user_addr_arr['line2']=$addr2;
						    			$user_addr_arr['city']=$city;
						    			$user_addr_arr['state']=$state;
						    			$user_addr_arr['postalCode']=$postalcode;
						    			$user_addr_arr['country']=$country;
						    			//print_r($user_addr_arr);
						    			$gigs_useraddrdtls=$gigs->createUserAddress($gigs_user_id,$user_addr_arr);
						    			//print_r($gigs_useraddrdtls);
						    			$check_response_useraddrdtls=checkCurlResponse($gigs_useraddrdtls);
						    			

						    			if(isset($gigs_useraddrdtls['object']) and $gigs_useraddrdtls['object']=='error' and $gigs_useraddrdtls['message']=='Address already exists.')
						    			{

						    				//echo $gigs_user_id.'-city-'.$city.'-state-'.$state.'-country-'.$country;
						    				$listuseraddr=$gigs->listUserAddress($gigs_user_id);
						    				$check_response_listuseraddr=checkCurlResponse($listuseraddr);
						    		
						    				//print_r($listuseraddr);
						    				foreach($listuseraddr['items'] as $val)
						    				{
						    					//echo "-".$val['line1'].'-addr1'.$addr1.'line2'.$val['line2'].'addr2'.$addr2.'zip'.$val['postalCode'].'postal'.$postalcode;
						    					if(strtolower($val['line1'])==strtolower($addr1) and strtolower($val['line2'])==strtolower($addr2) and $val['postalCode']==$postalcode)
						    					{ 
						    						$gigs_user_Addr_id=$val['id'];
						    					}
						    				}
						    			}
						    			else
						    			{
						    				$gigs_user_Addr_id=$gigs_useraddrdtls['id'];
						    			}

						    			$user_addr_ldb_arr=array();
									    $user_addr_ldb_arr['table']=USERADDRESS;
									    $user_addr_ldb_arr['selector']="count(id) as count";
									    $user_addr_ldb_arr['condition']="where lower(line1)='".strtolower($addr1)."' and lower(line2)='".strtolower($addr1)."' and lower(city)='".strtolower($city)."' and state='".$state."' and country='".$country."'";

									    $getUserAddrLdbDtls=$db->Select($user_addr_ldb_arr);
									    //print_r($getUserAddrLdbDtls);

									    if($getUserAddrLdbDtls[0]['count']==0)
									    {
									    	$user_addr_ldb=array("line1"=>$addr1,"line2"=>$addr2,"city"=>$city,"state"=>$state,"postalCode"=>$postalcode,"country"=>$country,"user_id"=>$getUserDtls[0]['id']);
						    				$last_id=$db->Insert(USERADDRESS,$user_addr_ldb);
									    }
						    			

						    			// if there is only one plan in gigs then plan id will be static
						    			//$plan_array=array("6665229926568"=>"01FXWK88EESVBN4X19PFJPG75C","6665231302824"=>"01FXWK88EESVBN4X19PFJPG75C");

						    			$plan_id="01FXWJYWZ73XH72TNAMC09DCW8";
						    			$subs_arr=array();
						    			$subs_arr['plan']=$plan_id;
						    			$subs_arr['sim']=$gigs_sim_id;
						    			//$subs_arr['sim']="sim_test_psim";
						    			$subs_arr['userAddress']=$gigs_user_Addr_id;
						    			$subs_arr['user']=$gigs_user_id;
						    			//print_r($subs_arr);
						    			$create_subscription=$gigs->createSubscription($subs_arr);
						    			//print_r($create_subscription);
						    			$check_response_create_subscription=checkCurlResponse($create_subscription);
						    		
						    			if($create_subscription['object']='subscription')
						    			{
						    				$phone=$create_subscription['phoneNumber'];
						    				$email=$create_subscription['user']['email'];
						    			
						    			$db->Update(DEVICETABLE,array('status'=>2,'address_id'=>$address_id),array("where id='".$getDeviceDtls[0]['id']."'"));

						    			$db->Update(USERTABLE,array('status'=>2),array("where id='".$getUserDtls[0]['id']."'"));
						    			
						    			$createlistto_klaviyo=array();
						    			$createlistto_klaviyo['email']=$getUserDtls[0]['email'];
						    			$createlistto_klaviyo['fullName']=$fullname;
						    			//echo $createlistto_klaviyo['phone_number']=$getUserDtls[0]['phoneNumber'];
						    			$createlistto_klaviyo['phone_number']=$phone;
						    			
						    			$createlistto_klaviyo['plan_type']=$plan_array[$product_id];
						    			$createlistto_klaviyo['plan_order_number']=$shopify_order_number;
						    			$createlistto_klaviyo['watch_phone_number']=$phone;
						    			$klaviyo=array();
						    			$klaviyo['profiles']=$createlistto_klaviyo;
						    			$res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
						    			//print_r($res_klaviyo);

						    			$encrypted_phone=PHP_AES_Cipher::encrypt(KEY,IV,$phone);
						    			$encrypted_imei=PHP_AES_Cipher::encrypt(KEY,IV,$getDeviceDtls[0]['imei']);
						    			$response=$mail->sendConfirmationMail($getUserDtls[0]['email'],$shopify_order_number,$plan_array[$product_id],$phone);
						    			

						    			//print_r($response);
						    			if($response!=1)
						    			{
						    				$status=0;
						    			}
						    			else
						    			{
						    				$status=1;
						    			}
						    			
						    			$mail_details=array("device_id"=>$getDeviceDtls[0]['id'],"mail_id"=>$getUserDtls[0]['email'],"status"=>$status,"response"=>$response);
						    			$db->Insert(MAILDETAILS,$mail_details);


							    		$json_arr=array("response"=>true,"phone"=>$phone,"encrypted_phone"=>$encrypted_phone,"email"=>$email,"referrer"=>$referrer,"imei"=>$encrypted_imei,"uid"=>md5($getUserDtls[0]['id']));
										}
							    }
							    else
							    {
							    	$json_arr=array("response"=>false,"message"=>"Error 007, No IMEI Found for Mapping");
							    }

						    	
						    }
						    else
						    {
						    	$json_arr=array("response"=>false,"message"=>"Error 006, Account Mapping");
						    }

				    }
				    else
				    {
				    	$json_arr=array("response"=>false,"message"=>"Error 005, Product Id not found");
				    }



			}
			else
			{
				$json_arr=array("response"=>false,"message"=>"Error 004, Activation done with this Charge Id");

			}

		}
		else
		{
			$json_arr=array("response"=>false,"message"=>"Error 003, Something wrong with Charge Id");

		}
	}
	else
	{
		$json_arr=array("response"=>false,"message"=>"Error 002, Charge Id not found in Recharge");
	}
	

}
else
{
	$json_arr=array("response"=>false,"message"=>"Error 001, Charge Id Not found");
}

echo json_encode($json_arr);
?>