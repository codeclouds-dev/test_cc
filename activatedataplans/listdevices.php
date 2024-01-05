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

$gigs=new GigsApi();
//echo $checkImeiExists[0]['imei'];



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
			<th>S. No.</th>
			<th>User Name</th>
		</tr>	
		<tr></tr>
		<?php
		$i=1;
		$offset="";
		if(isset($_GET['offset']) and $_GET['offset']!="" and isset($_GET['back']) and $_GET['back']==1)
		{
			$param="&before=".$_GET['offset'];
		}
		else if(isset($_GET['offset']) and $_GET['offset']!="" and isset($_GET['next'])  and $_GET['next']==1)
		{
			$param="&after=".$_GET['offset'];
		}
		else
		{
			$param="";
		}

		$param="limit=5".$param;
		$listdevices=$gigs->listAllDevicesUsingQueryParams($param);
		//print_r($listdevices);


			foreach($listdevices['items'] as $val){
			//print_r($val);
				

		?>
		<tr>
			<th><?=$i++; ?></th>
			<th><?=$val['imei'];?></th>
			</tr>
			
		<?php
			$i++;
			$offset=$val['id'];
			}
	// /echo $offset;
		?>
		
			
		
	</table>
	<p><a href="listdevices.php?offset=<?php echo $offset;?>&back=1">prev</a></p>
	<p><a href="listdevices.php?offset=<?php echo $offset;?>&next=1">next</a></p>
</body>
</html>