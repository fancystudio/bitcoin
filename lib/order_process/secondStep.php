<?php
session_start();
require_once '../../config.php';
require_once('../HelperClass.php');
$help = new Helper($config);

if($_POST["isSepa"] == "true"){
	$checkSecondStepSepa = $help->checkSecondStepSepa($_POST["clientEmailValue"],$_POST["menoNazovSepa"],$_POST["ulicaSepa"],
											$_POST["mestoSepa"],$_POST["smerovacieCisloSepa"],
											$_POST["ibanSepa"],$_POST["swiftBicSepa"],
											$_POST["clientAdresaZKtorejSaPosielaValue"]);
	$checkSecondStep = true;										
}else{
	$checkSecondStep = $help->checkSecondStep($_POST["clientEmailValue"],$_POST["clientFirstNameValue"],
											$_POST["clientLastNameValue"],$_POST["clientCisloPenazenkyValue"],
											$_POST["clientCisloUctuValue"],$_POST["clientAdresaZKtorejSaPosielaValue"],
											$_SESSION["order"]["typTransakcie"]);
	$checkSecondStepSepa = true;
}
if($checkSecondStep == 1 && $checkSecondStepSepa == 1){
	$_SESSION["order"]["thirdStepValid"] = true;
	$_SESSION["order"]["email"] = $_POST["clientEmailValue"];
	$_SESSION["order"]["meno"] = $_POST["clientFirstNameValue"];
	$_SESSION["order"]["priezvisko"] = $_POST["clientLastNameValue"];
	$_SESSION["order"]["cisloUctu"] = $_POST["clientCisloUctuValue"];
	$_SESSION["order"]["cisloPenazenky"] = $_POST["clientCisloPenazenkyValue"];
	$_SESSION["order"]["adresaZKtorejSaPosiela"] = $_POST["clientAdresaZKtorejSaPosielaValue"];
	$_SESSION["order"]["menoNazovSepa"] = $_POST["menoNazovSepa"];
	$_SESSION["order"]["ulicaSepa"] = $_POST["ulicaSepa"];
	$_SESSION["order"]["mestoSepa"] = $_POST["mestoSepa"];
	$_SESSION["order"]["smerovacieCisloSepa"] = $_POST["smerovacieCisloSepa"];
	$_SESSION["order"]["ibanSepa"] = $_POST["ibanSepa"];
	$_SESSION["order"]["swiftBicSepa"] = $_POST["swiftBicSepa"];
	$_SESSION["order"]["isSepa"] = $_POST["isSepa"];
	$response_array['status'] = 'success'; 
}else{
	$response_array['status'] = 'error'; 
}
header('Content-type: application/json');
echo json_encode($response_array);
?>