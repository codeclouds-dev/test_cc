<?php

@session_start();

@ob_start();



//echo date('Y-m-d H:i:s');

//print_r($_SESSION);

error_reporting(E_ALL);

ini_set('display_errors', '1');

// echo date_default_timezone_get();

//echo $_SESSION['timezonePhp'];



 



 



function display_dateTime($timezone,$date1,$date2){

    $date = new DateTime("now", new DateTimeZone($timezone));

    $timezone = explode('/',$timezone);

    //echo $timezone[1].": ".$date->format('d-m-Y, H:i:s')."<br>";



    return array("timezone"=>$timezone[1],"date1"=>$date->format($date1),"date2"=>$date->format($date2));

}

// $date1=date('d-m-Y').", 00:00:01";

// $date2=date('d-m-Y').", 23:59:59";



// $a=display_dateTime('Asia/Kolkata',$date1,$date2);

// print_r($a);



function converttoEST($date1)

{

  $TimeStr=$date1;

  //$TimeZoneNameFrom='Asia/Kolkata';

 // $TimeZoneNameFrom=$_SESSION['timezonePhp'];

  $TimeZoneNameFrom=isset($_SESSION['timezonePhp'])?$_SESSION['timezonePhp']:'America/Toronto';



  $TimeZoneNameTo="America/Toronto";

  return date_create($TimeStr, new DateTimeZone($TimeZoneNameFrom))

    ->setTimezone(new DateTimeZone($TimeZoneNameTo))->format("Y-m-d H:i:s");





}

function converttolocal($date1)

{

  $TimeStr=$date1;

  $TimeZoneNameFrom='America/Toronto';

  //$TimeZoneNameTo="Asia/Kolkata";

 // $TimeZoneNameTo=$_SESSION['timezonePhp'];

    $TimeZoneNameTo=isset($_SESSION['timezonePhp'])?$_SESSION['timezonePhp']:'America/Toronto';





  return date_create($TimeStr, new DateTimeZone($TimeZoneNameFrom))

    ->setTimezone(new DateTimeZone($TimeZoneNameTo))->format("Y-m-d H:i:s");





}



function convertutctolocal($date1)

{

  $TimeStr=$date1;

  $TimeZoneNameFrom='UTC';

  //$TimeZoneNameTo="Asia/Kolkata";

  //$TimeZoneNameTo=$_SESSION['timezonePhp'];

      $TimeZoneNameTo=isset($_SESSION['timezonePhp'])?$_SESSION['timezonePhp']:'America/Toronto';



  return date_create($TimeStr, new DateTimeZone($TimeZoneNameFrom))

    ->setTimezone(new DateTimeZone($TimeZoneNameTo))->format("Y-m-d H:i:s");





}



// echo converttoEST($date1);

// echo converttoEST($date2);



//   $TimeStr=$a['date2'];

// $TimeZoneNameFrom='Asia/Kolkata';

// $TimeZoneNameTo="America/Toronto";

// echo "new 2". date_create($TimeStr, new DateTimeZone($TimeZoneNameFrom))

//   ->setTimezone(new DateTimeZone($TimeZoneNameTo))->format("Y-m-d H:i:s");





//display_dateTime('America/Toronto');





require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';





use Application\Database;



$db=new Database();







?>

<!DOCTYPE html>

<html lang="en">

<head>

  <title>Activation Pending Report</title>

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
<div class="row">
  <form action="deviceinfo.php" id="form1" method="post">
    <input type="hidden" name="from_date" id="form1_date_from"  value="<?=isset($_POST['from_date'])?$_POST['from_date']:date('Y-m-d');?>"  >
    <input type="hidden" name="to_date"  id="form1_date_to"  value="<?=isset($_POST['to_date'])?$_POST['to_date']:date('Y-m-d');?>">

    <div class="col-md-8 col-12">
      Report : <select id="report">Select<option value="0">select</option><option value="1">Device Activation</option></select>
    </div>
    <input type="submit" name="submit" id="form1_sub" style="display:none;">
  </form>
</div>
 <p id="loader" style="display: none;"><i class="fa-8x fa-solid fa-spinner fa-spin" style="color: #004feb;"></i></p>

