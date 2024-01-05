<?php 

/**

 * App

 * Version: 1.0

 * Author: Vijaya Jha


 */



@session_start();
@ob_start();
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Database.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'WebMail.php';

use Application\WebMail;

use Application\Database;
function checkUserActive()
{
	if(isset($_SESSION['active_user']) and $_SESSION['active_user']!="")
	{
		return true;
	}
	else
	{
		return false;
		
	}

}

 function generateRandom()
{
	$db=new Database();
	$batch_id=rand(000000,999999);
	$checkbatch_exist=array();
	$checkbatch_exist['table']='device_import';
	$checkbatch_exist['selector']="batch_id";
	$checkbatch_exist['condition']="where batch_id=".$batch_id;
	$checkbatch_exist1=$db->Select($checkbatch_exist);
	if(count($checkbatch_exist1)==0)
	{
			return $batch_id;
	}
	else
	{
			generateRandom();
	}

}
function isUserLogin()
{
	
	if(isset($_SESSION['loginuser']) and $_SESSION['loginuser']!="")
	{
		return true;
	}
	else
	{
		return false;
		
	}
}
function checkRefurbedProductRecharge($product_arr=array())
{

	$arr = array_column($product_arr, 'shopify_product_id');
	
	if(in_array("8078383022301", $arr))
	{
		
			if(in_array("8075007557853",$arr))
			{
				return 8075007557853;
			}
			else if(in_array("8074743152861",$arr))
			{
				return 8074743152861;
			}
			else if(in_array("8075008049373",$arr))
			{
				return 8075008049373;
			}
			else
			{
				return 0;
			}
	}
	else
	{
		 return 0;
	}

	// foreach($product_arr as $val)
	// {
	// 	//print_r($val);
	// 	if(($val['product_id']==8078383022301) or ($val['product_id']==8075007557853  or $val['product_id']==8074743152861 or $val['product_id']==8075008049373))
  //   	{
  //   		if($val['product_id']==8075007557853  or $val['product_id']==8074743152861 or $val['product_id']==8075008049373)
  //   		{
  //   			$product_id=$val['product_id'];
  //   			return $product_id;
  //   		}
    	
    		
    		
  //   	}
  //   	else
  //   	{
  //   		continue;
  //   	}
	// }

}
function checkRefurbedProduct($product_arr=array())
{

	$arr = array_column($product_arr, 'product_id');
	//print_r($arr);
	if(in_array("8078383022301", $arr))
	{
		
			if(in_array("8075007557853",$arr))
			{
				return 8075007557853;
			}
			else if(in_array("8074743152861",$arr))
			{
				return 8074743152861;
			}
			else if(in_array("8075008049373",$arr))
			{
				return 8075008049373;
			}
			else
			{
				return 0;
			}
	}
	else
	{
		 return 0;
	}

	// foreach($product_arr as $val)
	// {
	// 	//print_r($val);
	// 	if(($val['product_id']==8078383022301) or ($val['product_id']==8075007557853  or $val['product_id']==8074743152861 or $val['product_id']==8075008049373))
  //   	{
  //   		if($val['product_id']==8075007557853  or $val['product_id']==8074743152861 or $val['product_id']==8075008049373)
  //   		{
  //   			$product_id=$val['product_id'];
  //   			return $product_id;
  //   		}
    	
    		
    		
  //   	}
  //   	else
  //   	{
  //   		continue;
  //   	}
	// }

}

function checkJt2seInstallmentProduct($product_arr=array())
{

	$arr = array_column($product_arr, 'product_id');
	//print_r($arr);
	if(in_array("8162587869405", $arr))
	{
		echo "string";
			if(in_array("8173820575965",$arr))
			{
				return 8173820575965;
			}
			
	}
	else
	{
		 return 0;
	}


}
function checkJt2seInstallmentProductRecharge($product_arr=array())
{

	$arr = array_column($product_arr, 'shopify_product_id');
	print_r($arr);
	if(in_array("8162587869405", $arr))
	{
		echo "string";
			if(in_array("8173820575965",$arr))
			{
				return 8173820575965;
			}
			
	}
	else
	{
		 return 0;
	}


}
function checkSubscriptionProduct($product_arr=array())
{

	foreach($product_arr as $val)
	{
		if($val['product_id']==7664495755485 or $val['product_id']==7664492970205  or $val['product_id']==7664495198429 or $val['product_id']==8054644113629 or $val['product_id']==8054650699997 or $val['product_id']==8075971166429 or $val['product_id']==8199866679517  or $val['shopify_product_id']== 8271818096861 or $val['shopify_product_id']== 8271832711389)
    	{
    		$product_id=$val['product_id'];
    		return $product_id;
    		//return true;
    	}
    	else
    	{
    		return false;
    	}
	}

}

