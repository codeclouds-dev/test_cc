<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'WebMail.php';


use Application\Database;
use Application\WebMail;

$db=new Database();
$mail=new WebMail();

$schedulate_at = date('Y-m-d', strtotime("+3 day"));
//$schedulate_at='2022-07-31';
$query="select * from end_of_plan_email where scheduledAt='".$schedulate_at."' and status='0' limit 5";
$arr=array();
$arr['query']=$query;
$result=$db->SelectRaw($arr);
//print_r($result);
$dataplan_arr=array();
foreach($result as $val)
{

	$to=$val['email'];
	//$to="vijaya.jha@codeclouds.com";
	$dataplan_arr['full_name']=$val['firstName'].' '.$val['lastName'];
	$dataplan_arr['product_name']=$val['productTitle'];
	//print_r($dataplan_arr);
	//echo "<br>";

	 $status=$mail->sendAlertDataplan($to,$dataplan_arr);
	 //echo "<br>";
	if($status>=200 and $status<=299)
	{
		 $db->Update("end_of_plan_email",array('status'=>1),array("where id=".$val['id'].""));
	}
	else
	{
		$db->Update("end_of_plan_email",array('status'=>2),array("where id=".$val['id'].""));
	}
}


			 	$orderfile = fopen("test.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, "end of plan email \n");
			    fclose($orderfile);

?>