<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class RechargeHttp 

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

		$endPoint = RECHARGEAPIENDPOINT  . $request;
		//echo RECHARGEAPIKEY;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization:  %s', RECHARGEAPIKEY )  ) );

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

	public function getRecharge($request)
	{

		$endPoint = RECHARGEAPIENDPOINT  . $request;
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $endPoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'X-Recharge-Version: 2021-11',
		    sprintf('Authorization: Bearer %s',RECHARGEAPIKEY)
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$response=json_encode(array_merge(json_decode($response, true),array("api"=>$endPoint)));

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


			$endPoint = RECHARGEAPIENDPOINT  . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', RECHARGEAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

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


			$endPoint = RECHARGEAPIENDPOINT . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', RECHARGEAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $putdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}

	public function Patch( $request, $patchdata = array(), $method = '' )

	{ 

		if(empty( $request ) || empty( $patchdata ) )

		{

			return;

		}


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

		curl_setopt( $ch, CURLOPT_TIMEOUT, 180 );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );


			$endPoint = RECHARGEAPIENDPOINT  . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', RECHARGEAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $patchdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}

}