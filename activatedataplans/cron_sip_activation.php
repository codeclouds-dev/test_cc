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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php' ;
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'SipConnection.php' ;



use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\SpeedtalkApi;
use Application\CosmoSipApi;
use Application\TelnyxApi;
use Application\WebMail;
use Application\KlaviyoApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$db=new Database();
$speedtalkapi=new SpeedtalkApi();
$cosmosipapi=new CosmoSipApi();
$telnyxapi=new TelnyxApi();
$mail=new WebMail();
$klaviyo_api=new KlaviyoApi();
$address_id=file_get_contents("cron_sip_activation.txt");

$date= date('Y-m-d',strtotime("-1 day",strtotime(date('Y-m-d'))));


   echo  $query="select device_details_new.*,email,user_mstr.id as user_id,fullName from device_details_new join user_mstr on user_mstr.id=device_details_new.user_id where date(activation_date)>='".$date."'  and lower(network_type_cosmo)='optimized' and address_id>$address_id and network_type='' order by id asc limit 1";

     $activated=0;
     $arr=array();
     $arr['query']=$query;
     $getdevdtls=$db->SelectRaw($arr);
     print_r($getdevdtls);
     // exit();
     $updated_date=date('Y-m-d H:i:s');
     if(count($getdevdtls)>0)
     {

          $product_id=$getdevdtls[0]['shopify_product_id'];
          $sip_res=sipConnectionCreate($getdevdtls[0]['imei'],$getdevdtls[0]['sim_no'],"optimized",$getdevdtls[0]['id'],$getdevdtls[0]['email']);
          if(is_array($sip_res))
          {
                    if($sip_res['response']==1)
                    {
                         $activated=1;
                         $watch_phone_number=$sip_res['watch_phone_number'];
                       
                          $db->update(DEVICETABLE,array('phone_number'=>$sip_res['watch_phone_number'],'network_type'=>'optimized'),array("where id='".$getdevdtls[0]['id']."'"));
                            $db->update(SIPPENDING,array('updated_date'=>date('Y-m-d')),array("where device_id='".$getdevdtls[0]['id']."'"));
                    }
                   
          }


          if($activated)
          {
          
              // $plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");

              // $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan");

       $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract");
               $db->Update(DEVICETABLE,array('status'=>2),array("where id='".$getdevdtls[0]['id']."'"));

               $db->Update(USERTABLE,array('status'=>2),array("where id='".$getdevdtls[0]['user_id']."'"));
               
               $createlistto_klaviyo=array();
               $createlistto_klaviyo['email']=$getdevdtls[0]['email'];
               $createlistto_klaviyo['fullName']=$getdevdtls[0]['fullName'];
               
               $createlistto_klaviyo['plan_type']=$plan_array[$product_id];
               $createlistto_klaviyo['plan_order_number']=$getdevdtls[0]['shopify_order_number'];
               $createlistto_klaviyo['watch_phone_number']=$watch_phone_number;
               $klaviyo=array();
               $klaviyo['profiles']=$createlistto_klaviyo;
               $res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
               //print_r($res_klaviyo);

               $createlistto_klaviyo1=array();
               $createlistto_klaviyo1['email']=$getdevdtls[0]['email'];
               $createlistto_klaviyo1['fullName']=$getdevdtls[0]['fullName'];
               
      
               $createlistto_klaviyo1['plan_type']=$plan_array[$product_id];
               $createlistto_klaviyo1['plan_order_number']=$getdevdtls[0]['shopify_order_number'];
               $createlistto_klaviyo1['watch_phone_number']=$watch_phone_number;
               $createlistto_klaviyo1['sim_type']='Speedtalk';
               $klaviyo1=array();
               $klaviyo1['profiles']=$createlistto_klaviyo1;
               
               $res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
               //print_r($res_klaviyo1);


               
               $response=$mail->sendConfirmationMailNew($getdevdtls[0]['email'],$plan_array[$product_id],$watch_phone_number,$getdevdtls[0]['provider']);
               //print_r($response);
               if($response>=200 and $response<=299)
               {
                    $status=1;
               }
               else
               {
                    $status=0;
               }
               
               $mail_details=array("device_id"=>$getdevdtls[0]['id'],"mail_id"=>$getdevdtls[0]['email'],"status"=>$status,"response"=>$response);
               $db->Insert(MAILDETAILS,$mail_details);

               //insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);
              
          
          }

     }


if(count($getdevdtls)>0)
{

     if($getdevdtls[0]['address_id']!="")
     {
          file_put_contents("cron_sip_activation.txt",$getdevdtls[0]['address_id']);

     }
     
     
}
else
     {
          file_put_contents("cron_sip_activation.txt",0);
     }


?>