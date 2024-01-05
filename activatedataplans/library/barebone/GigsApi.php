<?php
/**
 * Http Request
 * @author: Vijaya Jha
 * @note: this file is used for Gigs API Call
 */

namespace Application;

error_reporting(E_ALL);

ini_set( 'display_errors', '1' );
@ob_start();
@session_start();


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';
require_once 'Http.php';

use Application\Http;


class GigsApi
{

	function __construct() 
	{

		return;

	}

	public function listAllDevices()
	{
		$Http=new Http();

		$endpoint='/devices';
		$device_dtl=$Http->Get($endpoint);
		$device_dtl_arr=json_decode($device_dtl,true);
		return $device_dtl_arr;
	}
	public function createDevice($data=array())
	{
		//print_r($data);
		$Http=new Http();
		$endpoint='/devices';
		$createDevice=$Http->POST($endpoint,$data);
		$createDevice_arr=json_decode($createDevice,true);
		return $createDevice_arr;
	}
	public function findDevicebyIMEI($imei)
	{
		$Http=new Http();
		$endpoint="/devices/search";
        $post_arr=array('imei'=>$imei);
        $device_dtl=$Http->Post($endpoint,$post_arr);
        $device_dtl_arr=json_decode($device_dtl,true);
        return $device_dtl_arr;
	}
	public function listAllDevicesUsingQueryParams($query_params)
	{
		$Http=new Http();
		if(isset($query_params) and $query_params!="")
		{
			$url="?".$query_params;
		}
		$endpoint='/devices'.$url;
		$device_dtl=$Http->Get($endpoint);
		$device_dtl_arr=json_decode($device_dtl,true);
		return $device_dtl_arr;

	}
	public function updateDevice($endpoint,$data=array())
	{
		$Http=new Http();
		if(isset($endpoint) and $endpoint!="")
		{
			$url=$endpoint;
		}
		$endpoint='/devices/'.$url;
		$device_dtl=$Http->Patch($endpoint,$data);
		$device_dtl_arr=json_decode($device_dtl,true);
		return $device_dtl_arr;

	}


	public function listAllUsers()
	{
		$Http=new Http();
		$endpoint='/users';
		$user_dtls=$Http->Get($endpoint);
		$user_dtl_arr=json_decode($user_dtls,true);
		return $user_dtl_arr;

	}
	public function searchUser($data=array())
	{
		//print_r($data);
		$Http=new Http();
		$endpoint='/users/search';
		$user_dtls=$Http->POST($endpoint,$data);
		
		$user_dtl_arr=json_decode($user_dtls,true);
		
		
		return $user_dtl_arr;

	}
	public function createUser($data=array())
	{
		//print_r($data);
		$Http=new Http();
		$endpoint='/users';
		$createUser=$Http->POST($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}
	public function createUserAddress($user_id,$data=array())
	{
		//print_r($data);
		$Http=new Http();
		$endpoint='/users/'.$user_id.'/addresses';
		$createUser=$Http->POST($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}
	public function listUserAddress($user_id)
	{
		
		$Http=new Http();
		$endpoint='/users/'.$user_id.'/addresses';
		$getuseraddr=$Http->GET($endpoint);
		$useraddr_arr=json_decode($getuseraddr,true);
		return $useraddr_arr;

	}


	public function updateUser($id,$data=array())
	{
		$Http=new Http();
		$endpoint='/users/'.$id;
		$update_user_arr=array("object"=>"user","email"=>$data['email'],"fullName"=>$data['fullName'],"birthday"=>$data['birthday']);
		$updateUser=$Http->Put($endpoint,$update_user_arr);

	}

	public function createSubscription($data=array())
	{
		$Http=new Http();
		$endpoint='/subscriptions';
		$subs_dtls=$Http->POST($endpoint,$data);
		$subs_dtls_arr=json_decode($subs_dtls,true);
		return $subs_dtls_arr;
	}
	public function listAllSubscriptions()
	{
		$Http=new Http();
		$endpoint='/subscriptions';
		$subs_dtls=$Http->Get($endpoint);
		return $subs_dtls;
	}
	public function listAllSUbsusingQueryParams($query_params)
	{
		$Http=new Http();
		if(isset($query_params))
		{
			$url="?".$query_params;
		}
		$endpoint='/subscriptions'.$url;
		$subs_dtls=$Http->Get($endpoint);
		$subs_dtl_arr=json_decode($subs_dtls,true);
		return $subs_dtl_arr;

	}
	

}

// $gigs=new GigsApi();
// $dv=$gigs->findDevicebyIMEI('867798041154809');
// print_r($dv);
?>