<?php 
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'SpeedtalkApi.php';

use Application\Database;
use Application\SpeedtalkApi;

$db=new Database();
$speedtalk=new SpeedtalkApi();

 
$try_id=file_get_contents("activation_pending_48hrs.txt");



  $query="select activation_pending.id as actv_id,device_details_new.id as device_id,device_details_new.sim_no from activation_pending join device_details_new on device_details_new.id=activation_pending.device_id where  device_details_new.status='5' and  activation_pending.status=0 and created_date < DATE_SUB(now(), INTERVAL 48 HOUR)  and activation_pending.id>$try_id order by activation_pending.id asc limit 5";

$arr=array();
$arr['query']=$query;
$get_actv_pending=$db->SelectRaw($arr);

//print_r($get_actv_pending);

if(count($get_actv_pending)>0)
{

	foreach($get_actv_pending as $val)
	{

			// print_r($val);
			
			$response=$speedtalk->stSim($val['sim_no']);
			//	print_r($response);
				

				if (strpos($response['retmess'], 'was used, phone#')) { 
					$explode_phone=explode("#",$response['retmess']);
		    		//print_r($explode_phone);
		    		$phone=rtrim($explode_phone[1],'.');
		    		$phone =trim($phone," ");

		    		$activation_date=date('Y-m-d H:i:s');

		    		$db->update(ACTIVATION_PENDING,array('status'=>1),array("where id='".$val['actv_id']."'"));
		    		$db->update(DEVICETABLE,array('status'=>2,'phone_number'=>$phone,'transaction_id'=>'automation','plan_id'=>'automation','activation_date'=>$activation_date),array("where id='".$val['device_id']."'"));
		    		
		    		
				}
		
				
	}


}

$try_id=(count($get_actv_pending)<5)? 0:$get_actv_pending[count($get_actv_pending)-1]['actv_id'];
file_put_contents("activation_pending_48hrs.txt", $try_id);

?>