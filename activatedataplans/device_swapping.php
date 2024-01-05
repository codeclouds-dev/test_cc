<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
unset($_SESSION);

@session_start();

@ob_start();



//print_r($_SESSION);

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'TelnyxApi.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'RechargeApi.php';


use Application\RechargeApi;
use Application\TelnyxApi;

use Application\Database;

$recharge_api=new RechargeApi();
$db=new Database();
$telnyxapi=new TelnyxApi();

if(isset($_POST['submit']))
{
 // print_r($_POST);
    $device1imei=$_POST['device1imei'];
    $device1iccid=$_POST['device1iccid'];
    $device2imei=$_POST['device2imei'];
    $swap_type=$_POST['swap_type'];

$getswapping=array();
$getswapping['table']='device_swapping';
$getswapping['selector']="id";
$getswapping['condition']="where imei1='".$device1imei."' and iccid1='".$device1iccid."' and imei2='".$device2imei."'";
$getswappingdtls=$db->Select($getswapping);
//print_r($getswappingdtls);

$getswapping2=array();
$getswapping2['table']='device_swapping';
$getswapping2['selector']="*";
$getswapping2['condition']="where imei1='".$device1imei."'";
$getswappingdtls2=$db->Select($getswapping2);


if(count($getswappingdtls)==0 )
{
 $data_keep=1;
if(count($getswappingdtls2)==0)

{
   
    $query="select * from device_details_new where imei=".$device1imei;
    $arr=array();
    $arr['query']=$query;
    $getdevdtls=$db->SelectRaw($arr);
  // print_r($getdevdtls);

    if(count($getdevdtls)>0)
    {
            $order_dtl=$recharge_api->listSubscription($getdevdtls[0]['address_id']);

            if(str_replace('F', '', $getdevdtls[0]['sim_no'])!=$device1iccid)
            {
                 $message="Device 1 Pairing does not exist!";
            }
            else if($swap_type!=strtolower($getdevdtls[0]['provider']))
            {
                 $message="Device 1 Provider does not match with the Dropdown Selected";

            }
            else if($getdevdtls[0]['user_id']=='' or $getdevdtls[0]['user_id']==0)
            {
                 $message="Device 1 has no User associated with it";

            }
            else if($getdevdtls[0]['address_id']=='' or $getdevdtls[0]['address_id']==0)
            {
                 $message="Device 1 has no Order associated with it";

            }
            else if($getdevdtls[0]['status']=='7')
            {
                 $message="Device 1 already swapped";

            }
            else if($order_dtl['subscriptions'][0]['status']!='ACTIVE')
            {
                 $message="Device 1 Recharge Order is cancelled";

            }
            
            else
            {
                $query1="select * from device_details_new where imei='".$device2imei."'";
                $arr1=array();
                $arr1['query']=$query1;
                $getdevdtls1=$db->SelectRaw($arr1);
                if(count($getdevdtls1)>0)
                {
                     if($getdevdtls1[0]['status']==2 or $getdevdtls1[0]['status']==5)
                     {
                        $message="Device 2 already assigned with other order";
                     }
                     else if(strtolower($getdevdtls1[0]['provider'])!='telnyx')
                     {
                       $message="Device 2 IMEI is not mapped with Telnyx IMEI at CC end";
                     }
                     else
                     {
                         $telnyx_res=$telnyxapi->getSimCardDtls($getdevdtls1[0]['sim_no']);
                         if(count($telnyx_res['data'])==0)
                         {
                            $telnyx_res_regcode=$telnyxapi->validateRegCode($getdevdtls1[0]['reg_code']);
                             if($telnyx_res_regcode['data'][0]['valid']==true)
                             {

                                    $getswapping=array();
                                    $getswapping['table']='device_swapping';
                                    $getswapping['selector']="id";
                                    $getswapping['condition']="where imei1='".$device1imei."' and iccid1='".$device1iccid."' and imei2='".$device2imei."'";
                                    $getswappingdtls=$db->Select($getswapping);
                                    if(count($getswappingdtls)==0)
                                    {

                                          $checkdevice1=array();
                                          $checkdevice1['table']='device_details_new';
                                          $checkdevice1['selector']="id";
                                          $checkdevice1['condition']="where imei='".$device1imei."' and sim_no=".$device1iccid;
                                          $checkdevice1exists=$db->Select($checkdevice1);
                                          if(count($checkdevice1exists)>0)
                                          {

                                                
                                                  $checkdevice2=array();
                                                  $checkdevice2['table']='device_details_new';
                                                  $checkdevice2['selector']="id";
                                                  $checkdevice2['condition']="where imei='".$device2imei."'";
                                                  $checkdevice2exists=$db->Select($checkdevice2);

                                                  $device_swap=array("old_device_id"=>$checkdevice1exists[0]['id'],"new_device_id"=>$checkdevice2exists[0]['id'],"imei1"=>$device1imei,"iccid1"=>$device1iccid,"imei2"=>$device2imei,"type"=>"Device Swap","created_date"=>date("Y-m-d H:i:s"));
                                                    //print_r($device_swap);
                                                    $db->Insert('device_swapping',$device_swap);
                                                    
                                                
                                                   if(count($checkdevice2exists)>0)
                                                   {
                                                      $canceldevice=array();
                                                      $canceldevice['table']='recharge_cancellation';
                                                      $canceldevice['selector']="id";
                                                      $canceldevice['condition']="where device_id='".$device1imei."'";
                                                      $checkcanceldevice=$db->Select($canceldevice);
                                                       if(count($checkcanceldevice)==0)
                                                       {

                                                            $device_swap=array("device_id"=>$checkdevice1exists[0]['id'],"created_date"=>date("Y-m-d H:i:s"));
                                                            //print_r($device_swap);
                                                            $lastid=$db->Insert('recharge_cancellation',$device_swap);

                                                            if($lastid)
                                                            {
                                                                $message="Your request has been received, you are in queue!";
                                                                    $data_keep=0;

                                                            }
                                                       }

                                                   }
                                                 
                                          }
                                          else
                                          {
                                             $message="Device 1 Pairing does not exist!";

                                          }

                                    }
                                    else
                                    {
                                        $message="Request already taken!";

                                    }

                             }
                             else
                             {
                                 $message="Device 2 Reg Code not valid";

                             }
                         }
                         else
                         {
                            $message="Device 2 ICCID already activated";
                         }

                     }
                }
                else
                {
                    $message="Device 2 does not exist";

                }
            }
                
    }
    else
    {  
        $message="Device 1 does not exist";
    }
       
   }
   else
   {
           $message="Device 1 swapping request already exist with other Device!";
 
   }   

 }
  


else
{
   
    $message="Request already taken!";
}


}
?>



