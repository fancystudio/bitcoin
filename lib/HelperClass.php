<?php  
class Helper
{
	private $db;
	private $testUrl = "https://ib.trustpay.eu/mapi/pay.aspx";
	private $secretKey = "zIytYkNC4dNTenlupcLPa9cPkWZ6LYN9";
	private $aid = 2107889048;
	
	public function __construct($config) {
		try{  
			$this->db = new PDO("mysql:host=".$config['db_hostname'].";port=".$config['db_port'].";unix_socket=/tmp/mariadb55.sock;dbname=".$config['db_name'], $config['db_username'], $config['db_password']);
			$this->db->exec("SET CHARACTER SET utf8");
		}catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
  			$this->db->rollBack();
		}
    }
	
	public function xmlPart($name,$id,$value,$orderBy){
		$xml = '<field id="'.$id.'" ';
		$xml .= 'type="TextField" ';
		$xml .= 'validation_type="none" ';
		$xml .= 'order_by="'.$orderBy.'" ';
		$xml .= 'required="1" ';
		$xml .= 'hide_label="0" ';
		$xml .= 'display_in_submission="1">';
		$xml .= '<field_name><![CDATA['.$name.']]></field_name>';
		$xml .= '<options>';
		$xml .= '<option name="text"><![CDATA[]]></option>';
		$xml .= '<option name="field_alias"><![CDATA[]]></option>';
		$xml .= '<option name="css_class"><![CDATA[]]></option>';
		$xml .= '<option name="helptext"><![CDATA[]]></option>';
		$xml .= '<option name="javascript"><![CDATA[]]></option>';
		$xml .= '<option name="field_logic"><![CDATA[]]></option>';
		$xml .= '<option name="is_valid"><![CDATA[1]]></option>';
		$xml .= '<value><![CDATA['.$value.']]></value>';
		$xml .= '</options>';
		$xml .= '<human_readable_value><![CDATA['.$value.']]></human_readable_value>';
		$xml .= '</field>';
		return $xml;
	}
	public function checkTypeOfSellTransaction($typeOfSellTransaction){
		$checkValueOfSellTransaction = false;
		if($typeOfSellTransaction == "classic" ||
			$typeOfSellTransaction == "card"){
				$checkValueOfSellTransaction = true;
		}
		return $checkValueOfSellTransaction;
	}
	public function checkFirstStep($typeOfTransaction, $valueOfTransactionFrom, $valueOfTransactionTo){
		$checkValueOfTransactionFrom = false;
		$checkValueOfTransactionTo = false;
		$checkTypeOfTransaction = false;
		if(is_numeric($valueOfTransactionTo) || !$valueOfTransactionTo){
			$checkValueOfTransactionTo = true;
		}
		if(is_numeric($valueOfTransactionFrom)){
			$checkValueOfTransactionFrom = true;
		}
		if($typeOfTransaction == "buy" || 
			$typeOfTransaction == "card"){
				$checkTypeOfTransaction = true;
		}
		return $checkValueOfTransactionFrom && $checkValueOfTransactionTo && $checkTypeOfTransaction;
	}
	public function checkSecondStep($email,$meno,$priezvisko,$cisloPenazenky,$cisloUctu,$adresaZKtorejSaPosiela,$typTransakcie){
		$checkEmail = false;
		$checkWalletNumber = false;
		$checkAccountNumber = false;
		$checkAdresaZKtorejSaPosiela = false;
		if (preg_match('/^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})$/', $email)) {
 			$checkEmail = true;
		}
		if($cisloPenazenky != ""){
			$checkWalletNumber = true;
		}
		$splitCisloUctu = explode("/", $cisloUctu);
		if(preg_match('/^\d+$/', $splitCisloUctu[0]) && preg_match('/^\d+$/', $splitCisloUctu[1]) 
			|| $cisloUctu != ""){
			$checkAccountNumber = true;
		}
		if($adresaZKtorejSaPosiela != ""){
			$checkAdresaZKtorejSaPosiela = true;
		}
		if($typTransakcie == "buy"){
			$checkWalletNumber = true;
		}else{
			$checkAccountNumber = true;
			$checkAdresaZKtorejSaPosiela = true;
		}
		return $checkEmail && $checkWalletNumber && $checkAccountNumber && $checkAdresaZKtorejSaPosiela;
	}
	public function checkSecondStepSepa($clientEmailValue,$menoNazovSepa,$ulicaSepa,$mestoSepa,$smerovacieCisloSepa,$ibanSepa,$swiftBicSepa,$clientAdresaZKtorejSaPosielaValue){
		$checkClientEmailValue = false;
		$checkMenoNazovSepa = false;
		$checkUlicaSepa = false;
		$checkMestoSepa = false;
		$checkSmerovacieCisloSepa = false;
		$checkIbanSepa = false;
		$checkSwiftBicSepa = false;
		$checkClientAdresaZKtorejSaPosielaValue = false;
		if (preg_match('/^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})$/', $clientEmailValue)) {
 			$checkClientEmailValue = true;
		}
		if($menoNazovSepa != ""){
			$checkMenoNazovSepa = true;
		}
		if($ulicaSepa != ""){
			$checkUlicaSepa = true;
		}
		if($mestoSepa != ""){
			$checkMestoSepa = true;
		}
		if($smerovacieCisloSepa != ""){
			$checkSmerovacieCisloSepa = true;
		}
		if($ibanSepa != ""){
			$checkIbanSepa = true;
		}
		if($swiftBicSepa != ""){
			$checkSwiftBicSepa = true;
		}
		if($clientAdresaZKtorejSaPosielaValue != ""){
			$checkClientAdresaZKtorejSaPosielaValue = true;
		}
		return $checkClientEmailValue && $checkMenoNazovSepa && $checkUlicaSepa && $checkMestoSepa && $checkSmerovacieCisloSepa && $checkIbanSepa && $checkSwiftBicSepa && $checkClientAdresaZKtorejSaPosielaValue;
	}
	public function insertOrder($xml,$cisloObjednavky,$amt){
		try{
			$insert = $this->db->prepare("INSERT INTO cms_module_fb_formbrowser (form_id, feuid, response, user_approved, secret_code, submitted, admin_approved) VALUES (?,?,?,?,?,?,?)");
			$insert->execute(array(4, -1, $xml, null, $cisloObjednavky, date("Y-m-d H:i:s"), null));
			return true;		
		}catch(Exception $e) {
			return false;
		}
	}
	public function getSumValue($value,$isSellSide,$isReadOnly,$bitcoinValue,$dolarCurrency,$currency){
		try{
			$sumValue = array();
			$sumValue["value"] = 0;
			$kDispozicii = null;
			$eurBitcoinValue = floatval($bitcoinValue) / floatval($dolarCurrency);
			$select = $this->db->prepare("SELECT * from cms_module_editaciacien where id = 1");
			$select->execute();
			while ($row = $select->fetch(PDO::FETCH_OBJ)){
				if($isSellSide == "true"){
					if($isReadOnly == "false"){
							$sumValue["value"] = (1+($row->mara_v_Percent_na_predaj / 100)) * $eurBitcoinValue;
							$sumValue["value"] = $value/$sumValue["value"];
							$sumValue["value"] = round($sumValue["value"],6);
						}else{
							$sumValue["value"] = $value*($eurBitcoinValue);
							$sumValue["value"] += ($row->mara_v_Percent_na_predaj / 100) * $sumValue["value"];
							$sumValue["value"] = round($sumValue["value"],2);
					}
					$kDispozicii = $row->btc_k_dispozci_na_predaj/$currency["predaj"];
				}else{
					if($isReadOnly == "false"){
						$sumValue["value"] = $value*($eurBitcoinValue);
						$sumValue["value"] -= ($row->mara_v_Percent_na_nkup / 100) * $sumValue["value"];
						$sumValue["value"] = round($sumValue["value"],2);
					}else{
						$sumValue["value"] = (1-($row->mara_v_Percent_na_nkup / 100)) * $eurBitcoinValue;
						$sumValue["value"] = $value/$sumValue["value"];
						$sumValue["value"] = round($sumValue["value"],6);
					}
          $kDispozicii = $row->EUR_k_dispozci_na_nkup;
				}
	  	}
      //echo $kDispozicii;
			if($sumValue["value"] == null || $kDispozicii == null){
				$sumValue["status"] = "error";
				$sumValue["value"] = $value;
        
			}elseif((($isReadOnly == "false") ? $sumValue["value"] : $value) > $kDispozicii){
        
				$sumValue["status"] = "moreThan";
				$sumValue["value"] = $value;
			}else{
				$sumValue["status"] = "success";
				$sumValue["value"] = $sumValue["value"];
			}
			return $sumValue;		
		}catch(Exception $e) {
			$sumValue["status"] = "error";
			$sumValue["value"] = $value;
		    return $sumValue;
		}
	}
