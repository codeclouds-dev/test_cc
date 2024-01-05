<?php 


$data = file_get_contents('php://input');
$arr=json_decode($data,true);
$addr_id=$arr['subscription']['address_id'];

//$data = json_encode($data);
//print_r($arr);

	 $textDataOrder=PHP_EOL."arr => ".print_r($arr,true)."==addr_id==".$addr_id;
    
 	$orderfile = fopen("webhookresponse.txt", "a") or die("Unable to open file!");
    fwrite($orderfile, $textDataOrder);
    fclose($orderfile);


?>