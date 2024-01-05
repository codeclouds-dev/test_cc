<?php

/**

 * App

 * Version: 1.0

 * Author: Vijaya Jha

 * @param HTTP POST

 */
@ob_start();
@session_start();

error_reporting(E_ALL);

ini_set( 'display_errors', '1' );

//echo dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'.'activate_dataplans/'. 'library' . DIRECTORY_SEPARATOR . 'Config.php'; exit();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Database.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Http.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Email.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Logger.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Otp.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'WebMail2.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'GlobalFunctions.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'library' .  DIRECTORY_SEPARATOR. 'encriptionCipher.php';


//require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'activate_dataplans/'. 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


use Application\Database;
use Application\Http;
use Application\Email;
use Application\Logger;
use Application\Otp;
use Application\WebMail;





$mail=new WebMail();
//$resemail = $mail->sendMailConfirmation("suderson.halder@codeclouds.com");

$resemail = $mail->sendConfirmationMail("vijaya.jha@codeclouds.com","12345","monthly");


echo "\n----\n";
print_r($resemail);

