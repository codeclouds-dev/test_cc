<?php

/**

 * App

 * Version: 1.0

 * Author: Vijaya Jha

 * @param HTTP POST

 */
@ob_start();
@session_start();

error_reporting(E_ALL);

ini_set( 'display_errors', '1' );

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Database.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Http.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Email.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Logger.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'Otp.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'WebMail.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'SpeedtalkApi.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'RechargeApi.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'barebone' .DIRECTORY_SEPARATOR . 'TelnyxApi.php';

require_once 'GlobalFunctions.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' .  DIRECTORY_SEPARATOR. 'encriptionCipher.php';


//require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


use Application\Database;
use Application\Http;
use Application\Email;
use Application\Logger;
use Application\Otp;
use Application\WebMail;
use Application\SpeedtalkApi;
use Application\RechargeApi;
use Application\TelnyxApi;



class App

{

    function __construct(){

        return;

    }


    public function test() {

        $Http = new Http();
        $otp=new Otp();
        echo "OTP ".$otp->generateOtp();
        echo "<br>";
        return $Http->Get('/devices');
    }
    public function sendMails()
    {
        $mail=new WebMail();
        $mail->sendMail();
    }
    public function createUser($data)
    {

        $db=new Database();
        $new_otp=$data['otp1'].$data['otp2'].$data['otp3'].$data['otp4'].$data['otp5'].$data['otp6'];
        if(isset($_SESSION['userDtls']) and isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 300))
        {
            if($_SESSION['otp']==$new_otp)
            {

                if(isset($_SESSION['loginuser']))
                {
                    $this->loginUser();
                    exit();
                }
                else
                {


                             $db=new Database();
                            //echo "ddd";
                            
                            $check_user_arr=array();
                            $check_user_arr['table']='user_mstr';
                            $check_user_arr['selector']='id';
                            $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
                            
                            $checkUserExists=$db->Select($check_user_arr);
                            //print_r($checkUserExists);

                            if(count($checkUserExists)>0)
                            {
                                $last_id=$checkUserExists[0]['id'];
                            }
                            else
                            {
                               // $user_arr=array("fullName"=>$_SESSION['userDtls']['fname'],"email"=>$_SESSION['userDtls']['email']);
                                $user_arr=array("email"=>$_SESSION['userDtls']['email']);
                                
                                $last_id=$db->Insert('user_mstr',$user_arr);
                            
                            }

                            $_SESSION['active_user']=md5($last_id);
                            unset($_SESSION['userDtls']);
                            unset($_SESSION['otp']);
                            unset($_SESSION['LAST_ACTIVITY']);
                            
                            $json_arr = array("id"=>$last_id,'response'=>true);
                            //print_r($json_arr);
                   }
                   
                
               
            }
            else
            {
                $json_arr = array('response'=>false,'message'=>'The Code is incorrect');
            }
            
            
        }
        else
        {
            $json_arr = array('response'=>false,'message'=>'The Code is expired');
            
        }
        
