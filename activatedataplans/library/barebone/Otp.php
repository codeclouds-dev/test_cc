<?php 


/**

 * App

 * Version: 1.0

 * Author: Vijaya Jha

 * @param HTTP POST

 */

 
namespace Application;

class Otp 
{

	function __construct() 
	{

		return;

	}
	function generateOtp()
	{
		$otp=rand(000000,999999);
		return $otp;
	}

}

?>