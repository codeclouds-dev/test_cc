<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'WebMail.php';


use Application\RechargeApi;
use Application\Database;




function getFutureOrder(){

	$dataPlans = array('7664492970205','7664495198429','8054644113629','8054650699997','8075971166429','8074743152861','8271832711389');
	$futureObj = new RechargeApi();
	$startDate = date('Y-m-d', strtotime("+5 day"));
	$endDate = date('Y-m-d', strtotime("+6 day"));
	$minDay= 120;
	$orders = $futureObj->getUpcomingOrder($startDate, $endDate);
	$db=new Database();
	//echo $startDate.'-'.$endDate;

	// echo "<pre>";
	// print_r($orders);
	if(is_array($orders) && sizeof($orders)> 0)
	{

		foreach ($orders['charges'] as $value) {

			//print_r($value);
			
			$created_date=date('Y-m-d', strtotime($value['created_at']));

		//	$days= (isset($value['created_at']) && $value['scheduled_at'])?date_diff(date_create($created_date),date_create($value['scheduled_at']))->format('%d'): 0;
			 $diff = (isset($value['created_at']) && $value['scheduled_at'])?(strtotime($value['scheduled_at']) - strtotime($created_date)):0;
      
		    // 1 day = 24 hours 
		    // 24 * 60 * 60 = 86400 seconds
		    $days= ceil(abs($diff / 86400));

			// if($value['address_id']==97359765)
			// {
			// 	echo $created_date;
			// 	echo $value['scheduled_at'];
			// 	echo $days;
			// 	exit();
			// }


			if($days>= $minDay){			
				//print_r($value['line_items']);
				foreach($value['line_items'] as $item){

				 if(in_array($item['external_product_id']['ecommerce'],$dataPlans)){

				 	//echo $item['shopify_product_id']."::::".($days)."\n";

				 	//echo $value['email'].$value['address_id'].$value['id'].$value['first_name'].$value['last_name'].$item['shopify_product_id'].$item['title'];

				 	$end_of_plan_arr=array(
				 		"address_id"=>$value['address_id'],
				 		"email"=>$value['customer']['email'],
				 		"firstName"=>$value['billing_address']['first_name'],
				 		"lastName"=>$value['billing_address']['last_name'],
				 		"productId"=>$item['external_product_id']['ecommerce'],
				 		"productTitle"=>$item['title'],
				 		"scheduledAt"=>$value['scheduled_at'],
				 		"rechargeChargeId"=>$value['id']);
									 
					$db->Insert(ENDOFPLANEMAIL,$end_of_plan_arr);

					//print_r($value);					


				 }
			  }	 

			}
			
		}
	}

//	echo "</pre>";

}

getFutureOrder();

	$orderfile = fopen("test.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, "end of plan email order collection \n");
			    fclose($orderfile);