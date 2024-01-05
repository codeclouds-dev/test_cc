<?php 

$username='CodeCloud';
$password='testing';
$URL='https://cosmoadmin.senlab.io/cosmo-api-test/IMEIcheck';
 // $URL='https://cosmoadmin.senlab.io/cosmo-api-test/IMEIactivate';
 // $URL='https://cosmoadmin.senlab.io/cosmo-api-test/IMEIdisactivate';

$imei_check=array();
$imei_check['imei']='867798041481087';
$imei_check['imei']='867798041132672';


$speedtalk_activate=array();
$speedtalk_activate['imei']='123456789123469';
$speedtalk_activate['birthday']='2022-06-24';
$speedtalk_activate['email']='vijaya@gmail.com';
$speedtalk_activate['fullName']='vijaya Jha';
$speedtalk_activate['line1']='test';
$speedtalk_activate['line2']='test';
$speedtalk_activate['city']='test';
$speedtalk_activate['state']='test';
$speedtalk_activate['postalCode']='96701';
$speedtalk_activate['country']='US';


$ch = curl_init();
curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_DIGEST);

curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json'));

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($imei_check));

curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
$result=curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);
echo $status_code;
print_r($result);

?>