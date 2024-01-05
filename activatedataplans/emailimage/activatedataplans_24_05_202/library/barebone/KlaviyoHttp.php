<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class KlaviyoHttp 

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

		$api_key="?api_key=".KLAVIYOAPIKEY;

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt( $ch, CURLOPT_POST, 0 );

		curl_setopt( $ch, CURLOPT_HTTPGET, 1 );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$endPoint = KLAVIYOAPIENDPOINT  . $request.$api_key;
		//echo RECHARGEAPIKEY;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );

		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}



	public function Post( $request, $postdata = array(), $method = '' )

	{ 
		//print_r($postdata);

		if(empty( $request ) || empty( $postdata ) )

		{

			return;

		}

		$api_key="?api_key=".KLAVIYOAPIKEY;

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

		curl_setopt( $ch, CURLOPT_TIMEOUT, 180 );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );


			$endPoint = KLAVIYOAPIENDPOINT  . $request.$api_key;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}

	public function PostUnsubscribe( $request, $postdata = array(), $method = '' )

	{ 
		//print_r($postdata);

		if(empty( $request ) || empty( $postdata ) )

		{

			return;

		}

		

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HEADER, true );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );




			$endPoint = KLAVIYOAPIENDPOINT  . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json','revision: 2023-01-24','Authorization: Klaviyo-API-Key '.KLAVIYOAPIKEY ) );
			// curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Klaviyo-API-Key '.KLAVIYOAPIKEY ) );
			// curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'revision: 2023-01-24' ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}

	

}