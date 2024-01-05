<?php 
// @session_start();
// @ob_start();
// echo phpinfo();
// exit();
//header('Access-Control-Allow-Origin: *');
// header("Content-Type:application/json");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$data = json_decode(file_get_contents('php://input'), true);
print_r($data);


// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri = explode('/', $uri);

// all of our endpoints start with /person
// everything else results in a 404 Not Found
// if ($uri[1] !== 'person') {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// }

// the user id is, of course, optional and must be a number:
// $userId = null;
// if (isset($uri[2])) {
//     $userId = (int) $uri[2];
// }

print_r($_SERVER);
 if(  isset($_SERVER['PHP_AUTH_USER'])  &&  isset($_SERVER['PHP_AUTH_PW'] ) )


 {
    echo "string1";
 }
else
{
    echo "string2";
}
// authenticate the request with Okta:
// if (! authenticate()) {
//     header("HTTP/1.1 401 Unauthorized");
//     exit('Unauthorized');
// }




$seceretKey = '32Xhsdf7asd';
// $headers = apache_request_headers();
// print_r($_SERVER);
//     if(isset($headers['Authorization'])){

//      echo $headers['Authorization'];

//         $api_key = $headers['Authorization'];
//         if($api_key != $seceretKey) 
//         {
//           echo "string";
//             //403,'Authorization faild'; your logic
//             exit;
//         }
//         else
//         {
//           echo "Authorization failed";
//         }
//     }
//     else
//     {
//        echo "Authorization failed.";
//     }


function authenticate() {
    try {
        switch(true) {
            case array_key_exists('HTTP_AUTHORIZATION', $_SERVER) :
                $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
                break;
            case array_key_exists('Authorization', $_SERVER) :
                $authHeader = $_SERVER['Authorization'];
                break;
            default :
                $authHeader = null;
                break;
        }

        echo $authHeader;
        // preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
        // if(!isset($matches[1])) {
        //     throw new \Exception('No Bearer Token');
        // }
       
    } catch (\Exception $e) {

      echo "string";
        return false;
    }
}
//print_r($_SESSION);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');


//echo $us_state_abbrevs_names['NEW YORK'];
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeWebhookApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';



use Application\Database;
use Application\RechargeApi;
use Application\RechargeWebhookApi;

use Application\SpeedtalkApi;


$recharge_api=new RechargeApi();
$db=new Database();
$speedtalk_api=new SpeedtalkApi();
$recharge_webhook_api=new RechargeWebhookApi();

// $valid_passwords = array ("cosmo" => "cosmo123");
// $valid_users = array_keys($valid_passwords);

// $user = $_SERVER['PHP_AUTH_USER'];
// $pass = $_SERVER['PHP_AUTH_PW'];

// $validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

// if (!$validated) {
 
//   header('HTTP/1.0 401 Unauthorized');
//   die ("Not authorized");
// }


print_r($data);

if(isset($data['imei']) or 1==1)
{

	  //$imei=$_POST['imei'];
    $imei='123456789123487';
	  $db=new Database();
	  $check_device=array();
    $check_device['table']=DEVICETABLE;
    $check_device['selector']='id,sim_no,status,address_id,phone_number';
    $check_device['condition']="where imei='".$imei."'";
    
    $checkDeviceExists=$db->Select($check_device);
    if(count($checkDeviceExists)>0)
    { 

    	if($checkDeviceExists[0]['status']==2 and $checkDeviceExists[0]['address_id']!="")
    	{

    		$subs_dtls=$recharge_api->listSubscription($checkDeviceExists[0]['address_id']);
          //print_r($subs_dtls);
          $subs_id=$subs_dtls['subscriptions'][0]['id'];
         //echo "<br>";
         //echo $checkDeviceExists[0]['id'].'-'.$checkDeviceExists[0]['phone_number'];
          $res_rechr=$recharge_webhook_api->cancelSubscription($subs_id);
         // print_r($res_rechr);
          $db->Update(DEVICETABLE,array("status"=>6),array("where id='".$checkDeviceExists[0]['id']."'"));
          $res_speedtalk=$speedtalk_api->stAutorefillDeactivate($checkDeviceExists[0]['phone_number']);
         // print_r($res_speedtalk);
    	}
     else
     {
          echo json_encode(array('message'=>'Not Found'));
     }

    }

}

?>