public function getCurrency($bitcoin,$usdCurrency){
		$currency = array();
		$bitcoinValue = $bitcoin["last"];
		//$bitcoinValue = floatval($bitcoin);
		$dolarCurrency = $usdCurrency;
		$currency["nakup"] = floatval($bitcoinValue)/floatval($dolarCurrency);
		$currency["predaj"] = floatval($bitcoinValue)/floatval($dolarCurrency);
		$select = $this->db->prepare("SELECT mara_v_Percent_na_nkup, mara_v_Percent_na_predaj from cms_module_editaciacien where id = 1");
		$select->execute();
		$marzaIsSet = false;
		while ($row = $select->fetch(PDO::FETCH_OBJ)){
			$currency["nakup"] -= ($row->mara_v_Percent_na_nkup / 100) * $currency["nakup"];
			$currency["nakup"]= round($currency["nakup"],2);
			$currency["predaj"] = (1+($row->mara_v_Percent_na_predaj / 100)) * $currency["predaj"];
			$currency["predaj"]= round($currency["predaj"],2);
			$marzaIsSet = true;
	    }
	    if($marzaIsSet){
	    	$currency["status"] = "success"; 
	    }else{
	    	$currency["status"] = "error";
	    }
		return $currency;
	}
	public function getTrustPayMessage($ref,$amt){
		return $this->aid . $amt . "EUR"  . $ref;
	}
	public function getUrlToTrustPay($ref,$amt){
		$message = $this->getTrustPayMessage($ref,$amt);
		$query = array(
			"AID" => $this->aid,
		 	"AMT" => floatval($amt),
			"CUR" => "EUR",
			"REF" => $ref,
			"SIG" => $this->getSign($message)
		);
		return $this->testUrl.'?'.http_build_query($query);
	}
	function getSign($message) { 
		return strtoupper(hash_hmac('sha256', pack('A*', $message), pack('A*', $this->secretKey))); 
	}
	function refreshOrderAfterTrustPay($sig){
    $newXml= "";
		$select = $this->db->prepare('SELECT response from cms_module_fb_formbrowser where secret_code = ?');
		$select->execute(array($sig));
		while ($row = $select->fetch(PDO::FETCH_OBJ)){
			$newXml = str_replace("Trust Pay", "Trust Pay - uhradene", $row->response);
			$update = $this->db->prepare("UPDATE cms_module_fb_formbrowser SET response = ? where secret_code = ?");
           	$update->execute(array($newXml,$sig));
    	}
	}
	public function emailSend($from,$to,$subject,$message){
	   	mail($to,$subject,$message,"From:".$from." \r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n");
	}
	public function orderStatusProcess($type, $idOrder, $value){
		if($type == "get"){
			$select = $this->db->prepare('SELECT order_status from cms_module_fb_formbrowser where fbr_id = ?');
			$select->execute(array($idOrder));
			while ($row = $select->fetch(PDO::FETCH_OBJ)){
				return $row->order_status;
    		}
		}
		if($type == "set"){
			$update = $this->db->prepare("UPDATE cms_module_fb_formbrowser SET order_status = ? where fbr_id = ?");
           	if($update->execute(array($value, $idOrder))){
           		return true;
           	}
		}
		return null;
	}
	public function mailContructAndSend($orderData, $typeOfSellTransaction, $lang){
		$mailMessage = "";
		$adminMessage = "";
		if($orderData["typTransakcie"] == "card"){
	      if($typeOfSellTransaction == "classic"){
	      	if($lang == "sk_SK"){
	       		$mailMessage = "Dobrý deň,<br><br>
			      ďakujeme za Vašu objednávku #".$orderData["cisloObjednavky"].". Nižšie v tomto e-maile nájdete inštrukcie k platbe.<br><br>
			      <span style='font-weight:bold;text-decoration:underline'>Kupujete od nás Bitcoiny za ".$orderData["hodnotaTransakcieZ"]." Eur</span><br><br>
			      Pri aktuálnom kurze ".round($orderData["hodnotaTransakcieZ"]/$orderData["hodnotaTransakcieDo"],6)." Eur / 1 BTC, sume <span style='font-weight:bold'>".$orderData["hodnotaTransakcieZ"]." Eur</span> zodpovedá počet bitcoinov: <span style='font-weight:bold'>".$orderData["hodnotaTransakcieDo"]." BTC</span>. 
			      Tento počet je však len orientačný. Výsledný počet bude vypočítaný rovnakým spôsobom podľa kurzu platného okamihu pripísania platby na náš účet, viz naše obchodné podmienky.<br><br> 
			      Pre dokončenie transakcie prosím odošlite platbu na náš účet.<br><br>
			      <span style='font-weight:bold'>Pre prevod zo <span style='text-decoration:underline'>Slovenskej republiky:</span></span><br><br>
			      Suma: <span style='font-weight:bold'>".$orderData["hodnotaTransakcieZ"]." EUR</span><br>
					Účet:  <span style='font-weight:bold'>1222314018/1111</span><br>
					Variabilný symbol:  <span style='font-weight:bold'>".$orderData["cisloObjednavky"]."  (povinné)</span><br>
					Informácia pre príjemcu pri elektronickom prevode:   <span style='font-weight:bold'>„Platim za bitcoin z <span style='text-decoration:underline'>kupitbitcoin.sk</span>“   (povinné)</span><br><br>
					Informácia pre príjemcu pri osobnom vklade na účet je:   <span style='font-weight:bold'>„Platim za bitcoin“   (povinné)</span><br><br>
					<span style='text-decoration:underline'>Bez informácie pre príjemcu platba nebude akceptovaná a bude odoslaná späť.</span><br><br>
					Bez variabilného symbolu nemusí byť Vaša platba zaznamenaná.<br><br>
					<span style='font-weight:bold'>Pre prevod z <span style='text-decoration:underline'>Českej republiky:</span></span><br><br>
					Názov:   AVERLON INTERNATIONAL CORP<br><br><br>
					Adresa:  Trnavá Hora 210, Žiar nad Hronom  96611<br><br>
					Suma: ".$orderData["hodnotaTransakcieZ"]." EUR<br>
					IBAN: SK4711110000001222314018<br>
					BIC(SWIFT): UNCRSKBX<br>
		      Variabilný symbol:  <span style='font-weight:bold'>".$orderData["cisloObjednavky"]."  (povinné)</span><br>
					Informácia pre príjemcu:   <span style='font-weight:bold'>„Platim za bitcoin z <span style='text-decoration:underline'>kupitbitcoin.sk</span>“   (povinné)</span><br><br>
					<span style='text-decoration:underline'>Bez informácie pre príjemcu platba nebude akceptovaná a bude odoslaná späť.</span><br><br>
					Bez variabilného symbolu nemusí byť Vaša platba zaznamenaná.<br><br>
					Ihneď po prijatí platby Vám obratom zašleme Bitcoiny do peňaženky ".$orderData["cisloPenazenky"]."<br><br>
					 Táto transakcia je platná do 48 hodín, preto prosím neodkladajte platbu. Ak platba do tejto
					 doby nedorazí, bude zámena zrušená.<br><br><br> 
			      Ďakujeme za Vašu dôveru a tešíme sa na ďalšiu spoluprácu.<br><br>
			      Tím Buysell Bitcoin<br><br>
				<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
	      }elseif($lang == "en_US"){
	      		$mailMessage = "Dear Sir or Madam,<br><br>
			      thank you for your order #".$orderData["cisloObjednavky"].".<br><br>
			      You are buying Bitcoin in value <span style='font-weight:bold'>".$orderData["hodnotaTransakcieZ"]." Eur.</span><br><br>
			      According to the current exchange rate ".round($orderData["hodnotaTransakcieZ"]/$orderData["hodnotaTransakcieDo"],6)." Eur / 1 BTC, amount in Bitcoin is <span style='font-weight:bold'>".$orderData["hodnotaTransakcieDo"]." BTC</span>. 
			      This amount is only informative. The resulting amount will be calculated at the time of receipt of payment to our account according to the current exchange rate, see sales conditions.<br><br> 
			      To complete the order send payment to our bank account.
			      Immediately after receipt of payment we will send Bitcoin to your wallet <span style='font-weight:bold'>".$orderData["cisloPenazenky"]."</span><br><br>
			      Transfer amount to this account:<br><br>
			      <span style='font-weight:bold'>Account owner: </span>AVERLON INTERNATIONAL CORP.<br>
			      Address: Trnava Hora 210<br>
				  City: Ziar nad Hronom<br>
				  Country: Slovakia<br><br>
			      <span style='font-weight:bold'>Bank name: </span>UniCredit Bank Czech republic and Slovakia<br><br>
			      Address: Namestie SNP 50<br>
				  City: Zvolen<br>
				  Country: Slovakia<br><br>
				  Amount: <span style='font-weight:bold'>".$orderData["hodnotaTransakcieZ"]." EUR</span><br>
				  IBAN: <span style='font-weight:bold'>SK4711110000001222314018</span><br>
				  BIC(SWIFT): <span style='font-weight:bold'>UNCRSKBX</span><br>
				  Variable symbol: <span style='font-weight:bold'>1401034400 (required)</span><br>
				  Message to the recipient: <span style='font-weight:bold'>„Payment for Bitcoin“ (required)</span><br><br>
				  <span style='font-weight:bold'>Without message for recipient payment will be not accepted and will send back.</span><br><br> 
				  This order is valid 3 business days, so do not delay payment. If the payment is not received, order will be canceled.<br><br>
				  Thank you for your confidence,<br><br>
				  best regards team BuySell Bitcoin.<br><br>
				<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
	      }
	      $adminMessage = "Kúpenie bitcoinu: ".$orderData["hodnotaTransakcieZ"]." EUR -> ".$orderData["hodnotaTransakcieDo"]." BTC<br>
		      	Platobná metóda: prevod<br>
		      	Mail objednávajúceho: ".$orderData["email"]."<br>
		      	Adresa peňaženky: ".$orderData["cisloPenazenky"]; 
	    }else{
	      if($lang == "sk_SK"){
	      	$mailMessage = "Dobrý deň,<br><br>
		      ďakujeme za Vašu objednávku #".$orderData["cisloObjednavky"].".<br>
		      <span style='font-weight:bold;text-decoration:underline'>Kupujete od nás Bitcoiny za ".$orderData["hodnotaTransakcieZ"]." Eur</span><br><br>
		      Pri aktuálnom kurze ".round($orderData["hodnotaTransakcieZ"]/$orderData["hodnotaTransakcieDo"],6)." Eur / 1 BTC, sume <span style='font-weight:bold'>".$orderData["hodnotaTransakcieZ"]." Eur</span> zodpovedá počet bitcoinov: <span style='font-weight:bold'>".$orderData["hodnotaTransakcieDo"]." BTC</span>. 
		      Tento počet je však len orientačný. Výsledný počet bude vypočítaný rovnakým spôsobom podľa kurzu platného okamihu pripísania platby na náš účet, viz naše obchodné podmienky.<br><br> 
		      Pre dokončenie transakcie prosím odošlite platbu cez platobnú bránu TrustPay.<br><br>
				Ihneď po prijatí platby Vám obratom zašleme Bitcoiny do peňaženky ".$orderData["cisloPenazenky"]."<br><br>
				 Táto transakcia je platná 1 hodinu, preto prosím neodkladajte platbu. Ak platba do tejto
				 doby nedorazí, bude zámena zrušená.<br><br><br> 
		      Ďakujeme za Vašu dôveru a tešíme sa na ďalšiu spoluprácu.<br><br>
		      Tím Buysell Bitcoin<br><br>
			<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
	      	}elseif($lang == "en_US"){
	      		$mailMessage = "Dear Sir or Madam,<br><br>
		     thank you for your order #".$orderData["cisloObjednavky"].".<br><br>
		      <span style='font-weight:bold'>You are buying Bitcoin in value ".$orderData["hodnotaTransakcieZ"]." Eur</span><br><br>
		      According to the current exchange rate ".round($orderData["hodnotaTransakcieZ"]/$orderData["hodnotaTransakcieDo"],6)." Eur / 1 BTC, amount in Bitcoin is <span style='font-weight:bold'>".$orderData["hodnotaTransakcieDo"]." BTC</span>. 
		      This amount is only informative. The resulting amount will be calculated at the time of receipt of payment to our account according to the current exchange rate, see sales conditions.<br><br> 
		      To complete the order send payment through the payment gateway TrustPay.<br>
				Immediately after receipt of payment we will send Bitcoin to your wallet ".$orderData["cisloPenazenky"]."<br><br>
				Thank you for your confidence,<br><br> 
		      best regards team BuySell Bitcoin.<br><br>
			<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
	      	}
	      $adminMessage = "Kúpenie bitcoinu: ".$orderData["hodnotaTransakcieZ"]." EUR -> ".$orderData["hodnotaTransakcieDo"]." BTC<br>
	      	Platobná metóda: trustpay<br>
	      	Mail objednávajúceho: ".$orderData["email"]."<br>
	      	Adresa peňaženky: ".$orderData["cisloPenazenky"];  
	      
	    }		
		}else if($orderData["typTransakcie"] == "buy"){
  		  $sepaAccount = "(SEPA):";
  			if($lang == "en_US"){
  			if($orderData["isSepa"] == "true"){
	  			$sepaAccount .= "Name / Title: ".$orderData["menoNazovSepa"].", ";
	  			$sepaAccount .= "Street: ".$orderData["ulicaSepa"].", ";
	  			$sepaAccount .= "City: ".$orderData["mestoSepa"].", ";
	  			$sepaAccount .= "Postcode: ".$orderData["smerovacieCisloSepa"].", ";
	  			$sepaAccount .= "IBAN: ".$orderData["ibanSepa"].", ";
	  			$sepaAccount .= "Swift/BIC: ".$orderData["swiftBicSepa"];
	  		}
	  		$mailMessage = "Dear Sir or Madam,<br><br>
			thank you for your order #".$orderData["cisloObjednavky"].".<br><br>
			<span style='font-weight:bold;text-decoration:underline'>You are selling ".$orderData["hodnotaTransakcieZ"]." BTC.</span><br><br>  
			According to the current exchange rate ".round($orderData["hodnotaTransakcieDo"]/$orderData["hodnotaTransakcieZ"],2)." Eur / 1 BTC amount <span style='font-weight:bold'>".$orderData["hodnotaTransakcieZ"]." BTC is ".$orderData["hodnotaTransakcieDo"]." Eur.</span> 
			This amount is only informative. The resulting amount will be calculated at the time of receipt of payment to our account according to the current exchange rate, see sales conditions.<br><br>
			To complete the order send Bitcoins to our wallet<br>
			<span style='font-weight:bold'>18qchJtQHTWg8rsbZbhw5Mz5qXKQcR7R5M</span><br><br>
			<span style='font-weight:bold'>You have to send Bitcoin from address of wallet, which you filled in the order, by reason of a credible recording.</span><br><br>
			Immediately after receipt of Bitcoin we will send money to your account:<br>".(($orderData["isSepa"] == "true") ? $sepaAccount : $orderData["cisloUctu"] )."<br><br>
			This order is valid until 4 hours from the time of making the order, so please do not delay to send Bitcoins.<br><br>
			Thank yor for confidence,<br><br>
			best regards, team BuySell Bitcoin.<br><br>
			<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
	  	}elseif($lang == "sk_SK"){
	  		if($orderData["isSepa"] == "true"){
	  			$sepaAccount .= "meno/nazov: ".$orderData["menoNazovSepa"].", ";
	  			$sepaAccount .= "ulica: ".$orderData["ulicaSepa"].", ";
	  			$sepaAccount .= "mesto: ".$orderData["mestoSepa"].", ";
	  			$sepaAccount .= "smerovacie cislo: ".$orderData["smerovacieCisloSepa"].", ";
	  			$sepaAccount .= "iban: ".$orderData["ibanSepa"].", ";
	  			$sepaAccount .= "swift bic: ".$orderData["swiftBicSepa"];
	  		}
	  		$mailMessage = "Dobrý deň,<br><br>
			ďakujeme za Vašu objednávku ".$orderData["cisloObjednavky"].".Nižšie v tomto e-maile nájdete inštrukcie k prevodu Bitcoinov.<br>
			<span style='font-weight:bold;text-decoration:underline'>Predávate nám ".$orderData["hodnotaTransakcieZ"]." BTC.</span><br><br>  
			Pri aktuálnom kurze ".round($orderData["hodnotaTransakcieDo"]/$orderData["hodnotaTransakcieZ"],2)." Eur / 1 BTC počtu ".$orderData["hodnotaTransakcieZ"]." BTC zodpovedá suma: ".$orderData["hodnotaTransakcieDo"]." Eur. 
			Táto suma je však len orientačná. Výsledná suma bude vypočítaná rovnakým spôsobom podľa kurzu platného okamihu pripísania platby do našej peňaženky, viz naše obchodné podmienky.<br><br>
			Pre dokončenie transakcie prosím odošlite Bitcoiny z vašej peňaženky ".$orderData["adresaZKtorejSaPosiela"]." do našej peňaženky <span style='font-weight:bold'>18qchJtQHTWg8rsbZbhw5Mz5qXKQcR7R5M</span><br><br>
			Je nutné aby ste Bitcoiny odoslali z peňaženky ktorú ste uviedli v objednávke, z dôvodu jej dôveryhodného zaznamenania.<br><br>
			Ihneď po prijatí Bitcoinov Vám obratom pošleme Eurá na Váš účet ".(($orderData["isSepa"] == "true") ? $sepaAccount : $orderData["cisloUctu"] )."<br><br>
			Táto transakcia je platná do 4 hodín od zadania objednávky, preto prosím neodkladajte platbu. Ak platba dorazí po tejto dobe nemusí byt zrealizovaná. Ak by zrealizovaná z tohto dôvodu nebola, Bitcoiny Vám budú zaslané späť, znížené o poplatok pre minera 0.005 BTC.<br><br>
			Ďakujeme za Vašu dôveru a tešíme sa na ďalšiu spoluprácu.<br><br>
			Tím Buysell Bitcoin<br><br>
			<img src='http://www.kupitbitcoin.sk/img/logo.png' width='210' height='59' />";
	  		
	  	}
	  	$adminMessage = "Predaj bitcoinu: ".$orderData["hodnotaTransakcieZ"]." BTC -> ".$orderData["hodnotaTransakcieDo"]." EUR<br>
      	Mail objednávajúceho: ".$orderData["email"];
	  }
	  if(count($mailMessage) > 0){
	  	$adminMessage .= "<br>Jazyk zvolený pri objednávke: ".$lang;
		$this->emailSend("objednavky@kupitbitcoin.sk",$orderData["email"],"BUYSELL",$mailMessage);
		$this->emailSend("objednavky@kupitbitcoin.sk","orders.buysellbitcoin@gmail.com","Nová objednávka",$adminMessage);
	  }
	}
	
	public static function getTranslate($lang){
		$langString = array();
		
		$langString["sk_SK"]["okazite"] = "Okamžité";
		$langString["sk_SK"]["bankove"] = "bankové";
		$langString["sk_SK"]["prevody"] = "prevody";
		$langString["sk_SK"]["dispnapredaj"] = "k dispozícií na predaj";
		$langString["sk_SK"]["niejespravne"] = "Pole nie je vyplnené správne";
		$langString["sk_SK"]["kupitbitcoin"] = "Kúpiť Bitcoin";
		$langString["sk_SK"]["predatbitcoin"] = "Predať Bitcoin";
		$langString["sk_SK"]["bitcoinzmenaren"] = "bitcoin zmenáreň";
		$langString["sk_SK"]["dispnanakup"] = "k dispozícií na nákup";
		$langString["sk_SK"]["objednavkovyformular"] = "Objednávkový formulár";
		$langString["sk_SK"]["krajina"] = "Krajina";
		$langString["sk_SK"]["srepublika"] = "Slovenská Republika";
		$langString["sk_SK"]["crepublika"] = "Česká Republika";
		$langString["sk_SK"]["email"] = "Email";
		$langString["sk_SK"]["emailniejespravne"] = "Email nie je vyplnený správne";
		$langString["sk_SK"]["meno"] = "Meno";
		$langString["sk_SK"]["nepovinne"] = "nepovinné";
		$langString["sk_SK"]["menomusivyplnene"] = "Meno musí byť vyplnené";
		$langString["sk_SK"]["priezvisko"] = "Priezvisko";
		$langString["sk_SK"]["priezviskomusivyplnene"] = "Priezvisko musí byť vyplnené";
		$langString["sk_SK"]["cislopenazenky"] = "Číslo penaženky";
		$langString["sk_SK"]["polemusivyplnene"] = "Pole musí byť vyplnené";
		$langString["sk_SK"]["niejespravne"] = "Pole nie je vyplnené správne";
		$langString["sk_SK"]["cislouctu"] = "Číslo účtu";
		$langString["sk_SK"]["zadavajtevoformate"] = "Zadávajte vo formáte";
		$langString["sk_SK"]["adresabtcposielate"] = "Adresa z ktorej BTC posielate";
		$langString["sk_SK"]["menonazov"] = "Meno/Názov";
		$langString["sk_SK"]["vlastnikuctu"] = "vlastníka účtu";
		$langString["sk_SK"]["ulica"] = "Ulica";
		$langString["sk_SK"]["mesto"] = "Mesto";
		$langString["sk_SK"]["smerovaciecislo"] = "Smerovacie číslo";
		$langString["sk_SK"]["iban"] = "IBAN";
		$langString["sk_SK"]["swiftbic"] = "Swift/BIC";
		$langString["sk_SK"]["potvrdenieobj"] = "Potvrdenie objednávky";
		$langString["sk_SK"]["skontrolujteudaje"] = "Skontrolujte údaje";
		$langString["sk_SK"]["vasemeno"] = "Vaše meno";
		$langString["sk_SK"]["vasepriezvisko"] = "Vaše priezvisko";
		$langString["sk_SK"]["vasemail"] = "Váš email";
		$langString["sk_SK"]["vasecislopenazenky"] = "Vaše číslo penaženky";
		$langString["sk_SK"]["vasecu"] = "Vaše číslo účtu";
		$langString["sk_SK"]["cisloobj"] = "Číslo objednávky";
		$langString["sk_SK"]["vybspplatby"] = "Vyberte spôsob platby";
		$langString["sk_SK"]["sposobplatby"] = "Spôsob platby";
		$langString["sk_SK"]["bankovymprevodom"] = "Bankovým prevodom";
		$langString["sk_SK"]["spravapreprijemcu"] = "do správy pre príjemcu uvedťe: ";
		$langString["sk_SK"]["platimzabitcoin"] = "Platím za bitcoin z kupitbitcoin.sk";
		$langString["sk_SK"]["vyplntecaptchu"] = "Vyplnte captchu";
		$langString["sk_SK"]["zadajtehodnotuzobr"] = "Zadajte hodnotu z obrázku";
		$langString["sk_SK"]["vymenitobr"] = "Vymeniť obrázok";
		$langString["sk_SK"]["finalizacia"] = "Finalizácia";
		$langString["sk_SK"]["transakciaspracovana"] = "Vaša transakcia bola úspešne spracovaná";
		$langString["sk_SK"]["emailsinstrukciami"] = "V krátkej dobe obdržíte email s platobnými inštrukciami";
		$langString["sk_SK"]["uvodstranka"] = "Spať na úvodnú stránku";
		$langString["sk_SK"]["spat"] = "Spať";
		$langString["sk_SK"]["pokrvobj"] = "Pokračovať v objednávke";
		$langString["sk_SK"]["predaj"] = "predaj";
		$langString["sk_SK"]["nakup"] = "nákup";
		$langString["sk_SK"]["odoslatobjednavku"] = "Odoslať objednávku";
		$langString["sk_SK"]["okamziteprevody"] = "Okamžité bankové prevody";
		$langString["sk_SK"]["napistenam"] = "Napíšte nám";
		$langString["sk_SK"]["vasasprava"] = "Vaša správa";
		$langString["sk_SK"]["odoslat"] = "Odoslať";
		$langString["sk_SK"]["kontaktniejespravne"] = "Prosím skontrolujte či ste vyplnili všetky polia";
		$langString["sk_SK"]["kontaktodoslany"] = "Správa bola úspešne odoslaná";
		
		//en
		$langString["en_US"]["okazite"] = "Instant";
		$langString["en_US"]["bankove"] = "bank";
		$langString["en_US"]["prevody"] = "transfers";
		$langString["en_US"]["dispnapredaj"] = "available for sale";
		$langString["en_US"]["niejespravne"] = "Field isn´t filled out correctly";
		$langString["en_US"]["kupitbitcoin"] = "Buy Bitcoin";
		$langString["en_US"]["predatbitcoin"] = "Sell Bitcoin";
		$langString["en_US"]["bitcoinzmenaren"] = "bitcoin exchange";
		$langString["en_US"]["dispnanakup"] = "available for purchase";
		$langString["en_US"]["objednavkovyformular"] = "Order Form";
		$langString["en_US"]["krajina"] = "Country";
		$langString["en_US"]["srepublika"] = "Slovak Republic";
		$langString["en_US"]["crepublika"] = "Other european country";
		$langString["en_US"]["email"] = "Email";
		$langString["en_US"]["emailniejespravne"] = "Email isn´t filled out correctly";
		$langString["en_US"]["meno"] = "Name";
		$langString["en_US"]["nepovinne"] = "optional";
		$langString["en_US"]["menomusivyplnene"] = "Name must be filled";
		$langString["en_US"]["priezvisko"] = "Last name";
		$langString["en_US"]["priezviskomusivyplnene"] = "Last name must be filled";
		$langString["en_US"]["cislopenazenky"] = "Bitcoin address";
		$langString["en_US"]["polemusivyplnene"] = "Field must be filled";
		$langString["en_US"]["cislouctu"] = "Account number";
		$langString["en_US"]["zadavajtevoformate"] = "Accepted format";
		$langString["en_US"]["adresabtcposielate"] = "Address from which you send BTC";
		$langString["en_US"]["menonazov"] = "Name/Title";
		$langString["en_US"]["vlastnikuctu"] = "Account holder";
		$langString["en_US"]["ulica"] = "Street";
		$langString["en_US"]["mesto"] = "City";
		$langString["en_US"]["smerovaciecislo"] = "Postcode";
		$langString["en_US"]["iban"] = "IBAN";
		$langString["en_US"]["swiftbic"] = "Swift/BIC";
		$langString["en_US"]["potvrdenieobj"] = "Confirmation of order";
		$langString["en_US"]["skontrolujteudaje"] = "Check the data";
		$langString["en_US"]["vasemeno"] = "Your name";
		$langString["en_US"]["vasepriezvisko"] = "Your last name";
		$langString["en_US"]["vasemail"] = "Your email";
		$langString["en_US"]["vasecislopenazenky"] = "Your bitcoin address";
		$langString["en_US"]["vasecu"] = "Your account number";
		$langString["en_US"]["cisloobj"] = "Order No";
		$langString["en_US"]["vybspplatby"] = "Select a payment method";
		$langString["en_US"]["sposobplatby"] = "Method of payment";
		$langString["en_US"]["bankovymprevodom"] = "Bank transfer";
		$langString["en_US"]["spravapreprijemcu"] = "";
		$langString["en_US"]["platimzabitcoin"] = "";
		$langString["en_US"]["vyplntecaptchu"] = "Fill CAPTCHA";
		$langString["en_US"]["zadajtehodnotuzobr"] = "Enter the value from the image";
		$langString["en_US"]["vymenitobr"] = "Replace image";
		$langString["en_US"]["finalizacia"] = "Finalisation";
		$langString["en_US"]["transakciaspracovana"] = "Your transaction has been successfully processed";
		$langString["en_US"]["emailsinstrukciami"] = "In a short time you will receive an email with payment instructions";
		$langString["en_US"]["uvodstranka"] = "Back to homepage";
		$langString["en_US"]["spat"] = "Back";
		$langString["en_US"]["pokrvobj"] = "Continue with order";
		$langString["en_US"]["predaj"] = "we sell";
		$langString["en_US"]["nakup"] = "we buy";
		$langString["en_US"]["odoslatobjednavku"] = "Send order";
		$langString["en_US"]["okamziteprevody"] = "Instant bank transfers";
		$langString["en_US"]["napistenam"] = "Write to us";
		$langString["en_US"]["vasasprava"] = "Your message";
		$langString["en_US"]["odoslat"] = "Send";
		$langString["en_US"]["kontaktniejespravne"] = "Any of fields isn´t filled out correctly";
		$langString["en_US"]["kontaktodoslany"] = "Your message has been successfully processed";
		
		
		return $langString[$lang];
	}
}
?>