<?php
//1.ovalidovat polia
session_start();
$checkDbInsert = false;
$urlTotrustPay = "";
require_once('../HelperClass.php');
$help = new Helper;
if($_POST["sendOrder"] == true){      
	$checkTypeOfSellTransaction = $help->checkTypeOfSellTransaction($_POST["typeOfSellTransaction"]);
	$checkFirstStep = $help->checkFirstStep($_SESSION["order"]["typTransakcie"], $_SESSION["order"]["hodnotaTransakcieZ"], 
												$_SESSION["order"]["hodnotaTransakcieDo"]);
	if($_SESSION["order"]["isSepa"] == "true"){
		$checkSecondStepSepa = $help->checkSecondStepSepa($_SESSION["order"]["email"],$_SESSION["order"]["menoNazovSepa"],
											$_SESSION["order"]["ulicaSepa"],$_SESSION["order"]["mestoSepa"],$_SESSION["order"]["smerovacieCisloSepa"],
											$_SESSION["order"]["ibanSepa"],$_SESSION["order"]["swiftBicSepa"],$_SESSION["order"]["adresaZKtorejSaPosiela"]);
		$checkSecondStep = true;
	}else{
		$checkSecondStep = $help->checkSecondStep($_SESSION["order"]["email"],$_SESSION["order"]["meno"],$_SESSION["order"]["priezvisko"],
													$_SESSION["order"]["cisloPenazenky"],$_SESSION["order"]["cisloUctu"],
													$_SESSION["order"]["adresaZKtorejSaPosiela"],$_SESSION["order"]["typTransakcie"]);
		$checkSecondStepSepa = true;
	}
	
	if($checkFirstStep == 1 && $checkSecondStep == 1 && $checkSecondStepSepa == 1 && $checkTypeOfSellTransaction == 1){
		if($_SESSION["order"]["typTransakcie"] == "card"){
		$sumInfoToAdmin .= $_SESSION["order"]["hodnotaTransakcieZ"]." BTC -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." Eur";
		if($_POST["typeOfSellTransaction"] == "classic"){
			$typTransakcie = "€ -> BTC";
		}else{
			$typTransakcie = "€ -> BTC (Trust Pay)";
			$urlTotrustPay = $help->getUrlToTrustPay($_SESSION["order"]["cisloObjednavky"],$_SESSION["order"]["hodnotaTransakcieZ"]);
		}
		}else{
			$sumInfoToAdmin .= $_SESSION["order"]["hodnotaTransakcieZ"]." Eur -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." BTC";
			$typTransakcie = "BTC -> €";
		}
	
		//2.vytovirit xml
		$xml = '';
		$xml .=  '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<response form_id="4">';
		$xml .= $help->xmlPart("meno",31,$_SESSION["order"]["meno"],3); 
		$xml .= $help->xmlPart("typ vymeny",32,$typTransakcie,4); 
		$xml .= $help->xmlPart("priezvisko",33,$_SESSION["order"]["priezvisko"],5); 
		$xml .= $help->xmlPart("email",34,$_SESSION["order"]["email"],6); 
		$xml .= $help->xmlPart("cislo penazenky",35,$_SESSION["order"]["cisloPenazenky"],7); 
		$xml .= $help->xmlPart("cislo uctu",36,$_SESSION["order"]["cisloUctu"],8); 
		$xml .= $help->xmlPart("suma",37,$sumInfoToAdmin,9);
		$xml .= $help->xmlPart("cislo objednavky",38,$_SESSION["order"]["cisloObjednavky"],10);
		$xml .= $help->xmlPart("adresa z ktorej btc posielate",39,$_SESSION["order"]["adresaZKtorejSaPosiela"],11);
		$xml .= $help->xmlPart("meno/nazov (sepa)",40,$_SESSION["order"]["menoNazovSepa"],12);
		$xml .= $help->xmlPart("ulica (sepa)",41,$_SESSION["order"]["ulicaSepa"],13);
		$xml .= $help->xmlPart("mesto (sepa)",42,$_SESSION["order"]["mestoSepa"],14);
		$xml .= $help->xmlPart("smerovacie cislo (sepa)",43,$_SESSION["order"]["smerovacieCisloSepa"],15);
		$xml .= $help->xmlPart("iban (sepa)",44,$_SESSION["order"]["ibanSepa"],16);
		$xml .= $help->xmlPart("swift bic (sepa)",45,$_SESSION["order"]["swiftBicSepa"],17);
		$xml .= '</response>';
		
		//3.ulozit do tabulky
		$checkDbInsert = $help->insertOrder($xml,$_SESSION["order"]["cisloObjednavky"],$_SESSION["order"]["hodnotaTransakcieZ"]);
	}
		
}
if($checkDbInsert == 1){
	if(strlen($urlTotrustPay) > 0){
		$response_array['pay_type'] = 'trustPay';
		$response_array['trust_pay'] = $urlTotrustPay;
	}else{
		$response_array['pay_type'] = 'classic';
	}
	$response_array['status'] = 'success'; 	
	$mailMessage = "";
	$adminMessage = "";
  	if($_SESSION["order"]["typTransakcie"] == "card"){
      if($_POST["typeOfSellTransaction"] == "classic"){
       $mailMessage = "Dobrý deň,<br><br>
	      ďakujeme za Vašu objednávku #".$_SESSION["order"]["cisloObjednavky"].". Nižšie v tomto e-maile nájdete inštrukcie k platbe.<br><br>
	      <span style='font-weight:bold;text-decoration:underline'>Kupujete od nás Bitcoiny za ".$_SESSION["order"]["hodnotaTransakcieZ"]." Eur</span><br><br>
	      Pri aktuálnom kurze ".round($_SESSION["order"]["hodnotaTransakcieZ"]/$_SESSION["order"]["hodnotaTransakcieDo"],6)." Eur / 1 BTC, sume <span style='font-weight:bold'>".$_SESSION["order"]["hodnotaTransakcieZ"]." Eur</span> zodpovedá počet bitcoinov: <span style='font-weight:bold'>".$_SESSION["order"]["hodnotaTransakcieDo"]." BTC</span>. 
	      Tento počet je však len orientačný. Výsledný počet bude vypočítaný rovnakým spôsobom podľa kurzu platného okamihu pripísania platby na náš účet, viz naše obchodné podmienky.<br><br> 
	      Pre dokončenie transakcie prosím odošlite platbu na náš účet.<br><br>
	      Pre prevod zo <span style='text-decoration:underline'>Slovenskej republiky:</span><br>
	      Suma: <span style='font-weight:bold'>".$_SESSION["order"]["hodnotaTransakcieZ"]." EUR</span><br>
			Účet:  <span style='font-weight:bold'>1222314018/1111</span><br>
			Variabilný symbol:  <span style='font-weight:bold'>".$_SESSION["order"]["cisloObjednavky"]."  (povinné)</span><br>
			Informácia pre príjemcu:   <span style='font-weight:bold'>„Platim za bitcoin z <span style='text-decoration:underline'>kupitbitcoin.sk</span>“   (povinné)</span><br><br>
			Bez variabilného symbolu nemusí byť Vaša platba zaznamenaná.<br>
			Bez informácie pre príjemcu platba nebude akceptovaná a bude odoslaná späť.<br><br>
			Pre prevod z <span style='text-decoration:underline'>Českej republiky:</span><br><br>
			Názov:   AVERLON INTERNATIONAL CORP<br><br>
			Adresa:  Trnavá Hora 210, Žiar nad Hronom  96611<br><br>
			Suma: ".$_SESSION["order"]["hodnotaTransakcieZ"]." EUR<br>
			IBAN: SK4711110000001222314018<br>
			BIC(SWIFT): UNCRSKBX<br>
      Variabilný symbol:  <span style='font-weight:bold'>".$_SESSION["order"]["cisloObjednavky"]."  (povinné)</span><br>
			Informácia pre príjemcu:   <span style='font-weight:bold'>„Platim za bitcoin z <span style='text-decoration:underline'>kupitbitcoin.sk</span>“   (povinné)</span><br><br>
			Ihneď po prijatí platby Vám obratom zašleme Bitcoiny do peňaženky ".$_SESSION["order"]["cisloPenazenky"]."<br><br>
			 Táto transakcia je platná do 48 hodín, preto prosím neodkladajte platbu. Ak platba do tejto
			 doby nedorazí, bude zámena zrušená.<br><br><br> 
	      Ďakujeme za Vašu dôveru a tešíme sa na ďalšiu spoluprácu.<br><br>
	      Tím Buysell Bitcoin<br><br>
		<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
		  $adminMessage = "Kúpenie bitcoinu: ".$_SESSION["order"]["hodnotaTransakcieZ"]." EUR -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." BTC";      
    }else{
      $mailMessage = "Dobrý deň,<br><br>
	      ďakujeme za Vašu objednávku #".$_SESSION["order"]["cisloObjednavky"].".<br>
	      <span style='font-weight:bold;text-decoration:underline'>Kupujete od nás Bitcoiny za ".$_SESSION["order"]["hodnotaTransakcieZ"]." Eur</span><br><br>
	      Pri aktuálnom kurze ".round($_SESSION["order"]["hodnotaTransakcieZ"]/$_SESSION["order"]["hodnotaTransakcieDo"],6)." Eur / 1 BTC, sume <span style='font-weight:bold'>".$_SESSION["order"]["hodnotaTransakcieZ"]." Eur</span> zodpovedá počet bitcoinov: <span style='font-weight:bold'>".$_SESSION["order"]["hodnotaTransakcieDo"]." BTC</span>. 
	      Tento počet je však len orientačný. Výsledný počet bude vypočítaný rovnakým spôsobom podľa kurzu platného okamihu pripísania platby na náš účet, viz naše obchodné podmienky.<br><br> 
	      Pre dokončenie transakcie prosím odošlite platbu cez platobnú bránu TrustPay.<br><br>
			Ihneď po prijatí platby Vám obratom zašleme Bitcoiny do peňaženky ".$_SESSION["order"]["cisloPenazenky"]."<br><br>
			 Táto transakcia je platná 1 hodinu, preto prosím neodkladajte platbu. Ak platba do tejto
			 doby nedorazí, bude zámena zrušená.<br><br><br> 
	      Ďakujeme za Vašu dôveru a tešíme sa na ďalšiu spoluprácu.<br><br>
	      Tím Buysell Bitcoin<br><br>
		<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
      $adminMessage = "Kúpenie bitcoinu: ".$_SESSION["order"]["hodnotaTransakcieZ"]." EUR -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." BTC";
    }		
  }else if($_SESSION["order"]["typTransakcie"] == "buy"){
  		$sepaAccount = "(SEPA):";
  		if($_SESSION["order"]["isSepa"] == "true"){
  			$sepaAccount .= "meno/nazov: ".$_SESSION["order"]["menoNazovSepa"].", ";
  			$sepaAccount .= "ulica: ".$_SESSION["order"]["ulicaSepa"].", ";
  			$sepaAccount .= "mesto: ".$_SESSION["order"]["mestoSepa"].", ";
  			$sepaAccount .= "smerovacie cislo: ".$_SESSION["order"]["smerovacieCisloSepa"].", ";
  			$sepaAccount .= "iban: ".$_SESSION["order"]["ibanSepa"].", ";
  			$sepaAccount .= "swift bic: ".$_SESSION["order"]["swiftBicSepa"];
  		}
  		$mailMessage = "Dobrý deň,<br><br>
		ďakujeme za Vašu objednávku ".$_SESSION["order"]["cisloObjednavky"].".Nižšie v tomto e-maile nájdete inštrukcie k prevodu Bitcoinov.<br>
		<span style='font-weight:bold;text-decoration:underline'>Predávate nám ".$_SESSION["order"]["hodnotaTransakcieZ"]." BTC.</span><br><br>  
		Pri aktuálnom kurze ".round($_SESSION["order"]["hodnotaTransakcieDo"]/$_SESSION["order"]["hodnotaTransakcieZ"],2)." Eur / 1 BTC počtu ".$_SESSION["order"]["hodnotaTransakcieZ"]." BTC zodpovedá suma: ".$_SESSION["order"]["hodnotaTransakcieDo"]." Eur. 
		Táto suma je však len orientačná. Výsledná suma bude vypočítaná rovnakým spôsobom podľa kurzu platného okamihu pripísania platby do našej peňaženky, viz naše obchodné podmienky.<br><br>
		Pre dokončenie transakcie prosím odošlite Bitcoiny z vašej peňaženky ".$_SESSION["order"]["adresaZKtorejSaPosiela"]." do našej peňaženky <span style='font-weight:bold'>18qchJtQHTWg8rsbZbhw5Mz5qXKQcR7R5M</span><br><br>
		Je nutné aby ste Bitcoiny odoslali z peňaženky ktorú ste uviedli v objednávke, z dôvodu jej dôveryhodného zaznamenania.<br><br>
		Ihneď po prijatí Bitcoinov Vám obratom pošleme Eurá na Váš účet ".(($_SESSION["order"]["isSepa"] == "true") ? $sepaAccount : $_SESSION["order"]["cisloUctu"] )."<br><br>
		Táto transakcia je platná do 4 hodín od zadania objednávky, preto prosím neodkladajte platbu. Ak platba dorazí po tejto dobe nemusí byt zrealizovaná. Ak by zrealizovaná z tohto dôvodu nebola, Bitcoiny Vám budú zaslané späť, znížené o poplatok pre minera 0.005 BTC.<br><br>
		Ďakujeme za Vašu dôveru a tešíme sa na ďalšiu spoluprácu.<br><br>
		Tím Buysell Bitcoin<br><br>
		<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
  		$adminMessage = "Predaj bitcoinu: ".$_SESSION["order"]["hodnotaTransakcieZ"]." BTC -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." EUR";
  }
  if(count($mailMessage) > 0){
  	$help->emailSend("objednavky@kupitbitcoin.sk",$_SESSION["order"]["email"],"BUYSELL",$mailMessage);
		$help->emailSend("objednavky@kupitbitcoin.sk","orders.buysellbitcoin@gmail.com","Nová objednávka",$adminMessage);
  }
}else{
	$response_array['status'] = 'error'; 
}
header('Content-type: application/json');
echo json_encode($response_array);
?>