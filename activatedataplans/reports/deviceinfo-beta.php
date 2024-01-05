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
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">

</head>
<body>

<div class="container">

  <?php if(!isset($_POST['export'])) 
  {
    ?>
  <div class="row">
    <div class="col-md-12">
      <form method="post">
      <div class="col-md-4">From Date: <input type="date" name="from_date" id="from_date" value="<?=isset($_POST['from_date'])?$_POST['from_date']:date('Y-m-d')?>"></div>
      <div class="col-md-4">To Date: <input type="date" name="to_date" id="to_date" value="<?=isset($_POST['to_date'])?$_POST['to_date']:date('Y-m-d')?>"></div>

      <div class="col-md-4"><input type="submit" name="submit" id="submit" value="Search"></div>
      </form>

         <form method="post">
     

      <div class="col-md-4"><input type="submit" name="export" id="export" value="Export"></div>
      </form>
    </div>
  </div>
<?php 
}

if(isset($_POST['export']))
 {


    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=Daily Activation.xls');

 }

  if(isset($_POST['submit']))
  {
      $date_from=$_POST['from_date'];
      $date_to=$_POST['to_date'];

      $where=" and date(activation_date) between '$date_from' and '$date_to'";
      
  }
  else if(isset($_POST['from_date']) and $_POST['from_date']!="" and isset($_POST['to_date']) and $_POST['to_date']!="")
  {
      $date_from=$_POST['from_date'];
      $date_to=$_POST['to_date'];
      
        $where=" and date(activation_date) between '$date_from' and '$date_to'";
  }
  else
  {
      $where=" and date(activation_date) between '".date('Y-m-d')."' and '".date('Y-m-d')."'";
  }

   $query="select fullName,phoneNumber,email,imei,sim_no,phone_number,activation_date  from device_details_new join user_mstr on device_details_new.user_id=user_mstr.id where 1".$where;
$arr=array();
$arr['query']=$query;
  $result=$db->SelectRaw($arr);

  //print_r($result);

 
?>
  <table class="table">
    <thead>
      <tr>
        <th>S.No.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>IMEI</th>
        <th>SIM No.</th>
        <th>Watch Phone No.</th>
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
        <td><?=date('Y-m-d',strtotime($val['activation_date']));?></td>
        </tr>
      <?php 
        $i++;
        }
      ?>
    </tbody>
  </table>
</div>












    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
</body>
</html>