function checkSubscriptionProductRecharge($product_arr=array())
{

	foreach($product_arr as $val)
	{
		//print_r($val);
		if($val['shopify_product_id']==7664495755485 or $val['shopify_product_id']==7664492970205  or $val['shopify_product_id']==7664495198429 or $val['shopify_product_id']==8054644113629 or $val['shopify_product_id']==8054650699997 or $val['shopify_product_id']==8075971166429  or $val['shopify_product_id']==8199866679517 or $val['shopify_product_id']== 8271818096861 or $val['shopify_product_id']== 8271832711389)
    	{
    		$product_id=$val['shopify_product_id'];
    		return $product_id;
    		//return true;
    	}
    	else
    	{
    		continue;
    	}
	}

}

/*function checkCurlResponse($array=array())
{
	//print_r($array);
	if(array_key_exists('statusCode',$array) and $array['message']!='Address already exists.')
	{
		if($array['statusCode']>300 and $array['statusCode']<500)
		{
			$json_arr=array("response"=>2,"error_message"=>"Connection Error","error_code"=>401);
		}
		else
		{
			$json_arr=array("response"=>2,"error_message"=>"Server Error","error_code"=>402);
		}
		
		echo json_encode($json_arr);
		exit();
	}
	
}*/

function checkCurlResponse($array=array())
{
	//print_r($array);
	if(array_key_exists('statusCode',$array) and $array['message']!='Address already exists.')
	{
		if($array['statusCode']==422)
		{
			$json_arr=array("response"=>2,"error_message"=>$array['message'],"error_code"=>422);
		}
		elseif($array['statusCode']>300 and $array['statusCode']<500)
		{
			$json_arr=array("response"=>2,"error_message"=>"Connection Error","error_code"=>401);
		}
		else
		{
			$json_arr=array("response"=>2,"error_message"=>"Server Error","error_code"=>402);
		}
		
		echo json_encode($json_arr);
		exit();
	}
	
}

function checkCurlResponseNew($array=array(),$device_id)
{
	//print_r($array);
	$db=new Database();
	if(array_key_exists('error_message',$array))
	{


		  $api_log_arr=array("device_id"=>$device_id,"api"=>$array['api'],"response"=>$array['status_code'].'-'.$array['error_message'],'data'=>$array['payload']);
            
          //print_r($api_log_arr);
          $db->Insert(APILOG,$api_log_arr);

          //$array['error_message']
			$json_arr=array("response"=>"error","error_message"=>"002 | Server Error");
			
			echo json_encode($json_arr);
			exit();
	}
	
}

function checkCurlResponseRecharge($array=array(),$email)
{

		
		if(array_key_exists('error_message',$array))
		{


				$db=new Database();

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
				    $device_arr['condition']="where user_id='".$getUserDtls[0]['id']."' and status='5'";

				    $getDeviceDtls=$db->Select($device_arr);
					//print_r($getDeviceDtls);
				    if(!empty($getDeviceDtls))
				    {
				    	$device_id=$getDeviceDtls[0]['id'];
				    }
				    else
				    {
				    	$json_arr=array("response"=>"error","error_message"=>"Device Not Found");
					
						echo json_encode($json_arr);
						exit();

				    }
				    



				 }




			  $api_log_arr=array("device_id"=>$device_id,"api"=>$array['api'],"response"=>$array['error_message']);
            
              //print_r($api_log_arr);
              $db->Insert(APILOG,$api_log_arr);

              //$array['error_message']
			$json_arr=array("response"=>"error","error_message"=>"002 | Server Error");
			
			echo json_encode($json_arr);
			exit();

		}


}


function checkIMEIesponse($array=array(),$referrer)
{
	//print_r($array);
	if(array_key_exists('statusCode',$array))
	{
		if($array['statusCode']>300 and $array['statusCode']<500)
		{
			$json_arr=array("response"=>false,"message"=>$array['message'],"referrer"=>$referrer);
		}
		else
		{
			$json_arr=array("response"=>false,"message"=>$array['message'],"referrer"=>$referrer);
		}
		
		echo json_encode($json_arr);
		exit();
	}
	
}