<!DOCTYPE html>

<html lang="en">

<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="icon" href="asset/images/favicon.png" type="image/png">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
    main {
    background: #f5f5f5;
    padding: 120px 0;
    min-height: 100vh;
    width: 100%;
    }
    .imeiform {
    border: 1px solid #e6e6e6;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 2px rgb(0 0 0 / 20%);
    padding: 60px 30px;
    }
    .imeiform .form-control, .imeiform .form-select { padding: 15px 12px;}
    .btn-submit{padding: 15px 12px;font-size: 22px}
    .imeiform label{
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 10px;
    color: #48484b;
    text-transform: capitalize;
   }
    @media only screen and (max-width: 767px) {
     main{padding: 70px 0}
     .imeiform{padding: 40px 20px;}
    }
   </style>
</head>

<body>

    <!-- Main Starts Here -->

    <main>

    

       <div class="imeiformsec">
       <p <?php if(isset($data_keep) and $data_keep==0){?>style="text-align:center; font-size: 20px; color: green;" <?php }else {?> style="text-align:center; font-size: 20px; color: red;"  <?php } ?>><?php if(isset($message)){ echo $message;} ?></p>
           <div class="container">
               <div class="row justify-content-center align-items-center">
                   <div class="col-md-7">
                       <div class="imeiform">
                       <form method="post">
                          <div class="mb-3">
                            <label for="device1imei" class="form-label">Select dropdown:</label>
                            <select id="swap_type" name="swap_type" class="form-select" required>
                              <option value="speedtalk" <?php if(isset($data_keep) and $data_keep==1 and $_POST['swap_type']=='speedtalk'){ echo "selected"; } ?>>Device: SpeedTalk to Telnyx</option>
                              <option value="telnyx" <?php if(isset($data_keep) and $data_keep==1 and $_POST['swap_type']=='telnyx'){ echo "selected"; } ?>>Device: Telnyx to Telnyx</option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="device1imei" class="form-label">Device 1 IMEI:</label>
                            <input type="text" class="form-control" id="device1imei" name="device1imei" onkeypress="return isNumber(event)" maxlength="15" minlength="15" required value="<?php if(isset($data_keep) and $data_keep==1){echo $_POST['device1imei']; } ?>">
                          </div>
                        
                          <div class="mb-3">
                            <label for="device1iccic" class="form-label">Device 1 ICCID:</label>
                            <input type="text" class="form-control" id="device1iccid" name="device1iccid" onkeypress="return isNumber(event)"  required value="<?php if(isset($data_keep) and $data_keep==1){echo $_POST['device1iccid']; } ?>">
                          </div>
                          <div class="mb-3">
                            <label for="device2imei" class="form-label">Device 2 IMEI:</label>
                            <input type="text" class="form-control" id="device2imei" name="device2imei" onkeypress="return isNumber(event)" maxlength="15" minlength="15" required value="<?php if(isset($data_keep) and $data_keep==1){echo $_POST['device2imei']; } ?>">
                          </div>
                          <div class="mb-0">
                               <button type="submit" class="btn btn-primary w-100 btn-submit" name="submit">Submit</button>
                          </div>
                        </form>
                   </div>
                   </div>
               </div>
           </div>
       </div>     


            

    </main>

    <!-- Main Ends Here -->



    <!-- Scripts -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



<script type="text/javascript">

    function isNumber(evt) {

    evt = (evt) ? evt : window.event;

    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {

        return false;

    }

    return true;

}

</script>
        



<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>








</body>

</html>