        echo json_encode($json_arr);

    }
    public function createAppUser($data)
    {

        $db=new Database();
        if(isset($_SESSION['userDtls']) and isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 300))
        {

            if(isset($_SESSION['loginuser']))
            {
                $this->loginUser();
                exit();
            }
            else
            {


                         $db=new Database();
                        //echo "ddd";
                        
                        $check_user_arr=array();
                        $check_user_arr['table']='user_mstr';
                        $check_user_arr['selector']='id';
                        $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
                        
                        $checkUserExists=$db->Select($check_user_arr);
                        //print_r($checkUserExists);

                        if(count($checkUserExists)>0)
                        {
                            $last_id=$checkUserExists[0]['id'];
                        }
                        else
                        {
                           // $user_arr=array("fullName"=>$_SESSION['userDtls']['fname'],"email"=>$_SESSION['userDtls']['email']);
                            $user_arr=array("email"=>$_SESSION['userDtls']['email']);
                                
                            $last_id=$db->Insert('user_mstr',$user_arr);
                        
                        }

                        $_SESSION['active_user']=md5($last_id);
                        unset($_SESSION['userDtls']);
                        unset($_SESSION['otp']);
                        unset($_SESSION['LAST_ACTIVITY']);
                        
                        $json_arr = array("id"=>$last_id,'response'=>true);
                        //print_r($json_arr);
               }

            
        }
        else
        {
            $json_arr = array('response'=>false,'message'=>'The session is expired');
            
        }
        
        echo json_encode($json_arr);

    }
    public function sendMail($data)
    {
           
           if(isset($data['loginUser']) and $data['loginUser']==1)
           {

                $login_user_id=$this->isUserExists($data['email']);
                if($login_user_id)
                {
                    $_SESSION['loginuser']=$login_user_id;
                    
                }
                else
                {
                    echo json_encode(array('response'=>false));
                    exit();

                }
           }
           else
           {
                //unset($_SESSION['loginuser']);

           }

           $_SESSION['userDtls'] = $data;
           // $mail=new WebMail();
           // $mail->sendMail($data['email']);
           // $_SESSION['LAST_ACTIVITY'] = time();

            $db=new Database();
            $email=$_SESSION['userDtls']['email'];
             $check_user_arr=array();
             $check_user_arr['table']='user_mstr';
             $check_user_arr['selector']='id';
             $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
            
             $checkUserExists=$db->Select($check_user_arr);
             
             if(count($checkUserExists)>0)
             {
                $user_id=$checkUserExists[0]['id'];
             }
             else
             {
                $user_arr=array("email"=>$_SESSION['userDtls']['email']);
                
                $user_id=$db->Insert('user_mstr',$user_arr);
             }

                
               
                unset($_SESSION['userDtls']);
                unset($_SESSION['otp']);
                unset($_SESSION['LAST_ACTIVITY']);
             $_SESSION['active_user']=md5($user_id);

             $_SESSION['channel']=$data['channel'];


           // if(isset($data['loginUser']) and $data['loginUser']==1)
           // {
           //      $_SESSION['loginuser']=1;
           // }
           // print_r($_SESSION);

            /*$db=new Database();

            $arr=array();
            $arr['table']="user_mstr";
            $arr['selector']="id";
            $arr['condition']="where email='".$data['email']."'";

            $getUserDtls=$db->Select($arr);
            if(count($getUserDtls)>0)
            {
                  
                  $json_arr = array('response'=>false);
            }
            else
            {
                  $_SESSION['userDtls'] = $data;
                  $mail=new WebMail();
                  $mail->sendMail($data['email']);
                  $_SESSION['LAST_ACTIVITY'] = time();
                  // print_r($_SESSION);
                  $json_arr = array('response'=>true);
            }*/

            echo json_encode(array('response'=>true,"email"=>$email));
          
    }
    public function resendMail($data)
    {
           $mail=new WebMail();
           $mail->sendMail($data['mail']);
           $_SESSION['LAST_ACTIVITY'] = time();

    }
    public function checkImei($data)
    {

        if(isset($_SESSION['active_user']))
        {
            // print_r($_SESSION['active_user']);
            // print_r($_SESSION['userDtls']);
            if(empty($_SESSION['userDtls']))
            {
                //echo "sss";
                    $Http=new Http();

                    $apiendpoint="/devices/search";
                    $post_arr=array('imei'=>$data['decodedText']);
                    $referrer=$data['referrer'];
                    $device_dtl=$Http->Post($apiendpoint,$post_arr);
                    //print_r($device_dtl);
                    $dev_arr=json_decode($device_dtl,true);
                    //print_r($dev_arr);
                    //echo count($dev_arr);
                    $check_response_dev_arr=checkIMEIesponse($dev_arr,$referrer);


                    if(isset($dev_arr) and count($dev_arr)>0 and $dev_arr['object']=='list') // check imei exists or not , if not exists then object returns a value error and if exists then list
                    {
                        if(!empty($dev_arr['items'][0]['sims'])) // check sim associated with the imei or not
                        {
                            //echo "string";
                            $gigs_sim_id=$dev_arr['items'][0]['sims'][0]['id'];
                            $getSubscriptionDtls=$Http->Get('/subscriptions?sim='.$gigs_sim_id);
                            $subscription_array=json_decode($getSubscriptionDtls,true);
                            //print_r($subscription_array);
                             $check_response_subscription_array=checkIMEIesponse($subscription_array,$referrer);
                            // $end_date_gigs=$subscription_array['items'][0]['currentPeriod']['end'];
                            // $end_date=date('Y-m-d', strtotime($end_date_gigs));
                            //if(strtotime($end_date)>=strtotime(date('Y-m-d')) and 1>2)
                            //echo $subscription_array['items'][0]['status'];
                            
                            if(!empty($subscription_array['items'])) // check active plan for sim
                            {   
                                $db=new Database();

                                $check_user_arr=array();
                                $check_user_arr['table']=USERTABLE;
                                $check_user_arr['selector']='email,id';
                                $check_user_arr['condition']="where md5(id)='".$_SESSION['active_user']."'";

                                $checkUserExists=$db->Select($check_user_arr);
                                //print_r($checkUserExists);
                                if($checkUserExists[0]['email']==$subscription_array['items'][0]['user']['email'])
                                {
                                     if($subscription_array['items'][0]['status']=='active')
                                     {
                                        

                                        $_SESSION['phone_details']=1;
                                        $phone=$subscription_array['items'][0]['phoneNumber'];
                                        $encrypted_phone=PHP_AES_Cipher::encrypt(KEY, IV, $phone);
                                        $encrypted_imei=PHP_AES_Cipher::encrypt(KEY, IV, $data['decodedText']);
                                        $encrypted_userid=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists[0]['id']);
                                        
                                        $json_arr=array('response'=>false,'message'=>'Already Activated Dataplan','pn'=>$encrypted_phone,"phone"=>$phone,"referrer"=>$referrer,"imei"=>$encrypted_imei,"uid"=>$encrypted_userid);

                                     }
                                    // need to add code for subscription status ->pending, ended 
                                }
                                else
                                {
                                    $json_arr=array('response'=>false,'message'=>'This Device belong to other User : '.$subscription_array['items'][0]['user']['email']);
                                }
                                   
                                
                            }
                            else
                            {
                                // no active plan
                                $db=new Database();
                                //echo "ddd";
                                
                                
                                    $check_device_user_arr=array();
                                    $check_device_user_arr['table']=DEVICETABLE;
                                    $check_device_user_arr['selector']=' user_id';
                                    $check_device_user_arr['condition']="where imei='".$data['decodedText']."'";

                                    $checkDeviceUserExists=$db->Select($check_device_user_arr);
                                    //print_r($checkDeviceUserExists);

                                    if(count($checkDeviceUserExists)==1)
                                    {
                                        if($_SESSION['active_user']==md5($checkDeviceUserExists[0]['user_id']))
                                        {
                                            //echo "ss";
                                            

                                            $check_imei_arr=array();
                                            $check_imei_arr['table']=DEVICETABLE;
                                            $check_imei_arr['selector']='id,user_id';
                                            //$check_imei_arr['condition']="where imei='".$data['decodedText']."'";
                                            $check_imei_arr['condition']="where md5(user_id)='".$_SESSION['active_user']."' and status=1";
                                            
                                            $checkImeiExists=$db->Select($check_imei_arr);
                                            if(count($checkImeiExists)>0)
                                            {

                                                //echo "sssss";

                                                $db->Update(DEVICETABLE,array('status'=>4),array("where md5(user_id)='".$_SESSION['active_user']."'"," and status=1"));

                                                
                                                
                                            }

                                            $db->Update(DEVICETABLE,array('status'=>1,'referrer'=>$referrer),array("where imei='".$data['decodedText']."'"));

                                            $json_arr=array('response'=>true);

                                           /* if(!empty($subscription_array['items'])) // check active plan for sim
                                            {
                                                if($subscription_array['items'][0]['status']=='active')
                                                {
                                                    
                                                    $_SESSION['phone_details']=1;
                                                    $phone=$subscription_array['items'][0]['phoneNumber'];
                                                    $encrypted_phone=PHP_AES_Cipher::encrypt(KEY, IV, $phone);
                                                    $json_arr=array('response'=>false,'message'=>'Already Activated Dataplan','pn'=>$encrypted_phone,"phone"=>$phone,"referrer"=>$referrer);
                                                }
                                                // need to add code for subscription status ->pending, ended 
                                                
                                            }*/


                                            
                                  
                                        }
                                        else
                                        {
                                             //echo "tt";
                                            $user_dtls_arr=array();
                                            $user_dtls_arr['table']='user_mstr';
                                            $user_dtls_arr['selector']='id,email';
                                            $user_dtls_arr['condition']="where id='".$checkDeviceUserExists[0]['user_id']."'";

                                            $checkDeviceUserExists=$db->Select($user_dtls_arr);
                                            $json_arr=array('response'=>false,'message'=>'This Device belong to other User : '.$checkDeviceUserExists[0]['email']);
                                        }
                                    }
                                    else if(count($checkDeviceUserExists)==0)
                                    {
                                        //echo "else if";
                                        $arr=array();
                                        $arr['table']="user_mstr";
                                        $arr['selector']="id";
                                        $arr['condition']="where md5(id)='".$_SESSION['active_user']."'";

                                        $getUserDtls=$db->Select($arr);
                                       // print_r($getUserDtls);


                                        $check_imei_arr=array();
                                        $check_imei_arr['table']=DEVICETABLE;
                                        $check_imei_arr['selector']='id,user_id';
                                        //$check_imei_arr['condition']="where imei='".$data['decodedText']."'";
                                        $check_imei_arr['condition']="where md5(user_id)='".$_SESSION['active_user']."' and status=1";
                                        
                                        $checkImeiExists=$db->Select($check_imei_arr);
                                        if(count($checkImeiExists)>0)
                                        {
                                            //echo "dd";
                                            $db->Update(DEVICETABLE,array('status'=>4),array("where md5(user_id)='".$_SESSION['active_user']."'"," and status=1"));

                                            
                                            
                                        }
                                        // echo "daaad";
                                        $device_arr=array("imei"=>$data['decodedText'],"referrer"=>$referrer,"user_id"=>$getUserDtls[0]['id']);
                                        $last_id=$db->Insert(DEVICETABLE,$device_arr);
                                        $json_arr=array('response'=>true);

                                        /*if(!empty($subscription_array['items'])) // check active plan for sim
                                        {
                                            if($subscription_array['items'][0]['status']=='active')
                                            {
                                                
                                                $_SESSION['phone_details']=1;
                                                $phone=$subscription_array['items'][0]['phoneNumber'];
                                                $encrypted_phone=PHP_AES_Cipher::encrypt(KEY, IV, $phone);
                                                $json_arr=array('response'=>false,'message'=>'Already Activated Dataplan','pn'=>$encrypted_phone,"phone"=>$phone,"referrer"=>$referrer);
                                            }
                                            // need to add code for subscription status ->pending, ended 
                                            
                                        }
                                        */


                                    }
                                    

                                    


                               // $json_arr=array('response'=>true);
                                
                           }

                        }
                        else
                        {
                            $json_arr=array('response'=>false,'message'=>'No SIM Associated with this device');
                        }
                       //  $db=new Database();
                       //  //echo "ddd";
                      
                       //  $arr=array();
                       //  $arr['table']="user_mstr";
                       //  $arr['selector']="id";
                       //  $arr['condition']="where md5(id)='".$_SESSION['active_user']."'";

                       //  $getUserDtls=$db->Select($arr);
                       // // print_r($getUserDtls);

                       //  $device_arr=array("imei"=>$data['decodedText'],"user_id"=>$getUserDtls[0]['id']);
                       //  $last_id=$db->Insert(DEVICETABLE,$device_arr);
                       //  $response=true;

                    }
                    else
                    {   // device not found
                        $json_arr=array('response'=>false,'message'=>'Device Not Found');

                    }
            }
            else
            {
                $json_arr=array('response'=>false,'message'=>'Something Went Wrong');
            }
        }
        else
        {
            $json_arr=array('response'=>false,'message'=>'Something Went Wrong');
        }
       echo json_encode($json_arr);

    }

    public function loginUser()
    {
        unset($_SESSION['userDtls']);
        unset($_SESSION['otp']);
        unset($_SESSION['LAST_ACTIVITY']);

        echo json_encode(array('response'=>2));

    }
    public function isUserExists($email)
    {
        $db=new Database();
        $check_user_arr=array();
        $check_user_arr['table']='user_mstr';
        $check_user_arr['selector']='id';
        $check_user_arr['condition']="where email='".$email."'";
        
        $checkUserExists=$db->Select($check_user_arr);
        //print_r($checkUserExists);
        if(count($checkUserExists)>0)
        {
            $id=$checkUserExists[0]['id'];
            return $id;
        }
        else
        {
            return false;
        }
    }


    /* ---------------------------- NEW FUNCTIONS -------------------------- */


    public function checkImeiExists($data)
    {
        $imei=$data['imei_no'];
        $db=new Database();
        $check_imei_arr=array();
        $check_imei_arr['table']=DEVICETABLE;
        $check_imei_arr['selector']='id,provider,product,status';
        $check_imei_arr['condition']="where imei='".$imei."' and status!='7'";
        
        $checkImeiExists=$db->Select($check_imei_arr);
        //print_r($checkImeiExists);
        if(count($checkImeiExists)>0)
        {

           // date_default_timezone_set('EST');
           // $date=date('Y-m-d H:i:s');
            //date_default_timezone_set('UTC');

            //if($date<'2023-11-14 00:00:00' and $checkImeiExists[0]['product']=='JT3' and $checkImeiExists[0]['status']!='2')
            if(1>2)
            {
                $json_arr=array("response"=>false,"message"=>"JT3");
            }
            else
            {
                if(strtolower($checkImeiExists[0]['provider'])=='speedtalk' or strtolower($checkImeiExists[0]['provider'])=='telnyx')
                {
                    $_SESSION['did']=md5($checkImeiExists[0]['id']);
                    $json_arr=array("response"=>true);
                }
                else
                {
                    $json_arr=array("response"=>false,"message"=>"gigs");
                }
            
            }
           
        }
        else
        {
           // echo "string";
            //IMEI Not Found
            $json_arr=array("response"=>false,"message"=>'003 | Device Not Found');
        }
      
        echo json_encode($json_arr);
    }

   /* public function createUserNew($data)
    {

        $db=new Database();
        $new_otp=$data['otp1'].$data['otp2'].$data['otp3'].$data['otp4'].$data['otp5'].$data['otp6'];
        if(isset($_SESSION['userDtls']) and isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 300))
        {
            if($_SESSION['otp']==$new_otp)
            {

                if(isset($_SESSION['loginuser']))
                {
                    $this->loginUser();
                    exit();
                }
                else
                {


                            $db=new Database();
                            //echo "ddd";
                            $check_imei_arr=array();
                            $check_imei_arr['table']=DEVICETABLE;
                            $check_imei_arr['selector']='id,user_id,status,sim_no';
                            $check_imei_arr['condition']="where md5(id)='".$_SESSION['did']."' and status!=7";
                            
                            $checkIMEIExists=$db->Select($check_imei_arr);
                            if(count($checkIMEIExists)>0)
                            {
                                if($checkIMEIExists[0]['user_id']==0 or $checkIMEIExists[0]['user_id']=="")
                                {
                                     
                                     $check_user_arr=array();
                                     $check_user_arr['table']='user_mstr';
                                     $check_user_arr['selector']='id';
                                     $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
                                    
                                     $checkUserExists=$db->Select($check_user_arr);
                                     
                                     if(count($checkUserExists)>0)
                                     {
                                        $user_id=$checkUserExists[0]['id'];
                                     }
                                     else
                                     {
                                        $user_arr=array("email"=>$_SESSION['userDtls']['email']);
                                        
                                        $user_id=$db->Insert('user_mstr',$user_arr);
                                     }
                                        

                                    $db->Update(DEVICETABLE,array('status'=>4),array("where user_id='".$user_id."'"," and status=1"));

                                          
                                    $db->Update(DEVICETABLE,array('status'=>1,'user_id'=>$user_id,'referrer'=>$referrer),array("where id='".$checkIMEIExists[0]['id']."'"));

                                     $speedtalkapi=new SpeedtalkApi();
                                     $checkSimforactivation=$speedtalkapi->stSIM($checkIMEIExists[0]['sim_no']);

                                     if($checkSimforactivation['ret']==0)
                                     {
                                        $json_arr=array("response"=>1); // proceed to payment
                                        
                                     }
                                     else
                                     {
                                        $json_arr=array("response"=>4,"message"=>$checkSimforactivation['retmess']); 
                                     }

                                      $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$checkSimforactivation['api'],"reponse"=>$checkSimforactivation['retmess']);
                                        
                                      $db->Insert(APILOG,$api_log_arr);

                                     $json_arr=array("response"=>1);

                                     $_SESSION['active_user']=md5($user_id);
                                }
                                else
                                {
                                     
                                     $check_user_arr=array();
                                     $check_user_arr['table']='user_mstr';
                                     $check_user_arr['selector']='id';
                                     $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
                                    
                                     $checkUserExists=$db->Select($check_user_arr);

                                     if(count($checkUserExists)>0)
                                     {
                                        if($checkIMEIExists[0]['user_id']==$checkUserExists[0]['id'])
                                        {


                                          

                                                $db->Update(DEVICETABLE,array('status'=>4),array("where user_id='".$checkUserExists[0]['id']."'"," and status=1"));

                                                $db->Update(DEVICETABLE,array('status'=>1,'user_id'=>$checkUserExists[0]['id'],'referrer'=>$referrer),array("where id='".$checkIMEIExists[0]['id']."'"));


                                                if($checkIMEIExists[0]['status']==0 or $checkIMEIExists[0]['status']==1 or $checkIMEIExists[0]['status']==4)
                                                {


                                                        $speedtalkapi=new SpeedtalkApi();
                                                        $checkSimforactivation=$speedtalkapi->stSIM($checkIMEIExists[0]['sim_no']);

                                                        if($checkSimforactivation['ret']==0)
                                                        {
                                                            $json_arr=array("response"=>1); // proceed to payment
                                                        }
                                                        else
                                                        {
                                                            $json_arr=array("response"=>4,"message"=>$checkSimforactivation['retmess']); 
                                                        }

                                                    
                                                    
                                                }

                                                else if($checkIMEIExists[0]['status']==3 or $checkIMEIExists[0]['status']==5)
                                                {
                                                    $json_arr=array("response"=>2); // proceed for activation
                                                }
                                                else if($checkIMEIExists[0]['status']==2)
                                                {
                                                    $json_arr=array("response"=>3); // already active
                                                }

                                                 $_SESSION['active_user']=md5($checkUserExists[0]['id']);
                                            
                                            
                                            
                                        }
                                        else
                                        {

                                            $check_user_arr=array();
                                            $check_user_arr['table']=USERTABLE;
                                            $check_user_arr['selector']='email';
                                            $check_user_arr['condition']="where md5(id)='".$checkIMEIExists[0]['user_id']."'";

                                            $checkUserExists=$db->Select($check_user_arr);

                                            $json_arr=array("response"=>4,"message"=>"This Device belongs to: ".$checkUserExists[0]['email']); // another user
                                        }
                                     }
                                }
                            }
                            else
                            {
                                $json_arr=array("response"=>5,"message"=>"IMEI not found");
                            }
                           
                          
                            unset($_SESSION['userDtls']);
                            unset($_SESSION['otp']);
                            unset($_SESSION['LAST_ACTIVITY']);
                            
                           
                            //print_r($json_arr);
                   }
                   
                
               
            }
            else
            {
                $json_arr = array('response'=>false,'message'=>'The Code is incorrect');
            }
            
            
        }
        else
        {
            $json_arr = array('response'=>false,'message'=>'The Code is expired');
            
        }
        
        echo json_encode($json_arr);
    }*/



    public function validateOTP($data)
    {

        $db=new Database();
        $new_otp=$data['otp1'].$data['otp2'].$data['otp3'].$data['otp4'].$data['otp5'].$data['otp6'];
        if(isset($_SESSION['userDtls']) and isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 300))
        {
            if($_SESSION['otp']==$new_otp)
            {

                $email=$_SESSION['userDtls']['email'];
                 $check_user_arr=array();
                 $check_user_arr['table']='user_mstr';
                 $check_user_arr['selector']='id';
                 $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
                
                 $checkUserExists=$db->Select($check_user_arr);
                 
                 if(count($checkUserExists)>0)
                 {
                    $user_id=$checkUserExists[0]['id'];
                 }
                 else
                 {
                    $user_arr=array("email"=>$_SESSION['userDtls']['email']);
                    
                    $user_id=$db->Insert('user_mstr',$user_arr);
                 }

                unset($_SESSION['userDtls']);
                unset($_SESSION['otp']);
                unset($_SESSION['LAST_ACTIVITY']);
                    
                   
                 $_SESSION['active_user']=md5($user_id);

                 $json_arr = array('response'=>true,"email"=>$email);

            }
            else
            {
                $json_arr = array('response'=>false,'message'=>'The Code is incorrect');
            }
            
            
        }
        else
        {
            $json_arr = array('response'=>false,'message'=>'The Code is expired');
            
        }
        
        echo json_encode($json_arr);
    }

    public function createAppUser2($data)
    {

        $imei=$data['imei_no'];
        $db=new Database();
        $check_imei_arr=array();
        $check_imei_arr['table']=DEVICETABLE;
        $check_imei_arr['selector']='id,provider';
        $check_imei_arr['condition']="where imei='".$imei."' and status!='7'";
        
        $checkImeiExists=$db->Select($check_imei_arr);
        //print_r($checkImeiExists);
        if(count($checkImeiExists)>0)
        {
            if(strtolower($checkImeiExists[0]['provider'])=='speedtalk')
            {
                $_SESSION['did']=md5($checkImeiExists[0]['id']);

                 $db=new Database();
                if(isset($_SESSION['userDtls']) and isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 300))
                {
                    

                         $check_user_arr=array();
                         $check_user_arr['table']='user_mstr';
                         $check_user_arr['selector']='id';
                         $check_user_arr['condition']="where email='".$_SESSION['userDtls']['email']."'";
                        
                         $checkUserExists=$db->Select($check_user_arr);
                         
                         if(count($checkUserExists)>0)
                         {
                            $user_id=$checkUserExists[0]['id'];
                         }
                         else
                         {
                            $user_arr=array("email"=>$_SESSION['userDtls']['email']);
                            
                            $user_id=$db->Insert('user_mstr',$user_arr);
                         }

                        unset($_SESSION['userDtls']);
                        unset($_SESSION['otp']);
                        unset($_SESSION['LAST_ACTIVITY']);
                            
                           
                         $_SESSION['active_user']=md5($user_id);

                         $json_arr = array('response'=>true);

                   
                    
                    
                }
                else
                {
                    $json_arr = array('response'=>false,'message'=>'The Code is expired');
                    
                }


                
            }
            else
            {
                $json_arr=array("response"=>false,"message"=>"gigs");
            }
            
        }
        else
        {
           // echo "string";
            $json_arr=array("response"=>false,"message"=>'IMEI Not Found');
        }



       
        
        echo json_encode($json_arr);
    }

    public function checkIMEISpeedtalk($data)
    {


            if($_SESSION['active_user'] and $_SESSION['did'])
            {


                    $referrer=$data['referrer'];
                    $db=new Database();
                    //echo "ddd";
                    $check_imei_arr=array();
                    $check_imei_arr['table']=DEVICETABLE;
                    $check_imei_arr['selector']='id,user_id,status,sim_no,phone_number,imei,address_id,provider,reg_code';
                    $check_imei_arr['condition']="where md5(id)='".$_SESSION['did']."' and status!=7";
                    
                    $checkIMEIExists=$db->Select($check_imei_arr);
                    if(count($checkIMEIExists)>0)
                    {
                        if($checkIMEIExists[0]['user_id']==0 or $checkIMEIExists[0]['user_id']=="")
                        {
                             
                             $check_user_arr=array();
                             $check_user_arr['table']='user_mstr';
                             $check_user_arr['selector']='id,email';
                             $check_user_arr['condition']="where md5(id)='".$_SESSION['active_user']."'";
                             
                             $checkUserExists=$db->Select($check_user_arr);
                             
                             if(count($checkUserExists)>0)
                             {
                                $user_id=$checkUserExists[0]['id'];
                             }
                             
                                

                            $db->Update(DEVICETABLE,array('status'=>'4'),array("where user_id='".$user_id."'"," and status='1'"));

                                  
                            $db->Update(DEVICETABLE,array('status'=>'1','user_id'=>$user_id,'referrer'=>$referrer,'channel'=>$_SESSION['channel']),array("where id='".$checkIMEIExists[0]['id']."'"));

                            if(strtolower($checkIMEIExists[0]['provider'])=='telnyx')
                            {
                                
                                     $telnyxapi=new TelnyxApi();
                                     $telnyx_res=$telnyxapi->getSimCardDtls($checkIMEIExists[0]['sim_no']);
                                 //   print_r($telnyx_res);
                                      $dev_arr=array();
                                      $dev_arr['device_id']=$checkIMEIExists[0]['id'];
                                      $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                      $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                      $dev_arr['email']=$checkUserExists[0]['email'];
                                      $dev_arr['subject']="Telnyx Auth Error";  
                                       checkTelnyxAuthError($dev_arr,$telnyx_res);
                                      checkCurlResponseNew($telnyx_res,$checkIMEIExists[0]['id']);
                                      checkTelnyxResponse($dev_arr,$telnyx_res);

                                       $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$telnyx_res['api'],"response"=>json_encode($telnyx_res),'data'=>$telnyx_res['payload']);
                                    
                                      //print_r($api_log_arr);
                                      $db->Insert(APILOG,$api_log_arr);

                                      if(count($telnyx_res['data'])==0)
                                      {
                                         //$json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment 

                                         $telnyx_res_regcode=$telnyxapi->validateRegCode($checkIMEIExists[0]['reg_code']);
                                        //print_r($telnyx_res_regcode);
                                         $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$telnyx_res_regcode['api'],"response"=>json_encode($telnyx_res_regcode),'data'=>$telnyx_res_regcode['payload']);
                                    
                                        // //print_r($api_log_arr);
                                         $db->Insert(APILOG,$api_log_arr);
                                        if($telnyx_res_regcode['data'][0]['valid']==true)
                                        {

                                         $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment 
                                        }
                                        else
                                        {
                                               $dev_arr=array();
                                                $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                                $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                                $dev_arr['email']=$checkUserExists[0]['email'];
                                                $dev_arr['subject']="Telnyx Error";
                                                $mail=new WebMail();
                                                $mail->sendAlertTelnyx($dev_arr,$telnyx_res_regcode);
                                                $json_arr=array("response"=>4,"message"=>"025 | Activation Error");
                                        }
                                      }
                                      else
                                      {
                                          //already registered sim with telnyx that is not in our db
                                           $json_arr=array("response"=>4,"message"=>"027 | Activation Error","ud"=>$checkUserExists[0]['id']);
                                      }

                                      

                            }
                            else
                            {


                                     $speedtalkapi=new SpeedtalkApi();
                                     $checkSimforactivation=$speedtalkapi->stSIM($checkIMEIExists[0]['sim_no']);
                                     checkCurlResponseNew($checkSimforactivation,$checkIMEIExists[0]['id']);

                                     //$checkSimforactivation['ret']=0;
                                     if($checkSimforactivation['ret']==0)
                                     {
                                        $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment
                                        
                                     }
                                     else
                                     {
                                        //$checkSimforactivation['retmess']
                                       // $json_arr=array("response"=>4,"message"=>"012 | Activation error","ud"=>md5($checkUserExists[0]['id'])); 

                                         $dev_arr=array();
                                        $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                        $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                        $dev_arr['email']=$checkUserExists[0]['email'];
                                        
                                        $arr=alert("shil@cosmotogether.com",$dev_arr,$checkSimforactivation,'stSIM');
                                        //print_r($arr);
                                        $json_arr=array("ud"=>md5($checkUserExists[0]['id'])); 

                                        $json_arr=array_merge($json_arr,$arr);


                                     }

                                        if(!isset($checkSimforactivation['retmess']))
                                        {
                                            if($checkSimforactivation['ret']==99)
                                            {
                                                $checkSimforactivation['retmess']="Error 99";
                                            }
                                            else
                                            {
                                                $checkSimforactivation['retmess']="Error 404";
                                            }
                                        }
                                      $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$checkSimforactivation['api'],"response"=>$checkSimforactivation['retmess']);
                                    
                                      //print_r($api_log_arr);
                                      $db->Insert(APILOG,$api_log_arr);

                            }
                            
                        }
                        else
                        {
                             //echo "string";
                             $check_user_arr=array();
                             $check_user_arr['table']='user_mstr';
                             $check_user_arr['selector']='id,email';
                             $check_user_arr['condition']="where md5(id)='".$_SESSION['active_user']."'";
                            
                             $checkUserExists=$db->Select($check_user_arr);
                             //print_r($checkUserExists);
                             if(count($checkUserExists)>0)
                             {
                                if($checkIMEIExists[0]['user_id']==$checkUserExists[0]['id'])
                                {


                                  

                                        $db->Update(DEVICETABLE,array('status'=>'4'),array("where user_id='".$checkUserExists[0]['id']."'"," and status='1'"));

                                        

                                        if($checkIMEIExists[0]['status']==0 or $checkIMEIExists[0]['status']==1 or $checkIMEIExists[0]['status']==4)
                                        {

                                                $db->Update(DEVICETABLE,array('status'=>'1','user_id'=>$checkUserExists[0]['id'],'referrer'=>$referrer,'channel'=>$_SESSION['channel']),array("where id='".$checkIMEIExists[0]['id']."'"));


                                                // proceed to payment
                                        if(strtolower($checkIMEIExists[0]['provider'])=='telnyx')
                                        {
                                            
                                             $telnyxapi=new TelnyxApi();
                                             $telnyx_res=$telnyxapi->getSimCardDtls($checkIMEIExists[0]['sim_no']);
                                               $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$telnyx_res['api'],"response"=>json_encode($telnyx_res),'data'=>$telnyx_res['payload']);
                                            
                                              //print_r($api_log_arr);
                                              $db->Insert(APILOG,$api_log_arr);
                                            //   print_r($telnyx_res);

                                              $dev_arr=array();
                                              $dev_arr['device_id']=$checkIMEIExists[0]['id'];
                                              $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                              $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                              $dev_arr['email']=$checkUserExists[0]['email'];
                                             $dev_arr['subject']="Telnyx AUth Error";   
                                                checkTelnyxAuthError($dev_arr,$telnyx_res);
                                              checkCurlResponseNew($telnyx_res,$checkIMEIExists[0]['id']);
                                              checkTelnyxResponse($dev_arr,$telnyx_res);
                                              if(count($telnyx_res['data'])==0)
                                              {
                                                // $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment

                                                        $telnyx_res_regcode=$telnyxapi->validateRegCode($checkIMEIExists[0]['reg_code']);
                                                //print_r($telnyx_res_regcode);
                                                 $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$telnyx_res_regcode['api'],"response"=>json_encode($telnyx_res_regcode),'data'=>$telnyx_res_regcode['payload']);
                                            
                                                // //print_r($api_log_arr);
                                                 $db->Insert(APILOG,$api_log_arr);
                                                if($telnyx_res_regcode['data'][0]['valid']==true)
                                                {

                                                 $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment 
                                                }
                                                else
                                                {
                                                       $dev_arr=array();
                                                        $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                                        $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                                        $dev_arr['email']=$checkUserExists[0]['email'];
                                                        $dev_arr['subject']="Telnyx Error";
                                                        $mail=new WebMail();
                                                        $mail->sendAlertTelnyx($dev_arr,$telnyx_res_regcode);
                                                        $json_arr=array("response"=>4,"message"=>"025 | Activation Error");
                                                } 
                                              }
                                              else
                                              {
                                                  //already registered sim with telnyx that is not in our db
                                                   $json_arr=array("response"=>4,"message"=>"Activation Error","ud"=>$checkUserExists[0]['id']);
                                              }

                                             

                                        }
                                        else
                                        {
                                                $speedtalkapi=new SpeedtalkApi();
                                                $checkSimforactivation=$speedtalkapi->stSIM($checkIMEIExists[0]['sim_no']);
                                                //print_r($checkSimforactivation);
                                                checkCurlResponseNew($checkSimforactivation,$checkIMEIExists[0]['id']);
                                                //$checkSimforactivation['ret']=0;
                                                if($checkSimforactivation['ret']==0)
                                                {
                                                    $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); 
                                                }
                                                else
                                                {

                                                   //$checkSimforactivation['retmess']
                                                    //$json_arr=array("response"=>4,"message"=>"012 | Activation error","ud"=>md5($checkUserExists[0]['id'])); 

                                                      $dev_arr=array();
                                                    $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                                    $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                                     $dev_arr['email']=$checkUserExists[0]['email'];
                                                    
                                                   $arr= alert("shil@cosmotogether.com",$dev_arr,$checkSimforactivation,'stSIM');
                                                 

                                                    $json_arr=array("ud"=>md5($checkUserExists[0]['id'])); 

                                                     $json_arr=array_merge($json_arr,$arr);
                                                }

                                                  if(!isset($checkSimforactivation['retmess']))
                                                    {
                                                        if($checkSimforactivation['ret']==99)
                                                        {
                                                            $checkSimforactivation['retmess']="Error 99";
                                                        }
                                                        else
                                                        {
                                                            $checkSimforactivation['retmess']="Error 404";
                                                        }
                                                    }
                                                $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$checkSimforactivation['api'],"response"=>$checkSimforactivation['retmess']);
                            
                                                //print_r($api_log_arr);
                                                $db->Insert(APILOG,$api_log_arr);
                                            }
                                        }

                                        else if($checkIMEIExists[0]['status']==3 or $checkIMEIExists[0]['status']==5)
                                        {

                                            // proceed for activation
                                            //$charge_id=$checkIMEIExists[0]['charge_id']=$charge_id;
                                             // $recharge=new RechargeApi();
                                             // //echo "string";
                                             // $res=$recharge->getChargeIdbyAddrId($checkIMEIExists[0]['address_id']);
                                             // //print_r($res);
                                             // $charge_id=$res['orders'][0]['charge_id'];

                                             // $json_arr=array("response"=>2,"charge_id"=>$charge_id,"ud"=>md5($checkUserExists[0]['id']),"email"=>$checkUserExists[0]['email'],"imei"=>$checkIMEIExists[0]['imei']); 



                                            // proceed for activation
                                            //$charge_id=$checkIMEIExists[0]['charge_id']=$charge_id;
                                             $recharge=new RechargeApi();
                                             //echo "string";
                                             $res=$recharge->getChargeIdbyAddrId($checkIMEIExists[0]['address_id']);
                                             //print_r($res);
                                             $charge_id=$res['orders'][0]['charge_id'];

                                             $_SESSION['phone_details']=1;
                                             $check_actv_pend_arr=array();
                                             $check_actv_pend_arr['table']=ACTIVATION_PENDING;
                                             $check_actv_pend_arr['selector']='id,status';
                                             $check_actv_pend_arr['condition']="where device_id='".$checkIMEIExists[0]['id']."' and status!='5'";

                                             $checkActvPending=$db->Select($check_actv_pend_arr);

                                             $check_pend_arr=array();
                                             $check_pend_arr['table']=PENDING;
                                             $check_pend_arr['selector']='id,status';
                                             $check_pend_arr['condition']="where device_id=".$checkIMEIExists[0]['id'];

                                            $check_pend=$db->Select($check_pend_arr);
                                             if(count($checkActvPending)>0 or count($check_pend)>0)
                                             {
                                                if((isset($checkActvPending[0]['status']) and $checkActvPending[0]['status']==0) or (isset($check_pend[0]['status']) and $check_pend[0]['status']==0))
                                                {

                                                     $speedtalkapi=new SpeedtalkApi();
                                                    $response=$speedtalkapi->stSim($checkIMEIExists[0]['sim_no']);
                                                    //  print_r($response);
                                                        

                                                        if (strpos($response['retmess'], 'was used, phone#')) { 
                                                            $explode_phone=explode("#",$response['retmess']);
                                                            //print_r($explode_phone);
                                                            $phone=rtrim($explode_phone[1],'.');
                                                            $phone =trim($phone," ");

                                                            $activation_date=date('Y-m-d H:i:s');

                                                            $db->update(PENDING,array('status'=>4),array("where id='".$check_pend[0]['id']."'"));
                                                            $db->update(DEVICETABLE,array('status'=>2,'phone_number'=>$phone,'transaction_id'=>'automation','plan_id'=>'automation','activation_date'=>$activation_date),array("where id='".$checkIMEIExists[0]['id']."'"));
                                                            
                                                             $encrypted_phone=PHP_AES_Cipher::encrypt(KEY, IV, $phone);
                                                             $encrypted_imei=PHP_AES_Cipher::encrypt(KEY, IV, $checkIMEIExists[0]['imei']);
                                                             $encrypted_userid=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists[0]['id']);
                                                             $encrypted_email=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists[0]['email']);


                                                            $json_arr=array("response"=>3,"phone_no"=>$encrypted_phone,"imei"=>$encrypted_imei,"uid"=>$encrypted_userid,"imei"=>$checkIMEIExists[0]['imei'],'email'=>$encrypted_email); 
                                                            
                                                        }
                                                        else
                                                        {
                                                             $encrypted_imei=PHP_AES_Cipher::encrypt(KEY, IV, $checkIMEIExists[0]['imei']);
                                                             $encrypted_email=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists[0]['email']);

                                                             $json_arr=array("response"=>6,"email"=>$encrypted_email,"imei"=>$encrypted_imei); 
                                                        }

                                                    
                                                }
                                                else
                                                {
                                                     $encrypted_imei=PHP_AES_Cipher::encrypt(KEY, IV, $checkIMEIExists[0]['imei']);
                                                     $encrypted_email=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists[0]['email']);

                                                     $json_arr=array("response"=>6,"email"=>$encrypted_email,"imei"=>$encrypted_imei); 
                                                }
                                             }
                                             else
                                             {
                                                $json_arr=array("response"=>2,"charge_id"=>$charge_id,"ud"=>md5($checkUserExists[0]['id']),"email"=>$checkUserExists[0]['email'],"imei"=>$checkIMEIExists[0]['imei']); 

                                             }
                                             

                                        }
                                        else if($checkIMEIExists[0]['status']==2)
                                        {
                                            // already active
                                             $_SESSION['phone_details']=1;
                                             $check_user_arr=array();
                                             $check_user_arr['table']=USERTABLE;
                                             $check_user_arr['selector']='id,email';
                                             $check_user_arr['condition']="where (id)='".$checkIMEIExists[0]['user_id']."'";

                                             $checkUserExists2=$db->Select($check_user_arr);
                                            

                                             $encrypted_phone=PHP_AES_Cipher::encrypt(KEY, IV, $checkIMEIExists[0]['phone_number']);
                                             $encrypted_imei=PHP_AES_Cipher::encrypt(KEY, IV, $checkIMEIExists[0]['imei']);
                                             $encrypted_userid=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists[0]['id']);
                                             $encrypted_email=PHP_AES_Cipher::encrypt(KEY, IV, $checkUserExists2[0]['email']);

                                            $json_arr=array("response"=>3,"phone_no"=>$encrypted_phone,"imei"=>$encrypted_imei,"uid"=>$encrypted_userid,"imei"=>$checkIMEIExists[0]['imei'],'email'=>$encrypted_email); 
                                        }
                                        else if($checkIMEIExists[0]['status']==6)
                                        {
                                            

                                           // $json_arr=array("response"=>4,"message"=>"018 | Something went wrong"); 
                                             $json_arr=array("response"=>7,"message"=>"018 | Activation error"); 
                                        }
                                        
                                         //$_SESSION['active_user']=md5($checkUserExists[0]['id']);
                                    
                                    
                                    
                                }
                                else
                                {


                                        if($checkIMEIExists[0]['status']==0 or $checkIMEIExists[0]['status']==1 or $checkIMEIExists[0]['status']==4)
                                        {


                                              


                                                // proceed to payment
                                                if(strtolower($checkIMEIExists[0]['provider'])=='telnyx')
                                                {
                                                   
                                                     $telnyxapi=new TelnyxApi();
                                                     $telnyx_res=$telnyxapi->getSimCardDtls($checkIMEIExists[0]['sim_no']);
                                                     //print_r($telnyx_res);

                                                        $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$telnyx_res['api'],"response"=>json_encode($telnyx_res),'data'=>$telnyx_res['payload']);
                                                    
                                                      //print_r($api_log_arr);
                                                      $db->Insert(APILOG,$api_log_arr);
                                                      $dev_arr=array();
                                                      $dev_arr['device_id']=$checkIMEIExists[0]['id'];
                                                      $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                                      $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                                      $dev_arr['email']=$checkUserExists[0]['email'];
                                                      $dev_arr['subject']="Telnyx Auth Error";
                                                        
                                                      checkTelnyxAuthError($dev_arr,$telnyx_res);
                                                      checkCurlResponseNew($telnyx_res,$checkIMEIExists[0]['id']);
                                                      checkTelnyxResponse($dev_arr,$telnyx_res);

                                                      if(count($telnyx_res['data'])==0)
                                                      {
                                                        
                                                      $db->Update(DEVICETABLE,array('status'=>'4'),array("where user_id='".$checkUserExists[0]['id']."'"," and status='1'"));

                                                      $db->Update(DEVICETABLE,array('status'=>'1','user_id'=>$checkUserExists[0]['id'],'referrer'=>$referrer,'channel'=>$_SESSION['channel']),array("where id='".$checkIMEIExists[0]['id']."'"));
                                                        // $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment 

                                                      $telnyx_res_regcode=$telnyxapi->validateRegCode($checkIMEIExists[0]['reg_code']);
                                                        //print_r($telnyx_res_regcode);
                                                         $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$telnyx_res_regcode['api'],"response"=>json_encode($telnyx_res_regcode),'data'=>$telnyx_res_regcode['payload']);
                                                    
                                                        // //print_r($api_log_arr);
                                                         $db->Insert(APILOG,$api_log_arr);
                                                        if($telnyx_res_regcode['data'][0]['valid']==true)
                                                        {

                                                         $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); // proceed to payment 
                                                        }
                                                        else
                                                        {
                                                               $dev_arr=array();
                                                                $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                                                $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                                                $dev_arr['email']=$checkUserExists[0]['email'];
                                                                $dev_arr['subject']="Telnyx Error";
                                                                $mail=new WebMail();
                                                                $mail->sendAlertTelnyx($dev_arr,$telnyx_res_regcode);
                                                                $json_arr=array("response"=>4,"message"=>"025 | Activation Error");
                                                        }
                                                      }
                                                      else
                                                      {
                                                          //already registered sim with telnyx that is not in our db
                                                           $json_arr=array("response"=>4,"message"=>"Activation Error","ud"=>$checkUserExists[0]['id']);
                                                      }

                                                    

                                                }
                                                else
                                                {


                                                            $speedtalkapi=new SpeedtalkApi();
                                                            $checkSimforactivation=$speedtalkapi->stSIM($checkIMEIExists[0]['sim_no']);
                                                            //print_r($checkSimforactivation);
                                                            checkCurlResponseNew($checkSimforactivation,$checkIMEIExists[0]['id']);
                                                            //$checkSimforactivation['ret']=0;
                                                            if($checkSimforactivation['ret']==0)
                                                            {

                                                                  $db->Update(DEVICETABLE,array('status'=>'4'),array("where user_id='".$checkUserExists[0]['id']."'"," and status='1'"));

                                                                  $db->Update(DEVICETABLE,array('status'=>'1','user_id'=>$checkUserExists[0]['id'],'referrer'=>$referrer,'channel'=>$_SESSION['channel']),array("where id='".$checkIMEIExists[0]['id']."'"));
                                                                $json_arr=array("response"=>1,"imei"=>$checkIMEIExists[0]['imei']); 
                                                            }
                                                            else
                                                            {


                                                                  $check_user_arr=array();
                                                                 $check_user_arr['table']=USERTABLE;
                                                                 $check_user_arr['selector']='id,email';
                                                                 $check_user_arr['condition']="where (id)='".$checkIMEIExists[0]['user_id']."'";

                                                                 $checkUserExists2=$db->Select($check_user_arr);
                                                                 
                                                               //$checkSimforactivation['retmess']
                                                                $dev_arr=array();
                                                                $dev_arr['imei']=$checkIMEIExists[0]['imei'];
                                                                $dev_arr['iccid']=$checkIMEIExists[0]['sim_no'];
                                                                 $dev_arr['email']=$checkUserExists2[0]['email'];
                                                                
                                                               $arr= alert("shil@cosmotogether.com",$dev_arr,$checkSimforactivation,'stSIM');
                                                               // $json_arr=array("response"=>4,"message"=>"012 | Activation error","ud"=>md5($checkUserExists[0]['id'])); 

                                                                $json_arr=array("ud"=>md5($checkUserExists[0]['id'])); 

                                                                 $json_arr=array_merge($json_arr,$arr);
                                                            }

                                                              if(!isset($checkSimforactivation['retmess']))
                                                                {
                                                                    if($checkSimforactivation['ret']==99)
                                                                    {
                                                                        $checkSimforactivation['retmess']="Error 99";
                                                                    }
                                                                    else
                                                                    {
                                                                        $checkSimforactivation['retmess']="Error 404";
                                                                    }
                                                                }
                                                            $api_log_arr=array("device_id"=>$checkIMEIExists[0]['id'],"api"=>$checkSimforactivation['api'],"response"=>$checkSimforactivation['retmess']);
                                        
                                                            //print_r($api_log_arr);
                                                            $db->Insert(APILOG,$api_log_arr);

                                                }
                                            
                                        }
                                        else
                                        {

                                                $check_user_arr=array();
                                                $check_user_arr['table']=USERTABLE;
                                                $check_user_arr['selector']='id,email';
                                                $check_user_arr['condition']="where (id)='".$checkIMEIExists[0]['user_id']."'";

                                                $checkUserExists2=$db->Select($check_user_arr);
                                                
                                                 $em   = explode("@",$checkUserExists2[0]['email']);
                                                 $name = implode('@', array_slice($em, 0, count($em)-1));
                                                 $len  = floor(strlen($name)/2);

                                                  $hidden_mail= substr($name,0, 2) . str_repeat('*', $len) . "@" . end($em);   
                                                //This Device belongs to: ".$checkUserExists2[0]['email']

                                                $json_arr=array("response"=>4,"message"=>"011 | Device belongs to another customer $hidden_mail","ud"=>md5($checkUserExists[0]['id'])); // another user

                                        }
                                }
                             }
                        }
                    }
                    else
                    {

                        

                        $json_arr=array("response"=>4,"message"=>"003 | IMEI not found","ud"=>$checkUserExists[0]['id']);
                    }
                   
                  
                   
                    //print_r($json_arr);
                           
                    
               
            }
            else
            {
                $json_arr=array("response"=>4,"message"=>"Something Went Wrong","ud"=>$checkUserExists[0]['id']);
            }      

             echo json_encode($json_arr);  

    }


}


$test = new App();
//print_r($_POST['functionName']);
//echo "<pre>";
//print_r($test->test());
//$test->sendMails();
if(isset($_POST['functionName']))
{
    //echo "dd";
    $function_name=$_POST['functionName'];
    $test->$function_name($_POST);
   // echo json_encode(array('success'=>'OTP SENT'));
}