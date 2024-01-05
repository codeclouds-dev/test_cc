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
require_once 'SpeedtalkHttp.php';

use Application\SpeedtalkHttp;


class SpeedtalkApi1
{

	function __construct() 
	{

		return;

	}

	public function stSIM($simcard)
	{
		$Http=new SpeedtalkHttp();

		$endpoint='?cmd=stSIM&agid='.AGID.'&agpass='.AGPASS.'&sim='.$simcard;
		$sim_dtls=$Http->Curl($endpoint);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	

	public function stActivate($simcard,$data=array())
	{
		$Http=new SpeedtalkHttp();

		$endpoint='?cmd=stActivate&agid='.AGID.'&agpass='.AGPASS.'&sku='.SKU.'&amount='.AMOUNT.'&sim='.$simcard.'&firstName='.$data['fname'].'&lastName='.$data['lname'].'&zip='.$data['zip'].'&city='.$data['city'].'&state='.$data['state'].'&phone='.$data['phone'].'&email='.EMAIL.'&campaign='.CAMPAIGN.'&address1='.$data['address1'].'&cxemail='.$data['cxemail'].'&address2="'.ADDRESS2.'"';
		//$endpoint=rawurlencode($endpoint);
		$endpoint=str_replace(' ','%20',$endpoint);
		
		$sim_dtls=$Http->Curl($endpoint);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	
	public function stAutorefill($phone)
	{
		$Http=new SpeedtalkHttp();

		$endpoint='?cmd=stAutorefill&agid='.AGID.'&agpass='.AGPASS.'&phone='.$phone.'&overage=1&overageCash=5&anniversary=1&sku='.SKU;

		$sim_dtls=$Http->Curl($endpoint);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	

	public function stAutorefillDeactivate($phone)
	{
		$Http=new SpeedtalkHttp();

		$endpoint='?cmd=stAutorefill&agid='.AGID.'&agpass='.AGPASS.'&phone='.$phone.'&overage=1&overageCash=5&anniversary=0&sku='.SKU;

		$sim_dtls=$Http->Curl($endpoint);
		//$sim_dtls_arr=json_decode($sim_dtls,true);
		return $sim_dtls;
	}
	
	

}

//$SpeedtalkApi=new SpeedtalkApi();
//$dv=$SpeedtalkApi->stSIM('867798041154809');
//$dv=$SpeedtalkApi->stSIM('8901240204213168353');
//$dv=$SpeedtalkApi->stSIM('8901240204213168361');
//$dv=$SpeedtalkApi->stSIM('8901240204213168379');





//echo "<br>";
//$dv=$SpeedtalkApi->stActivate('8901240204213168353',array("fname"=>"V","lname"=>"J","email_addr"=>"vj@gmail.com","cxemail"=>"vj@gmail.com"));
//echo "<br>";

//$dv=$SpeedtalkApi->stAutorefill('9853420228');
// echo "<br>";

 //print_r($dv);
?>