function insertPhoneNoToShopifyNote($cust_order_id,$phone_no){
   
    

    //$url = 'https://c6f5f3249619e243a920b4d9c90f6fe8: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@cosmosmartwatch.myshopify.com/admin/api/2021-04/orders/'.$cust_order_id.'.json';
    $url = 'https://c6f5f3249619e243a920b4d9c90f6fe8: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@cosmosmartwatch.myshopify.com/admin/api/2023-04/orders/'.$cust_order_id.'.json';

      $param=[
          'order'=> [
            'id'=> $cust_order_id,
            'note'=> "Phone $phone_no"
          ]
        ];
      
    $param = json_encode($param);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: c6f5f3249619e243a920b4d9c90f6fe8',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   $result = curl_exec($curl);

   if(!$result){die("Connection Failure");}
   curl_close($curl);
} 


function alert_old($to,$dev_arr,$speedtalk_res,$endpoint){
   
	    // echo "string";
	    // print_r($speedtalk_res);
 	//echo $speedtalk_res['retmess'];

	//	if(trim($speedtalk_res['retmess'])=='fail authentication.id/pass not found.' || $speedtalk_res['retmess']=='Denied access.')
		if(trim($speedtalk_res['retmess'])=='fail authentication.id/pass not found.')
		{
			// echo "string";
				$WebMail=new WebMail();
				$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
				$json_arr=array("response"=>5,"message"=>"013 | Operator Communication error");
				
		}
		else if(trim($speedtalk_res['retmess'])=='Denied access.')
		{
			  $WebMail=new WebMail();
				$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
				$json_arr=array("response"=>5,"message"=>"014 | Operator COmmunication error");
				
		}
		else
		{
			$json_arr=array("response"=>4,"message"=>"012 | Activation error");
		}
		return $json_arr;


} 


function alert_13_01_2023($to,$dev_arr,$speedtalk_res,$endpoint){
   
	    // echo "string";
	    // print_r($speedtalk_res);
 	//echo $speedtalk_res['retmess'];
	$json_arr=array("response"=>4,"message"=>"012 | Activation error");
	//	if(trim($speedtalk_res['retmess'])=='fail authentication.id/pass not found.' || $speedtalk_res['retmess']=='Denied access.')
		if(trim($speedtalk_res['ret'])==2)
		{
			// echo "string";

			 if(trim($speedtalk_res['retmess'])=='fail authentication.id/pass not found.')
			 {
				 		$WebMail=new WebMail();
						$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
						$json_arr=array("response"=>5,"message"=>"013 | Operator Communication error");
			 }
			 else if(trim($speedtalk_res['retmess'])=='Denied access.')
			 {
					  $WebMail=new WebMail();
						$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
						$json_arr=array("response"=>5,"message"=>"014 | Operator COmmunication error");
					
			 }
			 else
			 {
					$json_arr=array("response"=>4,"message"=>"012 | Activation error");
			 }
				
		}
		
		return $json_arr;


} 



function alert($to,$dev_arr,$speedtalk_res,$endpoint){
   
	    // echo "string";
	    // print_r($speedtalk_res);
 	//echo $speedtalk_res['retmess'];
	$json_arr=array("response"=>4,"message"=>"012 | Activation error");
	//	if(trim($speedtalk_res['retmess'])=='fail authentication.id/pass not found.' || $speedtalk_res['retmess']=='Denied access.')
		if(trim($speedtalk_res['ret'])==2)
		{
			// echo "string";

			 if(trim($speedtalk_res['retmess'])=='fail authentication.id/pass not found.')
			 {
				 		$WebMail=new WebMail();
						$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
						$json_arr=array("response"=>5,"message"=>"013 | Operator Communication error");
			 }
			 else if(trim($speedtalk_res['retmess'])=='Denied access.')
			 {
					  $WebMail=new WebMail();
						$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
						$json_arr=array("response"=>5,"message"=>"014 | Operator COmmunication error");
					
			 }
			 else
			 {
					$json_arr=array("response"=>4,"message"=>"012 | Activation error");
			 }
				
		}
		else if(trim($speedtalk_res['ret'])!=1)
		{
						
				 		$WebMail=new WebMail();
						$WebMail->sendAlert($to,$dev_arr,$speedtalk_res,$endpoint);
						$json_arr=array("response"=>5,"message"=>"021 | Operator COmmunication error");
		}
		return $json_arr;


} 

