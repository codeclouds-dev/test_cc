<?php

@session_start();

@ob_start();


error_reporting(E_ALL);

ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'SpeedtalkApi.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'RechargeApi.php';

use Application\Database;
use Application\SpeedtalkApi;
use Application\RechargeApi;

$db=new Database();
$SpeedtalkApi=new SpeedtalkApi();
$RechargeApi=new RechargeApi();



?>

<!DOCTYPE html>

<html lang="en">

<head>

  <title>Not Activated Report</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">







  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>









  <style>

    .custom-table tr:hover {background-color: #ddd;}

    table.table.table-responsive.custom-table.table-striped {

      margin-top: 5rem;

    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {

        padding: 15px 8px;

    }

    table.table.table-responsive.custom-table.table-striped thead {

        background: #ddd;

    }

    form.cust-form .col-md-4.pl-0 {

        padding-left: 0;

    }

    form.cust-form {

        margin-top: 2rem;

    }

    .ext-mrg {

        margin-top: 2rem;

    }

    button#export {

        color: #fff;

        padding: 0.6rem 1.875rem;

        font-size: 1.4rem;

        background: #004FEB;

        border: transparent;

        border-radius: 4px;

        font-weight: 700;

    }

    input#submit {

        color: #000;

        padding: 0.6rem 1.875rem;

        font-size: 1.4rem;

        background: #ddd;

        border: transparent;

        border-radius: 4px;

        font-weight: 700;

    }

    .col-md-12.scroll-page {

        overflow-x: scroll;

    }
    .container{position: relative;}
    .container.fullscreen{height: 100vh!important}
    #loader{height: 100%}
   /* #loader i{    color: #004feb;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;}*/
     #loader i{    color: #004feb;
    position: absolute;
    left: 45%;
    top: 44%;
    z-index: 9999;}

    @media (max-width: 670px){

       form.cust-form .col-md-4 {

        margin-bottom: 2rem;

      }

          form.cust-form .col-md-4 {

          margin-bottom: 2rem;

          text-align: center;

      }

      .col-md-4.col-12.text-right.ext-mrg {

          text-align: center;

      }

    }

    

  </style>

</head>

<body>

  <div class="container">

 <p id="loader" style="display: none;"><i class="fa-8x fa-solid fa-spinner fa-spin" style="color: #004feb;"></i></p>



<?php 





    $query="select fullName,email,phoneNumber,device_details_new.imei,sim_no,phone_number,address_id from device_details_new join (select DISTINCT(device_id) from api_log where date(date_time)>='2022-12-20') as api on api.device_id=device_details_new.id join user_mstr on user_mstr.id=device_details_new.user_id where device_details_new.STATUS='5'";



   //echo  $query;





$arr=array();

$arr['query']=$query;

  $result=$db->SelectRaw($arr);



  //print_r($result);



?>

 <div class="row">

   <div class="col-md-12 scroll-page">

      <table class="table table-responsive custom-table table-striped">

    <thead>

      <tr>

        <th>S.No.</th>

       
        <th>Full Name</th>
        <th>Email</th>

        <th>Phone Number</th>

        <th>IMEI</th>

        <th>SIM No.</th>
        <th>Watch Phone Number</th>
        <th>Order Number</th>
        <th>Status</th>






      </tr>

    </thead>

    <tbody>

      <?php 

        $i=1;

        foreach($result as $val)

        {
          $phone='';
           $activated='Not Activated';
          $sim=$val['sim_no'];
          $response=$SpeedtalkApi->stSIM($sim);
         // print_r($res);
//echo $val['address_id'];
         $res2= $RechargeApi->getChargeIdbyAddrId($val['address_id']);
       //  print_r($res2);
        $order=$res2['orders'][0]['shopify_order_number'];


      if (strpos($response['retmess'], 'was used, phone#')) { 

          $activated='Activated';
          $explode_phone=explode("#",$response['retmess']);
          //print_r($explode_phone);
          $phone=rtrim($explode_phone[1],'.');
          $phone =trim($phone," ");

        }
      ?>

      <tr>

        <td><?=$i;?></td>

        
        <td><?=$val['fullName'];?></td>

        <td><?=$val['email'];?></td>

        <td><?=$val['phoneNumber'];?></td>

        <td><?=$val['imei'];?></td>

        <td><?=$val['sim_no'];?></td>
        <td><?=$phone;?></td>
        <td><?=$order?></td>
        <td nowrap="nowrap"><?php echo $activated; ?></td> 
     
      


        

      </tr>

      <?php 

        $i++;

        }

      ?>

    </tbody>

  </table>

   </div>

 </div>

  

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>




</body>

</html>



