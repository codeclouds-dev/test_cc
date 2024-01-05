<?php


@session_start();
@ob_start();

//print_r($_SESSION);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include_once "countries.php";
include_once "states.php";
//echo $us_state_abbrevs_names['NEW YORK'];
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'SipConnection.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'RechargeApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'KlaviyoApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'WebMail.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\CosmoSipApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$CosmoSipApi=new CosmoSipApi();
 $activated=0;
echo $query="select device_details_new.*,user_mstr.email,fullName,user_mstr.id as user_id,pending.id as pending_id,pending.status as pending_status,user_mstr.createdDate,product  from pending join device_details_new on device_details_new.id=pending.device_id join user_mstr on user_mstr.id=device_details_new.user_id where date(created_date)='".date('Y-m-d')."' and pending.status<3 and api='sip pending' order by id asc limit 1";
$arr=array();
$arr['query']=$query;
$getdevdtls=$db->SelectRaw($arr);
print_r($getdevdtls);


if(count($getdevdtls)>0)
{
    $order_dtl=$recharge_api->listSubscription($getdevdtls[0]['address_id']);
                       //  echo $order_dtl['subscriptions'][0]['status'];
if($order_dtl['subscriptions'][0]['status']=='ACTIVE')
{
    $db->update(PENDING,array('updated_date'=>date('Y-m-d'),'status'=>$getdevdtls[0]['pending_status']+1),array("where id='".$getdevdtls[0]['pending_id']."'"));

     $order_dtl=$recharge_api->getChargeIdbyAddrId($getdevdtls[0]['address_id']);

     //print_r($order_dtl);

     
     $phone=$order_dtl['orders'][0]['shipping_address']['phone'];
                              $phone = preg_replace( '/[^0-9]/', '', $phone );
                              $addr1=$order_dtl['orders'][0]['shipping_address']['address1'];
                              $addr2=$order_dtl['orders'][0]['shipping_address']['address2'];
                              $city=$order_dtl['orders'][0]['shipping_address']['city'];
                              $poststate=strtoupper($order_dtl['orders'][0]['shipping_address']['province']);
                              $postalcode=$order_dtl['orders'][0]['shipping_address']['zip'];
                              if(strpos($postalcode, "-") !== false){
                                $postalcode=explode("-",$postalcode);
                                   //print_r($postalcode);
                               $postalcode=$postalcode[0];
                              
                              }

         $state=$us_state_abbrevs_names[$poststate];
                            $country=$order_dtl['orders'][0]['shipping_address']['country'];
                            $country=$countries[$country];//'US';

     $product_id=$getdevdtls[0]['shopify_product_id'];
          //$sip_res=sipConnectionCreate($getdevdtls[0]['imei'],$state,$city,$phone,$getdevdtls[0]['sim_no'],"optimized",$getdevdtls[0]['id'],$getdevdtls[0]['email']);

          $sip_array=array("imei"=>$getdevdtls[0]['imei'],"sim_no"=>$getdevdtls[0]['sim_no'],"device_id"=>$getdevdtls[0]['id'],"network_type"=>"optimized");

         $sip_addr_array=array("state"=>$state,"city"=>$city,"phone"=>$phone,"email"=>$getdevdtls[0]['email'],"fullName"=>$getdevdtls[0]['fullName'],"created_at"=>$getdevdtls[0]['createdDate'],"addressCreatedAt"=>date('Y-m-d H:i:s'),"line1"=>$addr1,"line2"=>$addr2,"postalCode"=>$postalcode,"country"=>$country);

         $sip_res=sipConnectionCreate($sip_array,$sip_addr_array);

          if(is_array($sip_res))
          {
                    if($sip_res['response']==1)
                    {
                         $activated=1;
                         $watch_phone_number=$sip_res['watch_phone_number'];
                       
                          $db->update(DEVICETABLE,array('phone_number'=>$sip_res['watch_phone_number'],'network_type'=>'optimized'),array("where id='".$getdevdtls[0]['id']."'"));
                          $db->update(PENDING,array('updated_date'=>date('Y-m-d'),'status'=>4),array("where id='".$getdevdtls[0]['pending_id']."'"));
                    }
                   
          }


          if($activated)
          {
          
              // $plan_array=array("7664495755485"=>"1 Month Dataplan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan");
               
               //$plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan");
     //  $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract");
        $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract","8173820575965"=>"1 Year Plan (Monthly)","8199866679517"=>"Monthly Membership - No Contract","8271818096861"=>"Monthly Plan","8271832711389"=>"6 Month Prepaid Plan");

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


if($getdevdtls[0]['product']=='JT3')
{
    $product_type='JT3';
}
else
{
    $product_type='JT2';
}

               $createlistto_klaviyo1=array();
               $createlistto_klaviyo1['email']=$getdevdtls[0]['email'];
               $createlistto_klaviyo1['fullName']=$getdevdtls[0]['fullName'];
               
      
               $createlistto_klaviyo1['plan_type']=$plan_array[$product_id];
               $createlistto_klaviyo1['plan_order_number']=$getdevdtls[0]['shopify_order_number'];
               $createlistto_klaviyo1['watch_phone_number']=$watch_phone_number;
               $createlistto_klaviyo1['sim_type']='Speedtalk';
               $createlistto_klaviyo1['product_type']=$product_type;

               $klaviyo1=array();
               $klaviyo1['profiles']=$createlistto_klaviyo1;
               
                     if($getdevdtls[0]['product']=='JT3')
                  {
                      $res_klaviyo1=$klaviyo_api->jt3MemberMasterList($klaviyo1);

                  }
                  else
                  {
                      $res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);

                  }


              //$res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
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

}
?>