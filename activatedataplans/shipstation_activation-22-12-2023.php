<?php

//header('Access-Control-Allow-Origin: *');

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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'TelnyxApi.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'CosmoSipApi.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'CosmoNetworkApi.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'encriptionCipher.php';

use Application\Database;
use Application\GigsApi;
use Application\RechargeApi;
use Application\KlaviyoApi;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\TelnyxApi;
use Application\CosmoSipApi;
use Application\CosmoNetworkApi;

$gigs=new GigsApi();
$recharge_api=new RechargeApi();
$klaviyo_api=new KlaviyoApi();
$mail=new WebMail();
$db=new Database();
$speedtalk=new SpeedtalkApi();
$TelnyxApi=new TelnyxApi();
$CosmoSipApi=new CosmoSipApi();
$CosmoNetworkApi=new CosmoNetworkApi();
$_SESSION['phone_details']=1;
$activated =0;
echo $query="select refurbed_activation.id as refurb_id,refurbed_activation.shopify_order_id,device_details_new.id,device_details_new.refurbed,device_details_new.shopify_product_id,device_details_new.user_id ,device_details_new.address_id,imei,sim_no,provider,reg_code,email,fullName,createdDate,phoneNumber,referrer,phone_number,telnyx_tag,product FROM `refurbed_activation` join device_details_new on refurbed_activation.address_id=device_details_new.address_id JOIN user_mstr on user_mstr.id=refurbed_activation.user_id where device_details_new.address_id!='' and device_details_new.status='5' and refurbed_activation.status=10";
$arr=array();
$arr['query']=$query;
$getDeviceDtls=$db->SelectRaw($arr);

