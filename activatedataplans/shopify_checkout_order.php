
<?php 


//header('Access-Control-Allow-Origin: *');

@session_start();
@ob_start();

//print_r($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', '1');


include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php' ;
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'WebMail.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';



use Application\Database;
use Application\WebMail;
use Application\SpeedtalkApi;

$db=new Database();
$mail=new WebMail();
$speedtalk=new SpeedtalkApi();

$data = file_get_contents('php://input');
$arr=json_decode($data,true);

$product_arr=$arr['line_items'];
$email=isset($arr['email'])?$arr['email']:'NULL';

$product_id=checkProductShopify($product_arr); 
if(strtolower($arr['gateway'])!='stripe' and strtolower($arr['gateway'])!='')
{
if($product_id)
{
	$check_user_arr=array();
    $check_user_arr['table']='user_mstr';
    $check_user_arr['selector']='id';
    $check_user_arr['condition']="where email='".$email."'";
    
    $checkUserExists=$db->Select($check_user_arr);
    if(count($checkUserExists)>0)
    {
        $exists_in_actv='YES';
    	$user_id=$checkUserExists[0]['id'];
    	$check_dev_arr['table']='device_details_new';
        $check_dev_arr['selector']='imei,sim_no';
        $check_dev_arr['condition']="where user_id='".$user_id."' and status='1'";
        
        $checkDevExists=$db->Select($check_dev_arr);
        if(count($checkDevExists)>0)
        {
        	$imei=$checkDevExists[0]['imei'];
            $sim_no=$checkDevExists[0]['sim_no'];

        }
        else
        {
            $imei='NULL';
            $sim_no='NULL';
        }

       
         $textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."==email=>".$email."==product_arr=>".print_r($product_arr,true);
        
         $orderfile = fopen("shopify_checkout_order.txt", "a") or die("Unable to open file!");
         fwrite($orderfile, $textDataOrder);
         fclose($orderfile);


    }
    else
    {
         $exists_in_actv='NO';
    }
  
         
         // $res=$speedtalk->stSIM($sim_no);
         // if($res['ret']==0)
         // {
         //    $status='Inactive';
         // }
         // else
         // {
         //    $status='Active';
         // }
	     $dev_arr=array();
         $dev_arr['email']=$email;
         $dev_arr['shopify_order']=$arr['order_number'];
         $dev_arr['imei']=$imei;
         $dev_arr['sim_no']=$sim_no;
      //   $dev_arr['speedtalk_status']=$status;
         $dev_arr['exists_in_actv']=$exists_in_actv;
         $mail->sendAlertShopifyCheckout($dev_arr);
     
}

$textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."==email=>".$email."==product_arr=>".print_r($product_arr,true)."==product_id=>".$product_id;
        
         $orderfile = fopen("shopify_checkout_order.txt", "a") or die("Unable to open file!");
         fwrite($orderfile, $textDataOrder);
         fclose($orderfile);
}




	// $textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."tttttttttttttt";
	

?>

