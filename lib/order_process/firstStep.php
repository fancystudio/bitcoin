<?php
session_start();
require_once '../../config.php';
require_once('../HelperClass.php');
require_once("../bitstamp/bitstamp.php");
$XML = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
$help = new Helper($config);
//echo $lang = CmsNlsOperations::get_current_language();
//$urlTotrustPay = $help->getUrlToTrustPay();
$checkFirstStep = $help->checkFirstStep($_POST["typeOfTransaction"],$_POST["valueOfTransaction"],false);
$bs = new Bitstamp("CeIdeV7AZN1yToo5SqQD5gMcEbGU1Pkj","P34HzxJdgxRq1xIIGiuJ8YX9UUqFQNFQ","633936");
$ticker = $bs->ticker();
$sumValue = null;
$usd = 0;
foreach($XML->Cube->Cube->Cube as $rate){
  if($rate["currency"] == "USD"){
    $usd = $rate["rate"];
  }
}
//$bitcoinValue = 811.65123;
$bitcoinValue = $ticker["last"];
$dolarCurrency = $usd;
$currency = $help->getCurrency($ticker,$usd);
$sumValue = $help->getSumValue($_POST["valueOfTransaction"], (($_POST["typeOfTransaction"] == "card") ? true : false ),
						true, $bitcoinValue, $dolarCurrency,$currency);
if($checkFirstStep == 1 && $sumValue["status"] == "success"){
	$cisloObejdnavky = explode(' ',microtime()); 
	$_SESSION["order"]["secondStepValid"] = true;
	$_SESSION["order"]["hodnotaTransakcieZ"] = $_POST["valueOfTransaction"];
	$_SESSION["order"]["hodnotaTransakcieDo"] = $sumValue["value"];
	$_SESSION["order"]["typTransakcie"] = $_POST["typeOfTransaction"];
	$_SESSION["order"]["cisloObjednavky"] = $cisloObejdnavky[1];
	$response_array['status'] = 'success';
	$response_array['cislo_objednavky'] = $cisloObejdnavky[1];
	$response_array['hodnota_transakcie_z'] = $_POST["valueOfTransaction"];
	$response_array['hodnota_transakcie_do'] = $sumValue["value"];
	//$response_array['url_to_trust_pay'] = $urlTotrustPay;
}else{
	$response_array['status'] = 'error'; 
}
header('Content-type: application/json');
echo json_encode($response_array);
?>