<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class CosmoSipHttp 

{

	function __construct() 

	{

		return;

	}



/*	public function Post($endpoint,$data,$apikey)
	{

		if( empty( $endpoint ) )

		{

			return;

		} 
		//print_r($data);
			$endpoint=COSMOSIPAPIENDPOINT.$endpoint;


			$ch = curl_init();
			curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_DIGEST);
		

			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_STDERR,fopen('ssl.txt', 'a'));
					
			curl_setopt($ch, CURLOPT_VERBOSE,1);

			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', $apikey )  ) );
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$result=curl_exec ($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
			
			//echo $status_code;
			//print_r($result);
		
		 	if ($errno=curl_errno($ch)) {

				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return array("statuscode"=>$status_code,"error_message"=>$error_message,"api"=>$endpoint,'payload'=>json_encode($data));

			// echo "string";
			//       $error_msg2 = curl_error($ch);

			//  echo $error_msg2;

			//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//  echo 'HTTP code: ' . $httpcode;



 		 }


		$response = json_decode($result, true);
		//echo $response['entity'];
		//print_r($response);

		if(is_array($response))
		{
				$resp=array_merge(array('api'=>$endpoint,"statuscode"=>$status_code,'payload'=>json_encode($data)),$response);
		}
		else
		{
			$resp=array_merge(array('api'=>$endpoint),array('error'=>$response,"statuscode"=>$status_code,'payload'=>json_encode($data)));
		}
	
		curl_close( $ch );

		return $resp;

	}*/

	public function Post($endpoint,$data,$apikey)
	{

		if( empty( $endpoint ) )

		{

			return;

		} 
		//print_r($data);
			$endpoint=COSMOSIPAPIENDPOINT.$endpoint;


			$ch = curl_init();
			curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_DIGEST);
		

			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json'));
			//curl_setopt($ch, CURLOPT_STDERR,fopen('ssl.txt', 'a'));
					
			curl_setopt($ch, CURLOPT_VERBOSE,1);

			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', $apikey )  ) );
			//curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$result=curl_exec ($ch);
			//print_r($result);
			 $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
			$success_status=array('200','201','202','203','204','205','206','207','208','226');
			if( !in_array($status_code, $success_status))
			{
				
				$result=json_decode($result,true);
				//print_r($result);
				if(!is_array($result))
				{

				  $result = 'COSMO Server Error';

				}
				
				//$error=isset($response['error']['detail'])?$response['error']['detail']:curl_error($ch);
				return array("statuscode"=>$status_code,"error_message"=>$result,"api"=>$endpoint,'payload'=>json_encode($data));

			}
			//echo $status_code;
			//print_r($result);
		
		

		$response = json_decode($result, true);
		//echo $response['entity'];
		//print_r($response);

		if(is_array($response))
		{
				$resp=array_merge(array('api'=>$endpoint,"statuscode"=>$status_code,'payload'=>json_encode($data)),$response);
		}
		else
		{
			$resp=array_merge(array('api'=>$endpoint),array('error'=>$response,"statuscode"=>$status_code,'payload'=>json_encode($data)));
		}
	
		curl_close( $ch );

		return $resp;

	}


public function PostToken($endpoint,$data)
	{

		if( empty( $endpoint ) )

		{

			return;

		} 
		//print_r($data);
			$endpoint=COSMOSIPAPIENDPOINT.$endpoint;


			$ch = curl_init();
			curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_DIGEST);
		

			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_POST, 1);

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json'));
curl_setopt($ch, CURLOPT_STDERR,fopen('ssl.txt', 'a'));
					
			curl_setopt($ch, CURLOPT_VERBOSE,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$result=curl_exec ($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
			
			//echo $status_code;
			//print_r($result);
		
		 	if ($errno=curl_errno($ch)) {

				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return array("statuscode"=>$status_code,"error_message"=>$error_message,"api"=>$endpoint,'payload'=>json_encode($data));

			// echo "string";
			//       $error_msg2 = curl_error($ch);

			//  echo $error_msg2;

			//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//  echo 'HTTP code: ' . $httpcode;



 		 }


		$response = json_decode($result, true);
		//echo $response['entity'];
		//print_r($response);

		if(is_array($response))
		{
				$resp=array_merge(array('api'=>$endpoint,"statuscode"=>$status_code,'payload'=>json_encode($data)),$response);
		}
		else
		{
			$resp=array_merge(array('api'=>$endpoint),array('error'=>$response,"statuscode"=>$status_code,'payload'=>json_encode($data)));
		}
	
		curl_close( $ch );

		return $resp;

	}

}