function checkTelnyxAuthError($dev_arr,$telnyx_res)
{
  // print_r($telnyx_res);
		//echo "string";
		if(array_key_exists('statuscode',$telnyx_res))
		{
			//	echo "string2";

				if($telnyx_res['statuscode']==401)
				{

						$db=new Database();
						 $api_log_arr=array("device_id"=>$dev_arr['device_id'],"api"=>$telnyx_res['api'],"response"=>json_encode($telnyx_res),'data'=>$telnyx_res['payload']);
	            
		        //print_r($api_log_arr);
		        $db->Insert(APILOG,$api_log_arr);

		        //$array['error_message']
						$json_arr=array("response"=>5,"message"=>"Operator Communication Error");

						 $WebMail=new WebMail();
			        $WebMail->sendAlertTelnyx($dev_arr,$telnyx_res);

			        
							echo json_encode($json_arr);
							exit();
				}
			 
			
		}
		

} 


function checkTelnyxResponse($dev_arr,$telnyx_res)
{	

	//print_r($telnyx_res);
	if(array_key_exists('errors',$telnyx_res))
	{
		if(count($telnyx_res['errors'])>0)
		{

			if($telnyx_res['errors'][0]['code']!='20100')
					{
							
				
							$db=new Database();
							$api_log_arr=array("device_id"=>$dev_arr['device_id'],"api"=>$telnyx_res['api'],"response"=>json_encode($telnyx_res),'data'=>$telnyx_res['payload']);
					                            				
			        //print_r($api_log_arr);
			        $db->Insert(APILOG,$api_log_arr);
			        $WebMail=new WebMail();
			        $WebMail->sendAlertTelnyx($dev_arr,$telnyx_res);

			        
							if($telnyx_res['errors'][0]['code']=='10010' or $telnyx_res['errors'][0]['code']=='10009' )
							{
								// autorization error
									$WebMail=new WebMail();
									
									$json_arr=array("response"=>5,"message"=>"013 | Operator Communication error");
							}
							
							else
							{
								$json_arr=array("response"=>5,"message"=>"012 | Activation error","block"=>"response_block");
							}

							echo json_encode($json_arr);
							exit();

					}

		}
		
	}

}
function checkSipResponse($sip_response,$dev_arr)
{
	//print_r($sip_response);
	if(array_key_exists('statuscode',$sip_response))
	{

			if($sip_response['statuscode']!=200)
			{
					
					$db=new Database();
					$api_log_arr=array("device_id"=>$dev_arr['device_id'],"api"=>$sip_response['api'],"response"=>json_encode($sip_response),'data'=>$sip_response['payload']);
			                            				
	        //print_r($api_log_arr);
	        $db->Insert(APILOG,$api_log_arr);
	        $WebMail=new WebMail();
	        $WebMail->sendAlertTelnyx($dev_arr,$sip_response);


   				return true;
			}
			else
			{
					return false;
			}
	}


}

function checkNetworkResponse($sip_response,$dev_arr)
{
	if(array_key_exists('statuscode',$sip_response))
	{

			if($sip_response['statuscode']!=200)
			{
					
					$db=new Database();
					$api_log_arr=array("device_id"=>$dev_arr['device_id'],"api"=>$sip_response['api'],"response"=>json_encode($sip_response),'data'=>$sip_response['payload']);
			                            				
	        //print_r($api_log_arr);
	        $db->Insert(APILOG,$api_log_arr);
	        $WebMail=new WebMail();
	        $WebMail->sendAlertTelnyx($dev_arr,$sip_response);
   				return 'standard';
			}
		
	}


}

function checkNetworkApiResponse($sip_response,$dev_arr)
{
	if(array_key_exists('statuscode',$sip_response))
	{

			if($sip_response['statuscode']!=200)
			{
					
						$db=new Database();
					$api_log_arr=array("device_id"=>$dev_arr['device_id'],"api"=>$sip_response['api'],"response"=>json_encode($sip_response),'data'=>$sip_response['payload']);
			                            				
	        //print_r($api_log_arr);
	        $db->Insert(APILOG,$api_log_arr);
	        $WebMail=new WebMail();
	        $WebMail->sendAlertTelnyx($dev_arr,$sip_response);
   				return true;
			}
		
	}


}


function checkNetworkApiResponseNew($sip_response,$dev_arr)
{
	if(array_key_exists('statuscode',$sip_response))
	{

			if($sip_response['statuscode']!=200)
			{
					
					// 	$db=new Database();
					// $api_log_arr=array("device_id"=>$dev_arr['device_id'],"api"=>$sip_response['api'],"response"=>json_encode($sip_response),'data'=>$sip_response['payload']);
			                            				
	    //     //print_r($api_log_arr);
	    //     $db->Insert(APILOG,$api_log_arr);
	        // $WebMail=new WebMail();
	        // $WebMail->sendAlertTelnyx($dev_arr,$sip_response);
   				return true;
			}
		
	}


}

?>