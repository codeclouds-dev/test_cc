<?php

session_start();

$response = array();


if (!empty($_REQUEST['timezonePhp']) && empty($_SESSION["timezonePhp"]) && $_REQUEST['fnName'] == 'set') {
	

	$_SESSION["timezonePhp"] = $_REQUEST['timezonePhp'];


	$response['sucess'] = true;

}elseif (!empty($_SESSION["timezonePhp"]) && $_REQUEST['fnName'] == 'get') {


	$response = array(

		'sucess' => true,
		'timezonePhp' => $_SESSION["timezonePhp"],
	);	

}else{

	$response['sucess'] = false;
}


echo json_encode($response);

?>