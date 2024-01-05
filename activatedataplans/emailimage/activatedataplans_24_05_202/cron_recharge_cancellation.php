<?php 


//header('Access-Control-Allow-Origin: *');

@session_start();
@ob_start();

//print_r($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', '1');


include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'TelnyxApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php' ;



use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\SpeedtalkApi;
use Application\CosmoSipApi;
use Application\TelnyxApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$db=new Database();
$speedtalkapi=new SpeedtalkApi();
$CosmoSipApi=new CosmoSipApi();
$telnyxapi=new TelnyxApi();


if(isset($_GET['cron']) and $_GET['cron']=='cron1')
{
   echo  $query="select recharge_cancellation.id,device_details_new.phone_number,provider_phone_number,network_type,recharge_cancellation.status,device_details_new.id as device_id,imei,sim_no,email,provider from recharge_cancellation join device_details_new on device_details_new.id=recharge_cancellation.device_id join user_mstr on user_mstr.id=device_details_new.user_id where recharge_cancellation.status=0 order by recharge_cancellation.id asc limit 1";

    

}
else
{  
     $query="select recharge_cancellation.status,recharge_cancellation.id,phone_number,provider_phone_number,network_type,device_details_new.id as device_id,imei,sim_no,email,provider from recharge_cancellation join device_details_new on device_details_new.id=recharge_cancellation.device_id join user_mstr on user_mstr.id=device_details_new.user_id where recharge_cancellation.status>0 and recharge_cancellation.status<5 and date(recharge_cancellation.updated_date)!=".date('Y-m-d')." order by recharge_cancellation.id asc limit 3";

}
     $arr=array();
     $arr['query']=$query;
     $recharge_cancellation=$db->SelectRaw($arr);
     print_r($recharge_cancellation);
     $updated_date=date('Y-m-d H:i:s');
     if(count($recharge_cancellation)>0)
     {
          for($i=0;$i<sizeof($recharge_cancellation);$i++)
          {
                    $phone_number=$recharge_cancellation[$i]['provider_phone_number'];
                    $rech_sts=$recharge_cancellation[$i]['status'];
                  

                    echo $phone_number;

                     $notes='N/A';
                     $db->Update("recharge_cancellation",array('status'=>$rech_sts+1,'updated_date'=>$updated_date,"notes"=>"N/A"),array("where id='".$recharge_cancellation[$i]['id']."'"));

                    $dev_arr=array();
                    $dev_arr['imei']=$recharge_cancellation[0]['imei'];
                    $dev_arr['iccid']=$recharge_cancellation[0]['sim_no'];
                    $dev_arr['email']=$recharge_cancellation[0]['email'];
                    // print_r($dev_arr);
                    // print_r($res);
                        
                 

                    if($phone_number!="")
                    {
echo "string";
                         if(strtolower($recharge_cancellation[$i]['provider'])=='speedtalk')
                         {
                              $res=$speedtalkapi->stAutorefillDeactivate($phone_number);
                              $api_log_arr=array("device_id"=>$recharge_cancellation[$i]['device_id'],"api"=>$res['api'],"response"=>$res['retmess']);
               
                              //print_r($api_log_arr);
                              $db->Insert(APILOG,$api_log_arr);

                              $notes=json_encode($res).'-'.$updated_date;
                              $db->Update("recharge_cancellation",array("notes"=>$notes),array("where id='".$recharge_cancellation[$i]['id']."'"));

                              if($res['ret']==0)
                              {
                                       
                                      if($recharge_cancellation[$i]['network_type']=='optimized')
                                        {
                                           
                                                   $set_cancellation_arr=array("device_id"=>$recharge_cancellation[0]['device_id']);
                                                   //print_r($api_log_arr);
                                                   $db->Insert(SETCANCELLATION,$set_cancellation_arr);
                                            
                                        }
                              
                                   $db->Update("recharge_cancellation",array('status'=>6,'updated_date'=>$updated_date),array("where id='".$recharge_cancellation[$i]['id']."'"));
                              
                              }
                              else
                              {
                                   $db->Update("recharge_cancellation",array('status'=>8,'updated_date'=>$updated_date),array("where id='".$recharge_cancellation[$i]['id']."'"));
                                      $arr=alert("shil@cosmotogether.com",$dev_arr,$res,'stAutorefill Deactivate');

                              }
                         }
                         else if(strtolower($recharge_cancellation[$i]['provider'])=='telnyx')
                         {

                              $telnyx_res=$telnyxapi->deleteSimCard($recharge_cancellation[$i]['sim_no']);
                              $api_log_arr=array("device_id"=>$recharge_cancellation[0]['device_id'],"api"=>$telnyx_res['api'],"response"=>json_encode($telnyx_res));
                              //print_r($api_log_arr);
                              $db->Insert(APILOG,$api_log_arr);
                               $notes=json_encode($telnyx_res).'-'.$updated_date;
                              $db->Update("recharge_cancellation",array("notes"=>$notes),array("where id='".$recharge_cancellation[$i]['id']."'"));

                              if(count($telnyx_res['data'])>0)
                              {
                                     $db->Update("recharge_cancellation",array("status"=>6),array("where id='".$recharge_cancellation[$i]['id']."'"));

                                    $set_cancellation_arr=array("device_id"=>$recharge_cancellation[0]['device_id']);
                                    //print_r($api_log_arr);
                                    $db->Insert(SETCANCELLATION,$set_cancellation_arr);
                              }
                              
                         }
               
                    }
                    else
                    {
                         echo "string2";
                         if(strtolower($recharge_cancellation[$i]['provider'])=='speedtalk')
                         {

                              $response=$speedtalkapi->stSIM($recharge_cancellation[$i]['sim_no']);
                              if (strpos($response['retmess'], 'was used, phone#')) { 
                                   
                                   $explode_phone=explode("#",$response['retmess']);
                                   //print_r($explode_phone);
                                   $phone=rtrim($explode_phone[1],'.');
                                   $phone =trim($phone," ");

                                   $res=$speedtalkapi->stAutorefillDeactivate($phone);
                                   $notes=json_encode($res).'-'.$updated_date;
                                   $db->Update("recharge_cancellation",array("notes"=>$notes),array("where id='".$recharge_cancellation[$i]['id']."'"));

                                   if($res['ret']==0)
                                   {
                                      
                                            
                                        $db->Update("recharge_cancellation",array('status'=>7,'updated_date'=>$updated_date),array("where id='".$recharge_cancellation[$i]['id']."'"));
                                        $db->Update("device_details_new",array('phone_number'=>$phone,'transaction_id'=>'cancellation','plan_id'=>'cancellation'),array("where id='".$recharge_cancellation[$i]['device_id']."'"));
                                         if($recharge_cancellation[$i]['network_type']=='optimized')
                                        {
                                           
                                                   $set_cancellation_arr=array("device_id"=>$recharge_cancellation[0]['device_id']);
                                                   //print_r($api_log_arr);
                                                   $db->Insert(SETCANCELLATION,$set_cancellation_arr);
                                            
                                        }
                                   
                                   }
                                   else
                                   {
                                        $db->Update("recharge_cancellation",array('status'=>8,'updated_date'=>$updated_date),array("where id='".$recharge_cancellation[$i]['id']."'"));
                                           $arr=alert("shil@cosmotogether.com",$dev_arr,$res,'stAutorefill Deactivate');

                                   }
                                   
                              }
                         }
                        
                    }
                    
                    
                    
          }
         
     }


	// $textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."tttttttttttttt";
	 $textDataOrder=PHP_EOL."cron => ". $_GET['cron'];
    	
 	$orderfile = fopen("cron_recharge_cancellation.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);


?>