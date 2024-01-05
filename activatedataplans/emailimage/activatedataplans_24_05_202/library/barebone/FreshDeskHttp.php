<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class CosmoHttp 

{

	function __construct() 

	{

		return;

	}

	public function Post($endpoint,$data)
	{

		if( empty( $endpoint ) )

		{

			return;

		} 
		//print_r($data);
			$endpoint=FRESHDESKAPIENDPOINT.$endpoint;


			$ch = curl_init();
		

			curl_setopt($ch, CURLOPT_URL,$endpoint);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json'));

			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_USERPWD, FRESHDESK_USERNAME . ":" . FRESHDESK_PASSWORD);
			$result=curl_exec ($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
			
			//echo $status_code;
			//print_r($result);
		
		 	if ($errno=curl_errno($ch)) {

				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return array("statuscode"=>$status_code,"error_message"=>$error_message,"api"=>$endpoint);

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
				$resp=array_merge(array('api'=>$endpoint,"statuscode"=>$status_code),$response);
		}
		else
		{
			$resp=array_merge(array('api'=>$endpoint),array('error'=>$response,"statuscode"=>$status_code));
		}
	
		curl_close( $ch );

		return $resp;

	}


}