<?php
header('Access-Control-Allow-Origin: *');

@session_start();
@ob_start();

print_r($_SESSION);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include "countries.php";
include "states.php";
//echo $us_state_abbrevs_names['NEW YORK'];
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';

use Application\Database;
use Application\GigsApi;

$gigs=new GigsApi();
$db=new Database();



if(isset($_POST['checkout']) and $_POST['checkout']!="")
{

	$checkout_arr=json_decode($_POST['checkout'],true);
	print_r($checkout_arr);

	//$checkout_arr['line_items'][0]['product_id'];
	$product_arr=$checkout_arr['line_items'];
	print_r($product_arr);
	echo $order_number=$_POST['order_number'];

	echo "--".$product_id=checkSubscriptionProduct($product_arr); // return product id exists in the line_items array
	if($product_id)
    {
    	echo "string if ";

		    $email=$checkout_arr['email'];
			$phone=$checkout_arr['phone'];
			$addr1=$checkout_arr['shipping_address']['address1'];
			$addr2=$checkout_arr['shipping_address']['address2'];
			$city=$checkout_arr['shipping_address']['city'];
			$poststate=strtoupper($checkout_arr['shipping_address']['province']);
			$postalcode=$checkout_arr['shipping_address']['zip'];
			//$country=$checkout_arr['shipping_address']['country'];
			$country='US';
			//$product_id=$_POST['product_id'];

			$state=$us_state_abbrevs_names[$poststate];

			//check user in local db

			$user_arr=array();
		    $user_arr['table']=USERTABLE;
		    $user_arr['selector']="id,fullName";
		    $user_arr['condition']="where email='".$email."'";

		    $getUserDtls=$db->Select($user_arr);
		    //print_r($getUserDtls);

		    if(count($getUserDtls)>0)
		    {
		    	echo "email";
		    	$gigs_user_array=array();
		    	$gigs_user_array['object']='user';
		    	$gigs_user_array['email']=$email;
		    	$gigs_user_array['fullName']=$getUserDtls[0]['fullName'];
		    	
		    	$device_arr=array();
			    $device_arr['table']=DEVICETABLE;
			    $device_arr['selector']="id,imei";
			    $device_arr['condition']="where user_id='".$getUserDtls[0]['id']."' and status=1";
			    $getDeviceDtls=$db->Select($device_arr);
				//print_r($getDeviceDtls);

			    if(count($getDeviceDtls)>0)
			    {
			    	echo "device ";
			    	
			    	$db->Update(USERTABLE,array('phoneNumber'=>$phone),array("where id='".$getUserDtls[0]['id']."'"));
			    	// check user exits in 

			    	$gigs_user_exist=$gigs->searchUser(array('email'=>$email));
			    	//print_r($gigs_user_exist);
			    	if(count($gigs_user_exist['items'])>0)
			    	{
			    		
			    		$gigs_user_id=$gigs_user_exist['items'][0]['id'];
			    	}
			    	else
			    	{
			    		
			    		$gigs_userdtls=$gigs->createUser($gigs_user_array);
			    		//print_r($gigs_userdtls);
			    		$gigs_user_id=$gigs_userdtls['id'];
			    	}


		    		

			    		$gis_devicedtls=$gigs->findDevicebyIMEI($getDeviceDtls[0]['imei']);
			    		//print_r($gis_devicedtls);
			    		
		    		
		    			$gigs_device_id=$gis_devicedtls['items'][0]['id'];
		    			$gigs_sim_id=$gis_devicedtls['items'][0]['sims'][0]['id'];
		    			
		    			$updatedvc=$gigs->updateDevice($gigs_device_id,array("user"=>$gigs_user_id));
		    			echo "<br>";
		    			//print_r($updatedvc);


		    			$user_addr_arr=array();
		    			$user_addr_arr['object']='userAddress';
		    			$user_addr_arr['line1']=$addr1;
		    			$user_addr_arr['line2']=$addr2;
		    			$user_addr_arr['city']=$city;
		    			$user_addr_arr['state']=$state;
		    			$user_addr_arr['postalCode']=$postalcode;
		    			$user_addr_arr['country']=$country;
		    			
		    			$gigs_useraddrdtls=$gigs->createUserAddress($gigs_user_id,$user_addr_arr);
		    			print_r($gigs_useraddrdtls);
		    			

		    			if($gigs_useraddrdtls['object']=='error' and $gigs_useraddrdtls['message']=='Address already exists.')
		    			{
		    				$listuseraddr=$gigs->listUserAddress($gigs_user_id);
		    				//print_r($listuseraddr);
		    				foreach($listuseraddr['items'] as $val)
		    				{
		    					if($val['line1']==$addr1 and $val['line2']==$addr2 and $val['postalCode']==$postalcode)
		    					{
		    						$gigs_user_Addr_id=$val['id'];
		    					}
		    				}
		    			}
		    			else
		    			{
		    				$gigs_user_Addr_id=$gigs_useraddrdtls['id'];
		    			}

		    			$user_addr_ldb=array("line1"=>$addr1,"line2"=>$addr2,"city"=>$city,"state"=>$state,"postalCode"=>$postalcode,"country"=>$country,"user_id"=>$getUserDtls[0]['id']);
		    			$last_id=$db->Insert(USERADDRESS,$user_addr_ldb);

		    			// if there is only one plan in gigs then plan id will be static
		    			//$plan_array=array("6665229926568"=>"01FXWK88EESVBN4X19PFJPG75C","6665231302824"=>"01FXWK88EESVBN4X19PFJPG75C");
		    			$plan_id="01FXWJYWZ73XH72TNAMC09DCW8";
		    			$subs_arr=array();
		    			$subs_arr['plan']=$plan_id;
		    			//$subs_arr['sim']=$gigs_sim_id;
		    			$subs_arr['sim']="sim_test_psim";
		    			$subs_arr['userAddress']=$gigs_user_Addr_id;
		    			$subs_arr['user']=$gigs_user_id;
		    			
		    			$create_subscription=$gigs->createSubscription($subs_arr);
		    			print_r($create_subscription);
		    		
		    			$db->Update(DEVICETABLE,array('status'=>2,'order_number'=>$order_number),array("where id='".$getDeviceDtls[0]['id']."'"));
			    
			    }

		    	
		    }

    }

	

}
?>