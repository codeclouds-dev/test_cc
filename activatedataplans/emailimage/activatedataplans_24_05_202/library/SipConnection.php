<?php 

/**

 * App

 * Version: 1.0

 * Author: Vijaya Jha


 */

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

@session_start();
@ob_start();
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Database.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'WebMail.php';
include_once dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'CosmoNetworkApi.php';

use Application\WebMail;
use Application\Database;
use Application\CosmoSipApi;
use Application\CosmoNetworkApi;




function sipConnectionCreate($imei,$iccid,$network_type,$device_id,$email)
{
			$db=new Database();
			$CosmoSipApi=new CosmoSipApi();
			

			$get_authtoken=$CosmoSipApi->getAuthToken(array("imei"=>$imei));
			$api_log_arr=array("device_id"=>$device_id,"api"=>$get_authtoken['api'],"response"=>json_encode($get_authtoken),'data'=>$get_authtoken['payload']);
			//print_r($api_log_arr);
		  $db->Insert(APILOG,$api_log_arr);
			$dev_arr=array();
			$dev_arr['device_id']=$device_id;
			$dev_arr['imei']=$imei;
			$dev_arr['iccid']=$iccid;
			$dev_arr['email']=$email;
			$dev_arr['subject']='COSMO Sip Error';

			$checkerrorinsip1=checkSipResponse($get_authtoken,$dev_arr);
			if($checkerrorinsip1!=true)
			{
					$res_cosmo=$CosmoSipApi->generateSip(array("imei"=>$imei),$get_authtoken['accessToken']);
					//print_r($res_cosmo);
					$api_log_arr=array("device_id"=>$device_id,"api"=>$res_cosmo['api'],"response"=>json_encode($res_cosmo),'data'=>$res_cosmo['payload']);
					//print_r($api_log_arr);
				  $db->Insert(APILOG,$api_log_arr);

					$checkerrorinsip=checkSipResponse($res_cosmo,$dev_arr);

					if($checkerrorinsip==true)
					{
							// any error in sip call will be in pending state
							$mail=new WebMail();
							
														    						
							$arr=array();
			        $arr['table']=PENDING;
			        $arr['selector']="id";
			        $arr['condition']="where device_id='".$device_id."' and api='sip pending'";
			        $getactivationdtls=$db->Select($arr);
			        //print_r($getactivationdtls);

			        if(count($getactivationdtls)==0)
			        {
			        				$mail->activationPending($email);
			            	 $actv_pend=array("device_id"=>$device_id,"api"=>"sip pending");
										 //print_r($actv_pend);
										 $db->Insert(PENDING,$actv_pend);
			        }
							
							return array('response'=>2);


					}
					else
					{
								if(isset($res_cosmo['sip_phone_number']))
								{
										 $get_watch_phone_number=$res_cosmo['sip_phone_number'];
										//print_r($res_cosmo);
										// $get_authtoken_network=$CosmoNetworkApi->getAuthToken(array("imei"=>$imei));
										// $CosmoNetworkApi->setActivation(array("imei"=>$imei,"network"=>$network_type),$get_authtoken_network['accessToken']);
										 setActivation(array("imei"=>$imei,"iccid"=>$iccid,"device_id"=>$device_id,"email"=>$email,"network"=>$network_type));

										 $explode=explode("+1",$get_watch_phone_number);
											//print_r($explode);
						    		return array('response'=>1,'watch_phone_number'=>$explode[1]);
								}
								else
								{
										return array('response'=>3);
								}
					}

			}
			else
			{

					// any error in sip call will be in pending state
					$mail=new WebMail();
					
												    								    						
					$arr=array();
	        $arr['table']=PENDING;
	        $arr['selector']="id";
	        $arr['condition']="where device_id='".$device_id."' and api='sip pending'";
	        $getactivationdtls=$db->Select($arr);
	        //print_r($getactivationdtls);

	        if(count($getactivationdtls)==0)
	        {

	        			 $mail->activationPending($email);
	            	 $actv_pend=array("device_id"=>$device_id,"api"=>"sip pending");
								 //print_r($actv_pend);
								 $db->Insert(PENDING,$actv_pend);
	        }
					return array('response'=>2);
			}
			
	  

}

function setActivation($arr)
{

		//print_r($arr);
		$db=new Database();
		$CosmoSipApi=new CosmoSipApi();
		$get_authtoken_network=$CosmoSipApi->getAuthToken();
		$api_log_arr=array("device_id"=>$arr['device_id'],"api"=>$get_authtoken_network['api'],"response"=>json_encode($get_authtoken_network),'data'=>$get_authtoken_network['payload']);
		//print_r($api_log_arr);
	  $db->Insert(APILOG,$api_log_arr);
	  	$dev_arr=array();
			$dev_arr['device_id']=$arr['device_id'];
			$dev_arr['imei']=$arr['imei'];
			$dev_arr['iccid']=$arr['iccid'];
			$dev_arr['email']=$arr['email'];
			$dev_arr['subject']='COSMO Network Set Activation Error';
	  $res_auth=checkNetworkApiResponse($get_authtoken_network,$dev_arr);
		if($res_auth!=true)
		{
			$setactivation=$CosmoSipApi->setActivation(array("imei"=>$arr['imei'],"network"=>$arr['network'],"activation"=>true),$get_authtoken_network['accessToken']);
			$api_log_arr=array("device_id"=>$arr['device_id'],"api"=>$setactivation['api'],"response"=>json_encode($setactivation),'data'=>$setactivation['payload']);
			//print_r($api_log_arr);
		  $db->Insert(APILOG,$api_log_arr);
		  $res=checkNetworkApiResponse($setactivation,$dev_arr);
		  if($res==true)
		  {

						$arr1=array();
		        $arr1['table']=PENDING;
		        $arr1['selector']="id";
		        $arr1['condition']="where device_id='".$arr['device_id']."' and api='set activation'";
		        $getactivationdtls=$db->Select($arr1);
		        //print_r($getactivationdtls);

		        if(count($getactivationdtls)==0)
		        {
		        			
		            	 $actv_pend=array("device_id"=>$arr['device_id'],"api"=>"set activation");
									 //print_r($actv_pend);
									 $db->Insert(PENDING,$actv_pend);
		        }
		  }
		}
		else
		{
						//print_r($arr);
						$arr1=array();
		        $arr1['table']=PENDING;
		        $arr1['selector']="id";
		        $arr1['condition']="where device_id='".$arr['device_id']."' and api='set activation'";
		        $getactivationdtls=$db->Select($arr1);
		        //print_r($getactivationdtls);

		        if(count($getactivationdtls)==0)
		        {
		        			
		            	 $actv_pend=array("device_id"=>$arr['device_id'],"api"=>"set activation");
									 //print_r($actv_pend);
									 $db->Insert(PENDING,$actv_pend);
		        }
		}
		


}
