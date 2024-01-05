<?php 
@session_start();
@ob_start();
//print_r($_SESSION);

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'GigsApi.php';

use Application\Database;
use Application\GigsApi;

$is_userlogin=isUserLogin();
if(!isUserLogin())
{
	
    header('location: index.php');
    exit();

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>Dashboard</title>

	 <meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width"/>
      <link rel="shortcut icon" href="images/icon-180x180-08f3b9876667.png" type="image/x-icon">
      <!--css-->

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

      <!-- Optional theme -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">



      <link rel="stylesheet" href="<?= CSS_PATH.'register.css' ?>"/>
      <link rel="stylesheet" href="<?= CSS_PATH.'main.css' ?>"/>

</head>
<body>
	<table class="table table-bordered">
		<tr >
			<th rowspan="2">S. No.</th>
			<th rowspan="2">User Name</th>
			<th rowspan="2">Email Id</th>
			<th rowspan="2">Device Name</th>
			<th rowspan="2">SIM No.</th>
			<th rowspan="2">Phone No.</th>
			<th rowspan="2">Status</th>
			
			<!-- <th colspan="2" style="text-align:center;">Plan</th> -->
			
		</tr>
		<tr></tr>
<?php 
$db=new Database();
$check_imei_arr['table']=DEVICETABLE;
$check_imei_arr['selector']='id,imei';
$check_imei_arr['condition']="where (user_id)='".$_SESSION['loginuser']."'";

//echo $_SESSION['loginuser'];

$checkImeiExists=$db->Select($check_imei_arr);
//print_r($checkImeiExists);
if(count($checkImeiExists)>0)
{
$gigs=new GigsApi();
//echo $checkImeiExists[0]['imei'];

$deviceimei=$gigs->findDevicebyIMEI($checkImeiExists[0]['imei']);
//print_r($deviceimei);
if(isset($deviceimei['items']) and count($deviceimei['items'])>0)
{


$gigs_user_id=$deviceimei['items'][0]['user']['id'];

$query_params='user='.$gigs_user_id;

$device_array=$gigs->listAllDevicesUsingQueryParams($query_params);
//print_r($device_array);

?>

		
		<!-- <tr>
			<th>
				Plan Start
			</th>
			<th>
				Plan End
			</th>
		</tr> -->
		
		<?php
		$i=1;
			foreach($device_array['items'] as $val){
			//print_r($val);
				$subs_qry_prms="sim=".$val['sims'][0]['id'];
				$subs_dtls=$gigs->listAllSUbsusingQueryParams($subs_qry_prms);
				//print_r($subs_dtls);
				//echo "<br>";
				
		?>
		<tr>
			<th><?=$i; ?></th>
			<th><?=$val['user']['fullName'];?></th>
			<th><?=$val['user']['email'];?></th>
			<th><?=$val['imei'];?></th>
			<th><?=$val['sims'][0]['iccid'];?></th>
			<th><?=$subs_dtls['items'][0]['phoneNumber'];?></th>
			<th><?php echo $subs_dtls['items'][0]['status'];?></th>
			<!-- <th><?=date('d-m-Y',strtotime($subs_dtls['items'][0]['currentPeriod']['start']));?></th>
			<th><?=date('d-m-Y',strtotime($subs_dtls['items'][0]['currentPeriod']['end']));?></th>
			 -->

		</tr>
		<?php
			$i++;
			}
		}
		else
		{
		?>
		<tr>
			<td colspan="6">No Device Found in GIGS</td>
		</tr>
		<?php	
		}
}
else
{
?>
<tr align="center">
	<td colspan="7">No Data Found.</td>
</tr>
<?php

}
?>
		
			
		
	</table>
</body>
</html>