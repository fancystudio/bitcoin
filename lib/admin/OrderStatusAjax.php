<?php
error_reporting( E_ALL );
ini_set('display_errors', 1);
require_once '../../config.php';
require_once('../HelperClass.php');
$help = new Helper($config);
$orderStatus = $help->orderStatusProcess($_POST["type"], $_POST["idOrder"], $_POST["value"]);
if($orderStatus != null){
	$response_array['status'] = 'success';
	$response_array['value'] = $orderStatus;	
}else{
	$response_array['status'] = 'error';
} 
header('Content-type: application/json');
echo json_encode($response_array);
?>
