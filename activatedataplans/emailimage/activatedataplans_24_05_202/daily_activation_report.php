<?php
@session_start();
@ob_start();

//print_r($_SESSION);
error_reporting(E_ALL);
ini_set('display_errors', '1');
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';

use Application\Database;

$db=new Database();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form method="post">
      <div class="col-md-4">From Date: <input type="date" name="from_date" id="from_date" value="<?=date('Y-m-d')?>"></div>
      <div class="col-md-4">To Date: <input type="date" name="to_date" id="to_date" value="<?=date('Y-m-d')?>"></div>

      <div class="col-md-4"><input type="submit" name="submit" id="submit" value="Search"></div>
      </form>
    </div>
  </div>
<?php 
  if(isset($_POST['submit']))
  {
      $date_from=$_POST['from_date'];
      $date_to=$_POST['to_date'];

      $where=" and date(activation_date) between '$date_from' and '$date_to'";
      
  }
  else
  {

      $where=" and date(activation_date) between '".date('Y-m-d')."' and '".date('Y-m-d')."'";

  }

   $query="select email,imei,sim_no,phone_number from device_details_new join user_mstr on device_details_new.user_id=user_mstr.id where 1".$where;
$arr=array();
$arr['query']=$query;
  $result=$db->SelectRaw($arr);

  //print_r($result);

?>
  <table class="table">
    <thead>
      <tr>
        <th>S.No.</th>
        <th>Email</th>
        <th>IMEI</th>
        <th>SIM No.</th>
        <th>Phone No.</th>
        
      </tr>
    </thead>
    <tbody>
      <?php 
        $i=1;
        foreach($result as $val)
        {
          
      ?>
      <tr>
        <th><?=$i;?></th>
        <th><?=$val['email'];?></th>
        <th><?=$val['imei'];?></th>
        <th><?=$val['sim_no'];?></th>
        <th><?=$val['phone_number'];?></th>
        
      </tr>
      <?php 
        $i++;
        }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>

