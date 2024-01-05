<?php 

	$json = file_get_contents('php://input');
	// Converts it into a PHP object
	$test = "Test: ";
	$data = json_decode($json);

 	$file = fopen("recharge_webhooks-customer.txt", "a") or die("Unable to open file!");
    fwrite($file, $test.$data."\n");
    fclose($file);


?>