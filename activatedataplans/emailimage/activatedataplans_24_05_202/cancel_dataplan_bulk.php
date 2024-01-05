<?php 
// @session_start();
// @ob_start();


//echo $us_state_abbrevs_names['NEW YORK'];
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';


use Application\Database;

use Application\SpeedtalkApi;


$db=new Database();
$speedtalk_api=new SpeedtalkApi();
//$arr=array("8901240204213822363","8901240204213366916","8901240204213368821","8901240204213416919","8901240204213823130");
$arr=array("8901240204213838484","8901240204213785347","8901240204213783078","8901240204213351488","8901240204213418600","8901240204213838401","8901240204213782617","8901240204119084845","8901240204118994663","8901240204213418071");

for($i=0;$i<sizeof($arr);$i++)
{


    $iccid=$arr[$i];
	  $check_device=array();
    $check_device['table']=DEVICETABLE;
    $check_device['selector']='id,sim_no,status,address_id,phone_number';
    $check_device['condition']="where sim_no like'%".$iccid."%'";
    
    $checkDeviceExists=$db->Select($check_device);
    if(count($checkDeviceExists)>0)
    { 

	  if(($checkDeviceExists[0]['status']==2 || $checkDeviceExists[0]['status']==6) and $checkDeviceExists[0]['address_id']!="" and $checkDeviceExists[0]['phone_number']!="" )
	  {
            // recharge subscription cancellation begin

    	   //$subs_dtls=$recharge_api->listSubscription($checkDeviceExists[0]['address_id']);
            //print_r($subs_dtls);
          // $subs_id=$subs_dtls['subscriptions'][0]['id'];
         
            //echo $checkDeviceExists[0]['id'].'-'.$checkDeviceExists[0]['phone_number'];
          // $res_rechr=$recharge_webhook_api->cancelSubscription($subs_id);

           // recharge subscription cancellation end


         // print_r($res_rechr);
          $db->Update(DEVICETABLE,array("status"=>6),array("where id='".$checkDeviceExists[0]['id']."'"));
          $res_speedtalk=$speedtalk_api->stAutorefillDeactivate($checkDeviceExists[0]['phone_number']);
 print_r($res_speedtalk);

           $api_log_arr=array("device_id"=>$checkDeviceExists[0]['id'],"api"=>$res_speedtalk['api'],"response"=>$res_speedtalk['retmess']);
                            
          //print_r($api_log_arr);
          $db->Insert(APILOG,$api_log_arr);

            $textDataOrder=PHP_EOL."iccid => ".$iccid."-DONE";
        
            $orderfile = fopen("cancellation_data_bulk.txt", "a") or die("Unable to open file!");
            fwrite($orderfile, $textDataOrder);
            fclose($orderfile);

	 }
     else
     {
             $textDataOrder=PHP_EOL."iccid => ".$iccid."-data error";
        
            $orderfile = fopen("cancellation_data_bulk.txt", "a") or die("Unable to open file!");
            fwrite($orderfile, $textDataOrder);
            fclose($orderfile);
     }

    }
    else
    {
          $textDataOrder=PHP_EOL."iccid => ".$iccid."-ICCID not found";
        
            $orderfile = fopen("cancellation_data_bulk.txt", "a") or die("Unable to open file!");
            fwrite($orderfile, $textDataOrder);
            fclose($orderfile);
    }




}

?>