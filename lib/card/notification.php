<?php
//mail("info@fancystudio.sk","liveres",$_REQUEST["RES"],"From:info@fancystudio.sk \r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n");
if($_REQUEST["RES"] == 0){
  require_once ('../../config.php');	
  require_once('../HelperClass.php');
  $help = new Helper($config);
  $help->refreshOrderAfterTrustPay($_REQUEST["REF"]);
}
?>