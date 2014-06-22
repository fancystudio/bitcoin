<?php
require_once '../../config.php';
require_once('../HelperClass.php');
require_once("../bitstamp/bitstamp.php");
$XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
$help = new Helper($config);
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
$sumValue = $help->getSumValue($_POST["value"],$_POST["isSellSide"],$_POST["isReadOnly"],$bitcoinValue,$dolarCurrency,$currency);
$response_array["status"] = $sumValue["status"];
$response_array["value"] = $sumValue["value"];
header('Content-type: application/json');
echo json_encode($response_array);
?>