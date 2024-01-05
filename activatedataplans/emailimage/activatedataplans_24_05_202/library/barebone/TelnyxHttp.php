<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class TelnyxHttp 

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

		$endPoint = TELNYXAPIENDPOINT  . $request;
		//echo TELNYXAPIKEY;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', TELNYXAPIKEY )  ) );

		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );
		//print_r($response);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		 if ($errno=curl_errno($ch)) {
		 	
				//echo "string";
				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return json_encode(array("statuscode"=>$status_code,"error_message"=>$error_message,"api"=>$endPoint,'payload'=>''));
    		
				// echo "string";
				//       $error_msg2 = curl_error($ch);

				//  echo $error_msg2;

				//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//  echo 'HTTP code: ' . $httpcode;



 		 }

		curl_close( $ch );

		$response=json_encode(array_merge(json_decode($response, true),array("api"=>$endPoint,'payload'=>'')));

		return $response;

	}

	
	public function Post( $request, $postdata = array(), $method = '' )

	{ 

		if(empty( $request ) || empty( $postdata ) )

		{

			return;

		}


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

		curl_setopt( $ch, CURLOPT_TIMEOUT, 180 );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );


			$endPoint = TELNYXAPIENDPOINT  . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', TELNYXAPIKEY )  ) );
			//echo json_encode( $postdata ) ;
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


			curl_setopt( $ch, CURLOPT_URL, $endPoint );
			curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );
		//print_r($response);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		 if ($errno=curl_errno($ch)) {
		 	
				//echo "string";
				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return json_encode(array("statuscode"=>$status_code,"error_message"=>$error_message,"api"=>$endPoint,'payload'=>json_encode($postdata)));
    			
				// echo "string";
				//       $error_msg2 = curl_error($ch);

				//  echo $error_msg2;

				//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//  echo 'HTTP code: ' . $httpcode;



 		 }
		

		curl_close( $ch );
		$response=json_encode(array_merge(json_decode($response, true),array("api"=>$endPoint,'payload'=>json_encode($postdata))));
		return $response;

	}




	public function Put( $request, $putdata = array(), $method = '' )

	{ 

		if(empty( $request ) || empty( $putdata ) )

		{

			return;

		}


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt($curl, CURLOPT_PUT, true);

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

		curl_setopt( $ch, CURLOPT_TIMEOUT, 180 );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );


			$endPoint = TELNYXAPIENDPOINT . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', TELNYXAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $putdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}

	public function Delete( $request, $patchdata = array(), $method = '' )

	{ 

		if(empty( $request ) )

		{

			return;

		}


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

		curl_setopt( $ch, CURLOPT_TIMEOUT, 180 );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );


			$endPoint = TELNYXAPIENDPOINT  . $request;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', TELNYXAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $patchdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		 if ($errno=curl_errno($ch)) {
		 	
				//echo "string";
				//echo "error ".$errno;
		 	    $error_message = curl_strerror($errno);
    			//echo "cURL error ({$errno}):\n {$error_message}";

    			return json_encode(array("statuscode"=>$status_code,"error_message"=>$error_message,"api"=>$endPoint,'payload'=>json_encode($patchdata)));
    			
				// echo "string";
				//       $error_msg2 = curl_error($ch);

				//  echo $error_msg2;

				//  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//  echo 'HTTP code: ' . $httpcode;



 		 }
		
		curl_close( $ch );
		$response=json_encode(array_merge(json_decode($response, true),array("api"=>$endPoint,'payload'=>json_encode($patchdata))));
		return $response;

	}

}