<?php 
@session_start();
@ob_start();

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';

use Application\Database;
use Application\RechargeApi;

$recharge_api=new RechargeApi();

$db=new Database();

// $_POST['email']='vijaya.jha@codeclouds.org';
// $_POST['localstorage_email']='vijaya.jha@codeclouds.com';
// $_POST['localstorage_imei']='123456789123476';
	
$order_dtl=$recharge_api->getOrder($_POST['charge_id']);
//print_r($order_dtl);
checkCurlResponseRecharge($order_dtl,$_POST['email']);
$address_id=$order_dtl['orders'][0]['address_id'];

 $shopify_order_number=$order_dtl['orders'][0]['shopify_order_number'];
$product_arr=$order_dtl['orders'][0]['line_items'];
$product_id=checkSubscriptionProductRecharge($product_arr); 


if(isset($_POST['email']) and $_POST['email']!="" and isset($_POST['localstorage_email']) and $_POST['localstorage_email']!="" and isset($_POST['localstorage_imei']) and $_POST['localstorage_imei']!="")
{
	$arr=array();
    $arr['table']=USERTABLE;
    $arr['selector']="id";
    $arr['condition']="where email='".$_POST['localstorage_email']."'";

    $getUserDtls=$db->Select($arr);

    $device_dtls=array();
    $device_dtls['table']=DEVICETABLE;
    $device_dtls['selector']="id";
    $device_dtls['condition']="where user_id='".$getUserDtls[0]['id']."'";
    
    $getDeviceDtls2=$db->Select($device_dtls);

    if(count($getDeviceDtls2)>0)
	{
		//echo "string";
		$arr2=array();
	    $arr2['table']=USERTABLE;
	    $arr2['selector']="id";
	    $arr2['condition']="where email='".$_POST['email']."'";
	    
	    $getUserDtls2=$db->Select($arr2);
	    

	    if(count($getUserDtls2)>0)
	    {

	    	// echo "if";
	    	 $user_id=$getUserDtls2[0]['id'];
	    	 
	    	 $db->Update(DEVICETABLE,array('user_id'=>$user_id,'address_id'=>$address_id,'status'=>5,"shopify_product_id"=>$product_id,'payment_date'=>date('Y-m-d H:i:s'),'shopify_order_number'=>$shopify_order_number),array("where imei='".$_POST['localstorage_imei']."'"));
	    	 echo json_encode(array("response"=>true));
	    }
	    else
	    {
	    	//echo "else";
	    	$user_arr=array("email"=>$_POST['email']);
			 
			$new_user_id=$db->Insert(USERTABLE,$user_arr);
			$db->Update(DEVICETABLE,array('user_id'=>$new_user_id,'address_id'=>$address_id,'status'=>5,"shopify_product_id"=>$product_id,'payment_date'=>date('Y-m-d H:i:s'),'shopify_order_number'=>$shopify_order_number),array("where imei='".$_POST['localstorage_imei']."'"));
	    	 echo json_encode(array("response"=>true));
	    }

	}
	else
	{

		//	echo "string1";
		 $db->Update(USERTABLE,array('email'=>$_POST['email']),array("where email='".$_POST['localstorage_email']."'"));
		 $db->Update(DEVICETABLE,array('address_id'=>$address_id,'status'=>5,"shopify_product_id"=>$product_id,'payment_date'=>date('Y-m-d H:i:s'),'shopify_order_number'=>$shopify_order_number),array("where imei='".$_POST['localstorage_imei']."'"));

		 echo json_encode(array("response"=>true));
	}


}
else
{
	echo json_encode(array("response"=>false));
}

?>