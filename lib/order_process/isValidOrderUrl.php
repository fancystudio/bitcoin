<?php
session_start();
if($_POST["currentStep"] == "#firstStep"){
	require_once('resetProcess.php');
	$response_array['status'] = 'success';		
}else if($_POST["currentStep"] == "#secondStep"){
	if($_SESSION["order"]["secondStepValid"] == 1){
		$response_array['status'] = 'success';
		$response_array['cookies'] = $_SESSION["order"];
	}else{
		$response_array['status'] = 'error';
	}
}else if($_POST["currentStep"] == "#thirdStep"){
	if($_SESSION["order"]["thirdStepValid"] == 1){
		$response_array['status'] = 'success';
		$response_array['cookies'] = $_SESSION["order"];
	}else{
		$response_array['status'] = 'error';
	}
}
		
header('Content-type: application/json');
echo json_encode($response_array);		
?>