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
require_once 'KlaviyoHttp.php';

use Application\KlaviyoHttp;


class KlaviyoApi
{

	function __construct() 
	{

		return;

	}

	public function createMembertoList($data=array())
	{
		//print_r($data);
		$Http=new KlaviyoHttp();
		$endpoint='v2/list/SaPyTA/members';
		$createUser=$Http->POST($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}
	public function createMembertoSpeedtalkSubsList($data=array())
	{
		//print_r($data);
		$Http=new KlaviyoHttp();
		$endpoint='v2/list/WyLghF/members';
		$createUser=$Http->POST($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}
	public function createMembertoKlaviyoList($data=array())
	{
		//print_r($data);
		$Http=new KlaviyoHttp();
		$endpoint='v2/list/XdVNdA/members';
		$createUser=$Http->POST($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}
	public function jt3MemberMasterList($data=array())
	{
		//print_r($data);
		$Http=new KlaviyoHttp();
		$endpoint='v2/list/RzH8pq/members';
		$createUser=$Http->POST($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}

	public function unsubscribeList($data)
	{
		//print_r($data);
		$Http=new KlaviyoHttp();
		$endpoint='profile-unsubscription-bulk-create-jobs';
		$createUser=$Http->PostUnsubscribe($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}

	public function createMembertoDataplanSubscriber($data)
	{
		//print_r($data);
		$Http=new KlaviyoHttp();
		$endpoint='v2/list/XDxFZ4/members';
		$createUser=$Http->PostUnsubscribe($endpoint,$data);
		$createUser_arr=json_decode($createUser,true);
		return $createUser_arr;

	}
}

// $gigs=new GigsApi();
// $dv=$gigs->findDevicebyIMEI('867798041154809');
// print_r($dv);
?>