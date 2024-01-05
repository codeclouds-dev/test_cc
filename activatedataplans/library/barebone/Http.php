<?php
/**
 * Http Request
 * @author: Arindam Metya
 * @note: this file is used for HTTP cross server requests
 */

namespace Application;

class Http 

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

		$endPoint = GIGSAPIENDPOINT . GIGSPROJECTNAME .$request;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', GIGSAPIKEY )  ) );

		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		//curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );

		// if (curl_errno($ch)) {
		//     $response = curl_error($ch);
		// }

		curl_close( $ch );

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


		 $endPoint = GIGSAPIENDPOINT . GIGSPROJECTNAME . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', GIGSAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		//curl_setopt($ch, CURLOPT_FAILONERROR, true);

		$response = curl_exec( $ch );

		// if (curl_errno($ch)) {
		// 	echo "curl error";
		// 	print_r($postdata);

		//     $err_str = curl_error($ch);
		//     $error_code=curl_errno($ch);
		//     $response=json_encode(array("error_code"=>$error_code,"err_str"=>$err_str));
		//   //  print_r($response);

		// }


//		$response = curl_exec( $ch );

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


			$endPoint = GIGSAPIENDPOINT . GIGSPROJECTNAME . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', GIGSAPIKEY )  ) );

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


			$endPoint = GIGSAPIENDPOINT . GIGSPROJECTNAME . $request;

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', sprintf( 'authorization: Bearer %s', GIGSAPIKEY )  ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $patchdata ) );


		curl_setopt( $ch, CURLOPT_URL, $endPoint );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return $response;

	}

}