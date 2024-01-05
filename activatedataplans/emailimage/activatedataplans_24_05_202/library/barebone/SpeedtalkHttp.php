<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class SpeedtalkHttp 

{

	function __construct() 

	{

		return;

	}

	public function Curl( $request )
	{

		if( empty( $request ) )

		{

			return;

		} 


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );
		//curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		 $endPoint = SPEEDTALKAPIENDPOINT  . $request;

		curl_setopt( $ch, CURLOPT_URL, $endPoint );
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		//  if (curl_errno($ch)) {

  //     $error_msg2 = curl_error($ch);

  //    // echo $error_msg2;

  // }



	    // execute and return string (this should be an empty string '')
	    $xmlResponse = curl_exec($ch);

		
		 if ($errno=curl_errno($ch)) {

				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return array("error_message"=>$error_message,"api"=>$endPoint,'payload'=>'');

			// echo "string";
			//       $error_msg2 = curl_error($ch);

			//  echo $error_msg2;

			//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//  echo 'HTTP code: ' . $httpcode;



  }

		// Convert xml string into an object 
		$xmlResponse_array = simplexml_load_string($xmlResponse); 
		  
		// Convert into json 
		$xmlResponse_json = json_encode($xmlResponse_array); 
		//echo $xmlResponse_json;

		$response = json_decode($xmlResponse_json, true);
		//echo $response['entity'];
		//print_r($response);

		$resp=array_merge(array('api'=>$endPoint,'payload'=>''),$response);
		curl_close( $ch );

		return $resp;

	}


}