<?php 

  if(!empty($_SESSION['timezonePhp']))

  { 

?>



  <?php 

    ?>

  <div class="row">

    <div class="col-md-8 col-12">

      <form method="post" class="cust-form">

      <div class="col-md-3 col-12 pl-0">From Date: <input type="date" name="from_date" id="from_date" value="<?=isset($_POST['from_date'])?$_POST['from_date']:date('Y-m-d')?>" onchange="changedate()"></div>

      <div class="col-md-3 col-12">To Date: <input type="date" name="to_date" id="to_date" value="<?=isset($_POST['to_date'])?$_POST['to_date']:date('Y-m-d')?>" onchange="changedate()"></div>



     <!--  <div class="col-md-3 col-12">Status: 

        <select name="status" id="status" >

            <option value="2" <?php if(isset($_POST['status']) and $_POST['status']==2){ echo "selected"; } ?>>Active</option>

            <option value="6" <?php if(isset($_POST['status']) and $_POST['status']==6){ echo "selected"; } ?>>Cancelled</option>

            

        </select>

      </div>

 -->



      <div class="col-md-3 col-12"><input type="submit" name="submit" id="submit" value="Search"></div>

      </form>



      <!--    <form method="post">

     



      <div class="col-md-4"><input type="submit" name="export" id="export" value="Export"></div>

      </form>

 -->

      

    </div>

  <!--   <div class="col-md-4 col-12 text-right ext-mrg">

       <button type="button" id="export">export CSV</button>

    </div> -->

  </div>

<?php 





  if(isset($_POST['submit']))

  {

      // $date_from= UTCtoLocal($_POST['from_date']. ' 00:00:01' );

      // $date_to= UTCtoLocal($_POST['to_date']. ' 23:59:59' );

      

      $date_from=converttoEST($_POST['from_date']. ', 00:00:01');

      $date_to=converttoEST($_POST['to_date']. ', 23:59:59');



      $_SESSION['date_from']=$date_from;

      $_SESSION['date_to']=$date_to;

      

     

      $where_status=" and timestamp(created_date) between '$date_from' and '$date_to'";

     

      $_SESSION['where_status']=$where_status;

      $where=$where_status;

      

  }

  else if(isset($_SESSION['date_from']) and $_SESSION['date_to'])

  {

      //echo "string";

      // $date_from = UTCtoLocal($_SESSION['date_from']);

      // $date_to= UTCtoLocal($_SESSION['date_to']);

      $date_from = $_SESSION['date_from'];

      $date_to= $_SESSION['date_to'];

     

            $where=" and timestamp(created_date) between ".$_SESSION['date_from']." and ".$_SESSION['date_to'];


      //$where=$_SESSION['where_status'];



  }

  else

  {

        $date_from= converttoEST(date('Y-m-d'). ', 00:00:01' );

        $date_to= converttoEST(date('Y-m-d'). ', 23:59:59' );



      $where=" and timestamp(created_date) between '$date_from' and '$date_to'";

  }



   // $query="select fullName,phoneNumber,email,imei,sim_no,phone_number,activation_date,updated_date  from device_details_new join user_mstr on device_details_new.user_id=user_mstr.id where 1".$where." order by activation_date desc";



    $query="select fullName,phoneNumber,email,imei,sim_no,activation_pending.status,created_date,activation_date  from activation_pending join device_details_new on device_details_new.id=activation_pending.device_id join user_mstr on user_mstr.id=device_details_new.user_id where 1 and activation_pending.status!='5' ".$where." order by activation_date asc";



   //echo  $query;





$arr=array();

$arr['query']=$query;

  $result=$db->SelectRaw($arr);



  //print_r($result);



// if(isset($_POST['export']))

//  {





//     header('Content-Type: application/xls');

//     header('Content-Disposition: attachment; filename=Daily Activation.xls');



//  }

 

?>

 <div class="row">

   <div class="col-md-12 scroll-page">

      <table class="table table-responsive custom-table table-striped">

    <thead>

      <tr>

        <th>S.No.</th>

        <th>Name</th>

        <th>Email</th>

        <th>Phone Number</th>

        <th>IMEI</th>

        <th>SIM No.</th>

        <th>Status</th>





        <th id="TimeZone">Added Date</th>

        <th id="TimeZone2">Activated Date</th>

        

      </tr>

    </thead>

    <tbody>

      <?php 

        $i=1;

        foreach($result as $val)

        {

          

      ?>

      <tr>

        <td><?=$i;?></td>

        <td><?=$val['fullName'];?></td>

        <td><?=$val['email'];?></td>

        <td><?=$val['phoneNumber'];?></td>

        <td><?=$val['imei'];?></td>

        <td><?=$val['sim_no'];?></td>

        <td nowrap="nowrap"><?php if($val['status']==0){ echo "Pending"; }else { echo "Activated"; } ?></td> 

        <td nowrap="nowrap" class=""><?=converttolocal($val['created_date']); ?></td> 

        <td nowrap="nowrap" class=""><?php if($val['activation_date']!=NULL) { echo convertutctolocal($val['activation_date']);}else { echo "";} ?></td> 





        

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

<?php 



  //fix for onload time zone issuue

  // if (empty($_SESSION["timezonePhp"])){



  //   //  $_SESSION["timezonePhp"]='America/Toronto';

  //     header("Refresh:0");

  // }



?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>



<script src="../asset/js/jquery-dateformat.js"></script>











<script type="text/javascript">

$( document ).ready(function() {
     $("#report").change(function(){

    if($("#report").val()==1)
    {
      console.log('sssss');
     // $("#form1").submit();
      $("#form1_sub").trigger('click');
      // window.location.href='https://activate.cosmotogether.com/activatedataplans/reports/deviceinfo.php';
    }

  });
});

function changedate()
{

    var from=$("#from_date").val();
    var to=$("#to_date").val();
    
    $("#form1_date_from").val(from);
    $("#form1_date_to").val(to);

}




  $('.dateTime').each(function(){



      presentData = $(this).text();



      //presentData = $(this).text() + ' UTC';

      //console.log($.format.toBrowserTimeZone(new Date(presentData)));



      //$(this).text($.format.toBrowserTimeZone(new Date(presentData), 'yyyy-MM-dd HH:mm:ss'));



      $(this).text($.format.toBrowserTimeZone(convertUTCDateToLocalDate(new Date(presentData)), 'yyyy-MM-dd HH:mm:ss'));



      //console.log($.format.toBrowserTimeZone(convertUTCDateToLocalDate(new Date(presentData)), 'yyyy-MM-dd HH:mm:ss'));





      

  });





  function convertUTCDateToLocalDate(date) {

      date.setMinutes(date.getMinutes() - date.getTimezoneOffset());

      return date;

  }



  const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  $('#TimeZone').text('Added Date ('+ timeZone +')')

    $('#TimeZone2').text('Activated Date ('+ timeZone +')')





//  document.getElementById("export").addEventListener("click", function () {



//   //alert('k');

//   var html = document.querySelector("table").outerHTML;

//   htmlToCSV(html, "Activation Pending.csv");

// });





  function htmlToCSV(html, filename) {

  var data = [];

  var rows = document.querySelectorAll("table tr");

      

  for (var i = 0; i < rows.length; i++) {

    var row = [], cols = rows[i].querySelectorAll("td, th");

        

    for (var j = 0; j < cols.length; j++) {

            row.push(cols[j].innerText);

        }

            

    data.push(row.join(","));     

  }



  downloadCSVFile(data.join("\n"), filename);

}



function downloadCSVFile(csv, filename) {

  var csv_file, download_link;



  csv_file = new Blob([csv], {type: "text/csv"});



  download_link = document.createElement("a");



  download_link.download = filename;



  download_link.href = window.URL.createObjectURL(csv_file);



  download_link.style.display = "none";



  document.body.appendChild(download_link);



  download_link.click();

}





</script>



<?php

}

else

{



?>





  <script type="text/javascript">

       // alert('ss');

        $("#loader").show();
        $(".container").addClass('fullscreen');




        const timezonePhp = Intl.DateTimeFormat().resolvedOptions().timeZone;



        $.ajax({



                url: 'setSession.php',

                type: 'POST',

                dataType:"json",

                cache: false,

                data: {

                    timezonePhp: timezonePhp,

                    fnName : 'set',

                },

                success: function(data){

                 //   console.log(data);

                    location.reload(true);



                }

            });

    

    

  </script>





<?php

  

}

?>

</body>

</html>



