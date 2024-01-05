<?php
@session_start();
@ob_start();

//print_r($_SESSION);
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';


use Application\Database;

$db=new Database();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Daily Activation Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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

  <?php if(!isset($_POST['export'])) 
  {
    ?>
  <div class="row">
    <div class="col-md-8 col-12">
      <form method="post" class="cust-form">
      <div class="col-md-3 col-12 pl-0">From Date: <input type="date" name="from_date" id="from_date" value="<?=isset($_POST['from_date'])?$_POST['from_date']:date('Y-m-d')?>"></div>
      <div class="col-md-3 col-12">To Date: <input type="date" name="to_date" id="to_date" value="<?=isset($_POST['to_date'])?$_POST['to_date']:date('Y-m-d')?>"></div>

      <div class="col-md-3 col-12">Status: 
        <select name="status" id="status" >
            <option value="2" <?php if(isset($_POST['status']) and $_POST['status']==2){ echo "selected"; } ?>>Active</option>
            <option value="6" <?php if(isset($_POST['status']) and $_POST['status']==6){ echo "selected"; } ?>>Cancelled</option>
            
        </select>
      </div>


      <div class="col-md-3 col-12"><input type="submit" name="submit" id="submit" value="Search"></div>
      </form>

      <!--    <form method="post">
     

      <div class="col-md-4"><input type="submit" name="export" id="export" value="Export"></div>
      </form>
 -->
      
    </div>
    <div class="col-md-4 col-12 text-right ext-mrg">
       <button type="button" id="export">export CSV</button>
    </div>
  </div>
<?php 
}


  if(isset($_POST['submit']))
  {
      $date_from=$_POST['from_date'];
      $date_to=$_POST['to_date'];

      $status=$_POST['status'];
        $_SESSION['date_from']=$date_from;
      $_SESSION['date_to']=$date_to;
      
      if($status==2)
      {
          $where_status=" and device_details_new.status='2' and date(activation_date) between '$date_from' and '$date_to'";
      }
      else
      {
          $where_status=" and device_details_new.status='6' and date(updated_date) between '$date_from' and '$date_to'";
      }

      $_SESSION['where_status']=$where_status;
      $where=$where_status;
      
  }
  else if(isset($_SESSION['date_from']) and $_SESSION['date_to'])
  {
      //echo "string";
      $date_from=$_SESSION['date_from'];
      $date_to=$_SESSION['date_to'];
     

      $where=$_SESSION['where_status'];

  }
  else
  {
      $where=" and date(activation_date) between '".date('Y-m-d')."' and '".date('Y-m-d')."' and device_details_new.status='2'";
  }

    $query="select fullName,phoneNumber,email,imei,sim_no,phone_number,activation_date,updated_date  from device_details_new join user_mstr on device_details_new.user_id=user_mstr.id where 1".$where." order by activation_date desc";
$arr=array();
$arr['query']=$query;
  $result=$db->SelectRaw($arr);

  //print_r($result);

if(isset($_POST['export']))
 {


    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=Daily Activation.xls');

 }
 
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
        <th>Watch Phone No.</th>
     <!--    <th>Date (<script type="text/javascript">var MyTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
document.write(MyTimeZone);
</script>)</th> -->

        <th>Date</th>
        
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
        <td><?=$val['phone_number'];?></td>
        <!-- <td><?=date('Y-m-d',strtotime($val['activation_date']));?></td> -->
        <?php 

          if(isset($_POST['status']) and $_POST['status']==6)
          {
            $updated_date=$val['updated_date'];
          }
          else
          {
            $updated_date=$val['activation_date'];
          }

          $format_date=$updated_date.' UTC';
        ?>
         <td nowrap="nowrap"><?php echo $updated_date; ?></td> 

       <!--  <td nowrap="nowrap">
          <script type="text/javascript">
            var dt = new Date('<?=$format_date?>');
            document.write(dt.toLocaleString()) </script>
        </td> -->
        <!-- <td nowrap="nowrap">
          <script type="text/javascript">
            var timeEpoch='<?=strtotime($format_date)?>';
            var date = new Date();
    var offset = date.getTimezoneOffset();
  // document.write(diff);
            console.log(timeEpoch);
            // var offset = date.getTimezoneOffset();

            console.log(offset);
         
    var d = new Date(timeEpoch);
    console.log(d);

    var utc = d.getTime() + (d.getTimezoneOffset() * 60000);  //This converts to UTC 00:00
    console.log(utc);
    var nd = new Date(utc + (3600000*offset));
    console.log(nd);
    console.log('-----------------------');
    document.write(nd.toLocaleString()) ;
           </script>
        </td> -->
        
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


<script type="text/javascript">
  

 document.getElementById("export").addEventListener("click", function () {

  //alert('k');
  var html = document.querySelector("table").outerHTML;
  htmlToCSV(html, "Daily Activation.csv");
});


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
</body>
</html>

