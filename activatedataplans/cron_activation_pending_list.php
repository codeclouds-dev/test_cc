<?php 


include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'SpeedtalkApi.php';

use Application\Database;
use Application\SpeedtalkApi;

$db=new Database();
$speedtalk=new SpeedtalkApi();


if(isset($_GET['start']) and isset($_GET['end']) and $_GET['start']!="" and $_GET['end']!="")
{
	$start=$_GET['start'];
	$end=$_GET['end'];
	
}
else
{
	exit();
}

 echo $query="select pending.id as actv_id,device_details_new.id as device_id,device_details_new.sim_no from pending join device_details_new on pending.device_id=device_details_new.id where device_details_new.status='5' and pending.status=0 and created_date between DATE_SUB(now(), INTERVAL $end HOUR) and DATE_SUB(now(), INTERVAL $start HOUR) and api='activation pending' order by pending.id asc";

$arr=array();
$arr['query']=$query;
$get_actv_pending=$db->SelectRaw($arr);

print_r($get_actv_pending);

if(count($get_actv_pending)>0)
{

	foreach($get_actv_pending as $val)
	{

			// print_r($val);
			$sim_no=$val['sim_no'];
			$response=$speedtalk->stSim($sim_no);
			//	print_r($response);
				

				if (strpos($response['retmess'], 'was used, phone#')) { 
					$explode_phone=explode("#",$response['retmess']);
		    		//print_r($explode_phone);
		    		$phone=rtrim($explode_phone[1],'.');
		    		$phone =trim($phone," ");

		    		$activation_date=date('Y-m-d H:i:s');

		    		$db->update(PENDING,array('status'=>1),array("where id='".$val['actv_id']."'"));
		    		$db->update(DEVICETABLE,array('status'=>2,'provider_phone_number'=>$phone,'transaction_id'=>'automation','plan_id'=>'automation','activation_date'=>$activation_date),array("where id='".$val['device_id']."'"));
		    		
		    		
				}
	}

}


$var="working activation-".$start.'-'.$end;

			 	$orderfile = fopen("test.txt", "a") or die("Unable to open file!");
			    fwrite($orderfile, $var);
			    fclose($orderfile);
?>