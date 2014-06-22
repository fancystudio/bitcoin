<?php
function smarty_function_tabulka_mien($params, &$template){
require_once('lib/HelperClass.php');
require_once("lib/bitstamp/bitstamp.php");
$XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
$help = new Helper(cmsms()->config);	
$actualLang = $help->getTranslate(CmsNlsOperations::get_current_language());
$bs = new Bitstamp("CeIdeV7AZN1yToo5SqQD5gMcEbGU1Pkj","P34HzxJdgxRq1xIIGiuJ8YX9UUqFQNFQ","633936");
$usd = 0;
foreach($XML->Cube->Cube->Cube as $rate){
  if($rate["currency"] == "USD"){
    $usd = $rate["rate"];
  }
}
//$currency = $help->getCurrency((float)811.65123,$usd);
$currency = $help->getCurrency($bs->ticker(),$usd);
  ?>
  
  <table class="currency-chart pull-right">
				<tr>
					<td><strong><?php echo $actualLang["predaj"] ?>:</strong></td>
					<td><strong>1 <span>BTC</span> = <span class="chart-sell"><?php echo $currency["predaj"] ?></span> €<strong></td>
				</tr>
				<tr>
					<td><strong><?php echo $actualLang["nakup"] ?>:</strong></td>
					<td><strong>1 <span>BTC</span> = <span class="chart-buy"><?php echo $currency["nakup"] ?></span> €</strong></td>
				</tr>
	</table>
  <?php
}
?>
