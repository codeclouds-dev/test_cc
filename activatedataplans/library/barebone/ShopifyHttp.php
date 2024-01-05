<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class ShopifyHttp 

{

	function __construct() 

	{

		return;

	}

	
	public function Get( $request )

	{

		if( empty( $request ) )

		{

			return;

		} 


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt( $ch, CURLOPT_POST, 0 );

		curl_setopt( $ch, CURLOPT_HTTPGET, 1 );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$endPoint = SHOPIFYENDPOINT  . $request;
		//echo RECHARGEAPIKEY;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'X-Shopify-Access-Token: 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'  ) );

		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );

		 if ($errno=curl_errno($ch)) {
		 	
				//echo "string";
				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return json_encode(array("error_message"=>$error_message,"api"=>$endPoint));
    		
				// echo "string";
				//       $error_msg2 = curl_error($ch);

				//  echo $error_msg2;

				//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//  echo 'HTTP code: ' . $httpcode;



 		 }

		curl_close( $ch );

		$response=json_encode(array_merge(json_decode($response, true),array("api"=>$endPoint)));

		return $response;

	}

	public function Put( $request,$postdata )

	{

		if( empty( $request ) )

		{

			return;

		} 


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );


		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		 $endPoint = SHOPIFYENDPOINT  . $request;
		//echo RECHARGEAPIKEY;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'X-Shopify-Access-Token: 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'  ) );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );

		 if ($errno=curl_errno($ch)) {
		 	
				//echo "string";
				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return json_encode(array("error_message"=>$error_message,"api"=>$endPoint));
    		
				// echo "string";
				//       $error_msg2 = curl_error($ch);

				//  echo $error_msg2;

				//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//  echo 'HTTP code: ' . $httpcode;



 		 }

		curl_close( $ch );

		$response=json_encode(array_merge(json_decode($response, true),array("api"=>$endPoint)));

		return $response;

	}


}