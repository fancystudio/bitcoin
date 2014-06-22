<?php
require_once '../config.php';
require_once('HelperClass.php');
require_once("bitstamp/bitstamp.php");
$XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
$usd = 0;
foreach($XML->Cube->Cube->Cube as $rate){
  if($rate["currency"] == "USD"){
    $usd = $rate["rate"];
  }
}
$help = new Helper($config);
$bs = new Bitstamp("CeIdeV7AZN1yToo5SqQD5gMcEbGU1Pkj","P34HzxJdgxRq1xIIGiuJ8YX9UUqFQNFQ","633936");
$currency = $help->getCurrency($bs->ticker(),$usd);
//$currency = $help->getCurrency(811.65123,$usd);
header('Content-type: application/json');
echo json_encode($currency);
?>