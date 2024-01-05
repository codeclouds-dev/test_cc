<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
  include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone'. DIRECTORY_SEPARATOR .'Database.php';
 use Application\Database;
$db=new Database();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Import Data</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.mainbox{min-height: 100vh;padding: 10px 15px}
		.mainbox button{
			width: 100%;
		    font-size: 22px;
		    font-weight: 600;
		    height: auto;
		    padding: 8px 15px;
		    display: inline-block;
		    line-height: 35px;
		    text-transform: uppercase;
		}
	</style>
</head>
<body>

<?php
	
	if(isset($_POST['submit']))
	{
		 $file=$_FILES['import_data']['tmp_name'];
		 		 $filepath=$_FILES['import_data']['name'];

print_r($file);
		//$file2 = fopen($file,"r");
		move_uploaded_file($file, "/home/activatecosmotog/public_html/activatedataplans_cancel/import/".$filepath);
	//	$file2 = fopen("/home/activatecosmotog/public_html/activatedataplans_cancel/import/".$file3,"r");

echo $fileopen="/home/activatecosmotog/public_html/activatedataplans_cancel/import/".$filepath;

$query="LOAD DATA LOCAL INFILE '$fileopen' INTO TABLE device_import
FIELDS TERMINATED BY ','LINES TERMINATED BY '\n'";

//	echo	$query=" LOAD DATA LOCAL '$filepath' INTO TABLE device_import";
		$arr=array();
		$arr['query']=$query;
  	$result=$db->SelectRaw($arr);
  	print_r($result);

		


	}
?>
  
	<div class="d-flex align-items-center justify-content-center mainbox">
		<form method="post" enctype= multipart/form-data>
			<!-- <input type="file" name="import_data" id="import_Data">
			<input type="submit" name="submit" value="Submit"> -->
			<div class="mb-3">
			  <input class="form-control form-control-lg" name="import_data" id="import_data" type="file">
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>