if(count($getDeviceDtls)>0)
{
$shopify_order_id=$getDeviceDtls[0]['shopify_order_id'];
            $db->Update(REFURBEDACTIVATION,array('status'=>22,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$getDeviceDtls[0]['refurb_id'].""));
  $product_id=$getDeviceDtls[0]['shopify_product_id'];

          $actv_pend=array();
          $actv_pend['table']=PENDING;
          $actv_pend['selector']="id";
          $actv_pend['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
          $getactvpending=$db->Select($actv_pend);
          
          if(count($getactvpending)==0)
          {

          echo "string";
           $res=$recharge_api->getChargeIdbyAddrId($getDeviceDtls[0]['address_id']);
                                             //print_r($res);
                                             $charge_id=$res['orders'][0]['charge_id'];
              $order_dtl=$recharge_api->getOrder($charge_id);

         
            //  $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 2 Year Contract");

          // $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract","8173820575965"=>"1 Year Plan (Monthly)");
            $plan_array=array("7664495755485"=>"COSMO Monthly Membership Service Plan","7664495198429"=>"6 Month Extended Dataplan","7664492970205"=>"12 Month Annual Dataplan","8054644113629"=>"1 Year Prepaid Plan","8054650699997"=>"2 Year Prepaid Plan","8075971166429"=>"2 Year Prepaid Plan","8074743152861"=>"COSMO Membership - 1 Year Contract","8173820575965"=>"1 Year Plan (Monthly)","8199866679517"=>"Monthly Membership - No Contract","8271818096861"=>"Monthly Plan","8271832711389"=>"6 Month Prepaid Plan");
              //echo "string if ";

              $email=$order_dtl['orders'][0]['email'];
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
              //$country=$order_dtl['orders'][0]['shipping_address']['country'];
             // $country='US';
              $country=$order_dtl['orders'][0]['shipping_address']['country'];
              $country=$countries[$country];//'US';
              //$product_id=$_POST['product_id'];

              $state=$us_state_abbrevs_names[$poststate];

              //check user in local db
              $addr1=str_replace("'", "", $addr1);
              $addr2=str_replace("'", "", $addr2);
             
                    //echo "device ";
                    $device_id=$getDeviceDtls[0]['id'];
                    // recharge api response
               

                  //  $referrer=$getDeviceDtls[0]['referrer'];
                    $watch_phone_number=$getDeviceDtls[0]['phone_number'];

                   
                    
                    

                    if($addr2=="")
                    {

                      $addr2=$addr1;

                    }

                      $user_addr_ldb_arr=array();
                      $user_addr_ldb_arr['table']=USERADDRESS;
                      $user_addr_ldb_arr['selector']="count(id) as count";
                      $user_addr_ldb_arr['condition']="where lower(line1)='".strtolower($addr1)."' and lower(line2)='".strtolower($addr1)."' and lower(city)='".strtolower($city)."' and state='".$state."' and country='".$country."' and user_id=".$getDeviceDtls[0]['user_id'];

                      $getUserAddrLdbDtls=$db->Select($user_addr_ldb_arr);
                      //print_r($getUserAddrLdbDtls);

                      if($getUserAddrLdbDtls[0]['count']==0)
                      {
                        $user_addr_ldb=array("line1"=>$addr1,"line2"=>$addr2,"city"=>$city,"state"=>$state,"postalCode"=>$postalcode,"country"=>$country,"user_id"=>$getDeviceDtls[0]['user_id']);
                        $last_id=$db->Insert(USERADDRESS,$user_addr_ldb);
                      }
                      

                      echo $sim_no=$getDeviceDtls[0]['sim_no'];

                      if($getDeviceDtls[0]['phone_number']=="" or $getDeviceDtls[0]['phone_number']==NULL  or $getDeviceDtls[0]['phone_number']==0)
                      {

                        
                        if(strtolower($getDeviceDtls[0]['provider'])=='telnyx')
                        {
                            

                            $response=$TelnyxApi->registerSimCard($getDeviceDtls[0]['reg_code'],$getDeviceDtls[0]['telnyx_tag']);
                              //print_r($response);
                                // $response=array();
                                // $response['errors'][0]['code']='20100';
                                // $response['api']='activate';
                                // $response['payload']='aaa';
                                $dev_arr=array();
                                $dev_arr['device_id']=$getDeviceDtls[0]['id'];
                                $dev_arr['imei']=$getDeviceDtls[0]['imei'];
                                $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
                                $dev_arr['email']=$getDeviceDtls[0]['email'];
                                 $dev_arr['subject']="Telnyx Error";
                                  
                               
                               

                              checkCurlResponseNew($response,$getDeviceDtls[0]['id']);
                           //   checkTelnyxResponse($dev_arr,$response);
                              $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$response['api'],"response"=>json_encode($response),'data'=>$response['payload']);
                      
                                            //print_r($api_log_arr);
                                            $db->Insert(APILOG,$api_log_arr);
                                            
                                            if(isset($response['errors']) and count($response['errors'])>0)
                                            {
                                               if($response['errors'][0]['code']=='20100')
                                                {

                                                    $mail->activationPending($getDeviceDtls[0]['email']);
                                                        $arr=array();
                                                        $arr['table']=PENDING;
                                                        $arr['selector']="id";
                                                        $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
                                                        $getactivationdtls=$db->Select($arr);
                                                        //print_r($getactivationdtls);

                                                        if(count($getactivationdtls)==0)
                                                        {

                                                          if($response['errors'][0]['code']=='20100')
                                                          {
                                                            $mes="Web credit";
                                                          }
                                                          else
                                                          {
                                                            $mes="Activation Error";
                                                          }
                                                           $web_credit=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$mes,"priority"=>1);
                                                           //print_r($web_credit);
                                                           $db->Insert(PENDING,$web_credit);
                                                        }
                                                        $json_arr=array("response"=>7,"message"=>"023 | Activation Pending","block"=>"activation_pending");
                                                          

                                                }
                                                else
                                                {
                                                    $json_arr=array("response"=>5,"message"=>"024 | Activation Error","block"=>"response_block2");
                                                    $mail->sendAlertTelnyx($dev_arr,$response);
                                                }
                                            }
                                           
                                            else
                                            {

                                                 $watch_phone_number_telnyx=$response['data'][0]['msisdn'];
                                               $activation_date=date('Y-m-d H:i:s');  

                                              // $db->update(DEVICETABLE,array('provider_phone_number'=>$watch_phone_number_telnyx),array("where id='".$getDeviceDtls[0]['id']."'"));
                                                
                                              $db->update(DEVICETABLE,array('provider_phone_number'=>$watch_phone_number_telnyx,'activation_date'=>$activation_date),array("where id='".$getDeviceDtls[0]['id']."'"));



                                                $db->update(DEVICETABLE,array('network_type_cosmo'=>"optimized"),array("where id='".$getDeviceDtls[0]['id']."'"));
                                               // $sip_res=sipConnectionCreate($getDeviceDtls[0]['imei'],$state,$city,$phone,$getDeviceDtls[0]['sim_no'],"optimized",$getDeviceDtls[0]['id'],$getDeviceDtls[0]['email']);

                                                  $sip_array=array("imei"=>$getDeviceDtls[0]['imei'],"sim_no"=>$getDeviceDtls[0]['sim_no'],"device_id"=>$getDeviceDtls[0]['id'],"network_type"=>"optimized");

                                                $sip_addr_array=array("state"=>$state,"city"=>$city,"phone"=>$phone,"email"=>$getDeviceDtls[0]['email'],"fullName"=>$getDeviceDtls[0]['fullName'],"created_at"=>$getDeviceDtls[0]['createdDate'],"addressCreatedAt"=>date('Y-m-d H:i:s'),"line1"=>$addr1,"line2"=>$addr2,"postalCode"=>$postalcode,"country"=>$country);


                                                $sip_res=sipConnectionCreate($sip_array,$sip_addr_array);




                                              //  print_r($sip_res);
                                                if(is_array($sip_res))
                                                {
                                                    if($sip_res['response']==1)
                                                    {
                                                      $activated=1;
                                                      $watch_phone_number=$sip_res['watch_phone_number'];
                                                        $db->update(DEVICETABLE,array('phone_number'=>$sip_res['watch_phone_number'],'network_type'=>'optimized'),array("where id='".$getDeviceDtls[0]['id']."'"));
                                                        $json_arr=array("response"=>true,"phone"=>$watch_phone_number);
                                                    }
                                                    else if($sip_res['response']==2)
                                                    {
                                                        $json_arr=array("response"=>7,"message"=>"022 | Activation Pending","block"=>"activation_pending");
                                                    }
                                                    else
                                                    {
                                                        $json_arr=array("response"=>false,"message"=>"Unable to Activate","block"=>"response_block");
                                                    }
                                                }
                                            }

                            
                              
                        }
                        else
                        {

                                  $activation_arr=array();

                                  $activation_arr['fname']=$order_dtl['orders'][0]['first_name'];
                                  $activation_arr['lname']=$order_dtl['orders'][0]['last_name'];
                                  $activation_arr['cxemail']=$email;
                                  $activation_arr['zip']=$postalcode;
                                  $activation_arr['state']=$state;
                                  $activation_arr['phone']=$phone;
                                  $activation_arr['address1']=$addr1;
                                  $activation_arr['city']=$city;
                                  
                                  
                                  $response=$speedtalk->stActivate($sim_no,$activation_arr);
                                 print_r($response);

                                  checkCurlResponseNew($response,$device_id);

                                  //print_r($response);
                                  // $response['ret']=0;
                                  // $response['phone']='8082066577';
                                  // $response['api']='stactivate';
                                  // $response['Plan']='Monthly';
                                  // $response['trxid']='98SHJjhdfshjfj';
                                  // $response['retmess']='stactivate';
                                  // $response['payload']='ss';
                                  //print_r($response);
                                  
                                  if(!isset($response['retmess']))
                                  {
                                      if($response['ret']==99)
                                      {
                                          $response['retmess']="Error 99";
                                      }
                                      else
                                      {
                                          $response['retmess']="Error 404";
                                      }
                                   }
                                  $api_log_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$response['api'],"response"=>$response['retmess'],'data'=>$response['payload']);
                                              
                                  //print_r($api_log_arr);
                                  $db->Insert(APILOG,$api_log_arr);

                                  if(array_key_exists('ret',$response))
                                  {
                                    if($response['ret']==0)
                                    {
                                      $watch_phone_number=isset($response['phone'])?$response['phone']:0;
                                      $plan_id=$response['Plan'];
                                      $trxid=isset($response['trxid'])?$response['trxid']:0;
                                      

                                      if($watch_phone_number!=0 and $trxid!=0)
                                      {
                                          $db->update(DEVICETABLE,array('provider_phone_number'=>$watch_phone_number,'plan_id'=>$plan_id,"transaction_id"=>$trxid),array("where id='".$getDeviceDtls[0]['id']."'"));
                                          $autorefill_res=$speedtalk->stAutorefill($watch_phone_number);


                                          $api_log_autorefill_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$autorefill_res['api'],"response"=>$autorefill_res['retmess'],'data'=>$autorefill_res['payload']);
                                                  
                                                        //print_r($api_log_arr);
                                                        $db->Insert(APILOG,$api_log_autorefill_arr);

                                                       // $autorefill_res['ret']=0;
                                          if($autorefill_res['ret']==0)
                                          {
                                                
                                               $getauthtoken_api=$CosmoNetworkApi->getAuthToken();
                                                //print_r($getauthtoken_api);
                                                $dev_arr=array();
                                                $dev_arr['device_id']=$getDeviceDtls[0]['id'];
                                                $dev_arr['imei']=$getDeviceDtls[0]['imei'];
                                                $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
                                                $dev_arr['email']=$getDeviceDtls[0]['email'];
                                               $network=checkNetworkResponse($getauthtoken_api,$dev_arr);
                                                //echo $net;
                                                if($network=="")
                                                {
                                                    $getnetworktype=$CosmoNetworkApi->getNetworkType(array("imei"=>$getDeviceDtls[0]['imei']),$getauthtoken_api['accessToken']);
                                                    $network=$getnetworktype['default_call_network'];
                                                    //print_r($res);
                                                      $getnetworktype_res=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$getnetworktype['api'],"response"=>json_encode($getnetworktype),'data'=>$getnetworktype['payload']);
                                                  
                                                        //print_r($api_log_arr);
                                                        $db->Insert(APILOG,$getnetworktype_res);
                                                }
                                                                                              
                                                
                                              

                                                


                                                  $db->update(DEVICETABLE,array('network_type_cosmo'=>$network),array("where id='".$getDeviceDtls[0]['id']."'"));
                                                  //$getnetworktype['default_call_network']='optimized';

                                                if($network=='optimized')
                                                { 
                                                   //   $sip_res=sipConnectionCreate($getDeviceDtls[0]['imei'],$state,$city,$phone,$getDeviceDtls[0]['sim_no'],"optimized",$getDeviceDtls[0]['id'],$getDeviceDtls[0]['email']);


  $sip_array=array("imei"=>$getDeviceDtls[0]['imei'],"sim_no"=>$getDeviceDtls[0]['sim_no'],"device_id"=>$getDeviceDtls[0]['id'],"network_type"=>"optimized");

                                                $sip_addr_array=array("state"=>$state,"city"=>$city,"phone"=>$phone,"email"=>$getDeviceDtls[0]['email'],"fullName"=>$getDeviceDtls[0]['fullName'],"created_at"=>$getDeviceDtls[0]['createdDate'],"addressCreatedAt"=>date('Y-m-d H:i:s'),"line1"=>$addr1,"line2"=>$addr2,"postalCode"=>$postalcode,"country"=>$country);


                                                $sip_res=sipConnectionCreate($sip_array,$sip_addr_array);



                                                      //print_r($sip_res);

                                                      if(is_array($sip_res))
                                                      {
                                                          if($sip_res['response']==1)
                                                          {
                                                            
                                                              $activated=1;
                                                              $watch_phone_number=$sip_res['watch_phone_number'];
                                                                $db->update(DEVICETABLE,array('phone_number'=>$watch_phone_number,'network_type'=>'optimized'),array("where id='".$getDeviceDtls[0]['id']."'"));
                                                              $json_arr=array("response"=>true,"phone"=>$watch_phone_number);
                                                          }
                                                          else if($sip_res['response']==2)
                                                          {
                                                        

                                                            // sip pending
                                                              $json_arr=array("response"=>7,"message"=>"022 | Activation Pending","block"=>"activation_pending");
                                                          }
                                                          else
                                                          {
                                                              $json_arr=array("response"=>false,"message"=>"Unable to Activate","block"=>"response_block");
                                                          }
                                                      }
                                                }
                                                else
                                                {
                                                    $activated=1;
                                                    $db->update(DEVICETABLE,array('network_type'=>'standard','phone_number'=>$watch_phone_number),array("where id='".$getDeviceDtls[0]['id']."'"));
                                                    setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"device_id"=>$getDeviceDtls[0]['id'],"iccid"=>$getDeviceDtls[0]['sim_no'],"email"=>$getDeviceDtls[0]['email'],"network"=>"standard"));

                                                    $json_arr=array("response"=>true,"phone"=>$watch_phone_number);
                                                    // $get_authtoken_network=$CosmoNetworkApi->getAuthToken(array("imei"=>$imei));
                                                    // $CosmoNetworkApi->setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"network"=>'standard'),$get_authtoken_network['accessToken']);
                                                  //  $CosmoNetworkApi->setActivation(array("imei"=>$getDeviceDtls[0]['imei'],"network"=>'standard'));
                                                }

                                                //  
                                          }
                                          else
                                          {
                                            //Error Activation: Unable to Auto Refill
                                            $json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");

                                            $dev_arr=array();
                                                          $dev_arr['imei']=$getDeviceDtls[0]['imei'];
                                                          $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
                                                          $dev_arr['email']=$getDeviceDtls[0]['email'];

                                                          
                                                          $json_arr=alert("shil@cosmotogether.com",$dev_arr,$autorefill_res,'stAutorefill');
                                                          $json_arr=array_merge(array("block"=>"response_block2"),$json_arr);
                                          }

                                      }
                                      else
                                      {

                                          $mail->activationPending($getDeviceDtls[0]['email']);
                                        
                                          $arr=array();
                                              $arr['table']=PENDING;
                                              $arr['selector']="id";
                                              $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
                                              $getactivationdtls=$db->Select($arr);
                                              //print_r($getactivationdtls);

                                              if(count($getactivationdtls)==0)
                                              {
                                                     $actv_pend=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>"activation pending","priority"=>1);
                                                     //print_r($actv_pend);
                                                     $db->Insert(PENDING,$actv_pend);
                                              }
                                          



                                        $json_arr=array("response"=>7,"message"=>"016 | Activation Pending","block"=>"activation_pending");
                                      }

                                    }
                                    else
                                    {
                                      //$response['retmess']
                                      if($response['ret']==1)
                                      {
                                           
                                        if(strpos($response['retmess'], "Zip code no valid") !== false)
                                        {
                                            $json_arr=array("response"=>7,"message"=>"016 | Activation Pending","block"=>"activation_pending");
                                        }
                                        else if(strpos($response['retmess'], "No web-credit available.") !== false)
                                        {


                                        

                                            $dev_arr=array();

                                                          $dev_arr['imei']=$getDeviceDtls[0]['imei'];
                                                          $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
                                                          $dev_arr['email']=$getDeviceDtls[0]['email'];
                                                          
                                                          $json_arr=alert("shil@cosmotogether.com",$dev_arr,$response,'stActivate');

                                            $arr=array();
                                            $arr['table']=PENDING;
                                            $arr['selector']="id";
                                            $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
                                            $getactivationdtls=$db->Select($arr);
                                            //print_r($getactivationdtls);

                                            if(count($getactivationdtls)==0)
                                            {
                                               $web_credit=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>"Web Credit","priority"=>1);
                                               //print_r($web_credit);
                                               $db->Insert(PENDING,$web_credit);
                                            }
                                        
                                              $json_arr=array("response"=>7,"message"=>"023 | Activation Pending","block"=>"activation_pending");

                                          //  $json_arr=array_merge(array("block"=>"response_block2"),$json_arr);

                                          
                                        }
                                        
                                        else if(strpos($response['retmess'], "Already submitted or not available.") !== false)
                                        {
                                          $mail->activationPending($getDeviceDtls[0]['email']);
                                          //$mail->activationPending("vijaya.jha@codeclouds.com");

                                          $arr=array();
                                              $arr['table']=PENDING;
                                              $arr['selector']="id";
                                              $arr['condition']="where device_id='".$getDeviceDtls[0]['id']."'";
                                              $getactivationdtls=$db->Select($arr);
                                              //print_r($getactivationdtls);

                                              if(count($getactivationdtls)==0)
                                              {
                                                 $actv_pend=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>"activation pending","priority"=>1);
                                           //print_r($actv_pend);
                                           $db->Insert(PENDING,$actv_pend);
                                              }

                                          $json_arr=array("response"=>7,"message"=>"017 | Already submitted or not available.","block"=>"activation_pending");
                                        }
                                        else
                                        {
                                          $json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");

                                        }
                                        
                                      }
                                      else
                                      {
                                        $json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");

                                        $dev_arr=array();

                                        $dev_arr['imei']=$getDeviceDtls[0]['imei'];
                                        $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
                                        $dev_arr['email']=$getDeviceDtls[0]['email'];
                                        
                                        $json_arr=alert("shil@cosmotogether.com",$dev_arr,$response,'stActivate');
                                        $json_arr=array_merge(array("block"=>"response_block2"),$json_arr);
                                      }
                                      


                                    }

                                  }
                                  else
                                  {
                                    //Error #111: Unable to activate
                                    $json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");
                                  }

                        }
                        
                      }
                      else
                      {
                        // echo "string";
                        // print_r($getDeviceDtls);
                          $json_arr=array("response"=>false,"message"=>"000 | Unable to Activate","block"=>"response_block2");
                      }
                    /*  else
                      {
                        $autorefill_response=$speedtalk->stAutorefill($watch_phone_number);
                         if(!isset($autorefill_response['retmess']))
                                      {
                                          if($autorefill_response['ret']==99)
                                          {
                                              $autorefill_response['retmess']="Error 99";
                                          }
                                          else
                                          {
                                              $autorefill_response['retmess']="Error 404";
                                          }
                                      }
                        $api_log_autorefill_arr=array("device_id"=>$getDeviceDtls[0]['id'],"api"=>$autorefill_response['api'],"response"=>$autorefill_response['retmess']);
                                    
                                          //print_r($api_log_autorefill_arr);
                                          $db->Insert(APILOG,$api_log_autorefill_arr);


                        //print_r($autorefill_response);
                        //$autorefill_response['ret']=0;
                        if($autorefill_response['ret']==0)
                        {
                          $activated=1;
                          $json_arr=array("response"=>true,"phone"=>$getDeviceDtls[0]['phone_number']);
                        }
                        else
                        {
                          //Unable to Auto Refill
                          $json_arr=array("response"=>false,"message"=>"006 | Unable to Activate","block"=>"response_block");

                          $dev_arr=array();

                                          $dev_arr['imei']=$getDeviceDtls[0]['imei'];
                                          $dev_arr['iccid']=$getDeviceDtls[0]['sim_no'];
                                          $dev_arr['email']=$getDeviceDtls[0]['email'];
                                          
                                          $json_arr=alert("shil@cosmotogether.com",$dev_arr,$autorefill_response,'stAutorefill');
                            $json_arr=array_merge(array("block"=>"response_block2"),$json_arr);

                            
                        }

                      }*/
                    
                      if($activated)
                      {
                      

          
                      $activation_date=date('Y-m-d H:i:s');

                      $db->Update(DEVICETABLE,array('status'=>2,'address_id'=>$getDeviceDtls[0]['address_id'],'activation_date'=>$activation_date),array("where id='".$getDeviceDtls[0]['id']."'"));

                      $db->Update(USERTABLE,array('status'=>2),array("where id='".$getDeviceDtls[0]['id']."'"));
                        $db->Update(REFURBEDACTIVATION,array('status'=>20,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$getDeviceDtls[0]['refurb_id'].""));
                      $createlistto_klaviyo=array();
                      $createlistto_klaviyo['email']=$getDeviceDtls[0]['email'];
                      $createlistto_klaviyo['fullName']=$getDeviceDtls[0]['fullName'];
                      //echo $createlistto_klaviyo['phone_number']=$getDeviceDtls[0]['phoneNumber'];
                      //$createlistto_klaviyo['phone_number']=$phone;
                      
                      $createlistto_klaviyo['plan_type']=$plan_array[$product_id];
                      $createlistto_klaviyo['plan_order_number']=$getDeviceDtls[0]['shopify_order_number'] ;
                      $createlistto_klaviyo['watch_phone_number']=$watch_phone_number;
                      $klaviyo=array();
                      $klaviyo['profiles']=$createlistto_klaviyo;
                      $res_klaviyo=$klaviyo_api->createMembertoList($klaviyo);
                      //print_r($res_klaviyo);


if($getDeviceDtls[0]['product']=='JT3')
{
  $product_type='JT3';
}
else
{
  $product_type='JT2';
}

                      $createlistto_klaviyo1=array();
                      $createlistto_klaviyo1['email']=$getDeviceDtls[0]['email'];
                      $createlistto_klaviyo1['fullName']=$getDeviceDtls[0]['fullname'];
                      //echo $createlistto_klaviyo1['phone_number']=$getDeviceDtls[0]['phoneNumber'];
                      //$createlistto_klaviyo1['phone_number']=$phone;
                      
                      $createlistto_klaviyo1['plan_type']=$plan_array[$product_id];
                      $createlistto_klaviyo1['plan_order_number']=$shopify_order_number;
                      $createlistto_klaviyo1['watch_phone_number']=$watch_phone_number;
                      $createlistto_klaviyo1['sim_type']='Speedtalk';
                      $createlistto_klaviyo1['product_type']=$product_type;


                      $klaviyo1=array();
                      $klaviyo1['profiles']=$createlistto_klaviyo1;
                  
                      if($getDeviceDtls[0]['product']=='JT3')
                  {
                      $res_klaviyo1=$klaviyo_api->jt3MemberMasterList($klaviyo1);

                  }
                  else
                  {
                      $res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);

                  }

                    //$res_klaviyo1=$klaviyo_api->createMembertoSpeedtalkSubsList($klaviyo1);
                    //print_r($res_klaviyo1);


                      $encrypted_phone=PHP_AES_Cipher::encrypt(KEY,IV,$watch_phone_number);
                      $encrypted_imei=PHP_AES_Cipher::encrypt(KEY,IV,$getDeviceDtls[0]['imei']);
                      $encrypted_email=PHP_AES_Cipher::encrypt(KEY,IV,$getDeviceDtls[0]['email']);

                      //$response=$mail->sendConfirmationMail($getDeviceDtls[0]['email'],$shopify_order_number,$plan_array[$product_id],$watch_phone_number);
                      //$response=$mail->sendConfirmationMailNew($getDeviceDtls[0]['email'],$shopify_order_number,$plan_array[$product_id],$watch_phone_number);

                      $response=$mail->sendConfirmationMailNew($getDeviceDtls[0]['email'],$plan_array[$product_id],$watch_phone_number,$getDeviceDtls[0]['refurbed']);
                      //print_r($response);
                      if($response>=200 and $response<=299)
                      {
                        $status=1;
                      }
                      else
                      {
                        $status=0;
                      }
                      
                      $mail_details=array("device_id"=>$getDeviceDtls[0]['id'],"mail_id"=>$getDeviceDtls[0]['email'],"status"=>$status,"response"=>$response);
                      $db->Insert(MAILDETAILS,$mail_details);

                      insertPhoneNoToShopifyNote($shopify_order_id,$watch_phone_number);
                      $json_arr=array("response"=>true,"provider"=>strtolower($getDeviceDtls[0]['provider']),"phone"=>$watch_phone_number,"encrypted_phone"=>$encrypted_phone,"email"=>$email,"encrypted_email"=>$encrypted_email,"referrer"=>$referrer,"imei"=>$encrypted_imei,"uid"=>md5($getDeviceDtls[0]['id']));
                    }
                    else
                    {
                            $db->Update(REFURBEDACTIVATION,array('status'=>21,'updated_date'=>date('Y-m-d H:i:s')),array("where id=".$getDeviceDtls[0]['refurb_id'].""));
                    }
                  
                  

                  
               
                
            
           

          }

}
?>