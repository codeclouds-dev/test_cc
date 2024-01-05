<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class RechargeWebhookHttp 

{

	function __construct() 

	{

		return;

	}

	

	public function WebhookGet( $request )

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

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization:  %s', RECHARGEWEBHOOKAPIKEY )  ) );

		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}


	public function WebhookPost( $request, $postdata = array(), $method = '' )

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

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', RECHARGEWEBHOOKAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}


}