<?php
//1.ovalidovat polia
session_start();
$checkDbInsert = false;
$urlTotrustPay = "";
require_once '../../config.php';
require_once('../HelperClass.php');
$help = new Helper($config);
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
		$sumInfoToAdmin .= $_SESSION["order"]["hodnotaTransakcieZ"]." Eur -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." BTC";
		if($_POST["typeOfSellTransaction"] == "classic"){
			$typTransakcie = "€ -> BTC";
		}else{
			$typTransakcie = "€ -> BTC (Trust Pay)";
			$urlTotrustPay = $help->getUrlToTrustPay($_SESSION["order"]["cisloObjednavky"],$_SESSION["order"]["hodnotaTransakcieZ"]);
		}
		}else{
			$sumInfoToAdmin .= $_SESSION["order"]["hodnotaTransakcieZ"]." BTC -> ".$_SESSION["order"]["hodnotaTransakcieDo"]." Eur";
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
	$help->mailContructAndSend($_SESSION["order"], $_POST["typeOfSellTransaction"], $_POST["lang"]);
}else{
	$response_array['status'] = 'error'; 
}
header('Content-type: application/json');
echo json_encode($response_array);
?>