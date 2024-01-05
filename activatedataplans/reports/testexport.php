<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';


use Application\Database;

$db=new Database();
$where="";
 $query="select fullName,phoneNumber,email,imei,sim_no,phone_number,activation_date  from device_details_new join user_mstr on device_details_new.user_id=user_mstr.id where 1 and device_details_new.status=2".$where;
$arr=array();
$arr['query']=$query;
  $result=$db->SelectRaw($arr);


// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "members-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('FIRST NAME', 'LAST NAME', 'EMAIL', 'GENDER', 'COUNTRY', 'CREATED'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
if(count($result)>0){ 
    // Output each row of the data 
    foreach($result as $row){ 
 
        $lineData = array($row['fullName'], $row['phoneNumber'], $row['email'], $row['sim_no'], $row['phone_number'], $row['activation_date']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;


?>