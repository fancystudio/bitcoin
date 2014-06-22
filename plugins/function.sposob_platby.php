<?php
function smarty_function_sposob_platby($params, &$template)
{
require_once('lib/order_process/resetProcess.php');
require_once('lib/HelperClass.php');
require_once("lib/bitstamp/bitstamp.php");
$vysuvacieokno = cmsms()->GetSmarty()->get_template_vars('vysuvacieokno');
$lavastranatext = cmsms()->GetSmarty()->get_template_vars('lavastranatext');
$pravastranatext = cmsms()->GetSmarty()->get_template_vars('pravastranatext');
$db = cmsms()->GetDb();
$eurKDispozicii = 0;
$BTCKDispozicii = 0;
$dbresult = $db->Execute('SELECT * from '.cms_db_prefix().
			     'module_editaciacien where id=?',array(1));
    while ($dbresult && $row=$dbresult->FetchRow()){
		$eurKDispozicii = $row['EUR_k_dispozci_na_nkup'];
		$BTCKDispozicii = $row['btc_k_dispozci_na_predaj'];
    }

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
  <div class="main-content-wrap">
  	<div id="panel">
    <div id="panelCaller"><img src="img/okamzite-prevody.png" />
    <br><?php echo $actualLang["okazite"] ?><br><?php echo $actualLang["bankove"] ?><br><?php echo $actualLang["prevody"] ?></div>
     
<?php
echo $vysuvacieokno
?>
    
    
  </div>
	<div class="container main-content">
		<form action="javascript:void(0)">
			<div class="swiper-container">
	  			<div class="swiper-wrapper">
	  		
	  			<!-- /////////////////////////////////////// first step //////////////////////////////////////// -->
	  			
	  				<div class="swiper-slide firstStep" data-hash="firstStep">
		  				<div class="col-md-5 lavy-predaj firstStepVisible">
							<div class="row available-info"><strong><?php echo round(($BTCKDispozicii/$currency["predaj"]),6) ?> BTC</strong> <?php echo $actualLang["dispnapredaj"] ?></div>
							<div class="row centered exchange-symbol"><img src="img/e-to-b.png" width="148" height="56"/></div>
							
							
							<div class="row">
								<div class="inputs currency">
									<div class="numbers-row">
										<input type="text" name="input 1" id="sell-online-card" class="text-input" value="0"/>
									</div>
									<span class="rovnasa">=</span>
									<div class="numbers-row">
										<input type="text" name=" " id="sell-online-card-info" class="text-input read-only " value="0"/>
									</div>
									
								</div>
								
									</div>
									<div>
										<span class="sell-online-card-notvalid buy-invalid"><?php echo $actualLang["niejespravne"] ?></span>
									</div>
									<div class="col-md-12 info-text column"><p><?php echo $lavastranatext ?></p></div>
									
									
		     						<div class="button-submit inputs form-horizontal">
										<input type="button" value="<?php echo $actualLang["kupitbitcoin"] ?>" id="card" class="main-btn sell-online-card sell-online-card-info disabled"/>
									
								
								
							</div>		
						</div><!--lavy-predaj-->
						<div class="col-md-2 stred-logo column">
							<img src="img/bitcoin-logo.png" width="142" height="142" alt="<?php echo $actualLang["bitcoinzmenaren"] ?>"/>
							<span class="whiteline a1"></span>
							<span class="whiteline a2"></span>
							<div class="stred-wrap"></div>
						</div>
						<div class="col-md-5 pravy-nakup firstStepVisible">
							<div class="row available-info"><strong><?php echo $eurKDispozicii ?> €</strong> <?php echo $actualLang["dispnanakup"] ?></div>
							<div class="row centered exchange-symbol">
								<img src="img/b-to-e.png" width="148" height="56"/>
							</div>
							<div class="row">
								<div class="inputs currency">
									<div class="numbers-row">
										<input tmaxlength="number" ype="text" name="input 1" id="buy-bitcoin" class="text-input" value="0"/>
									</div>
									<span class="rovnasa">=</span>
									<div class="numbers-row">
										<input type="text" name=" " id="buy-bitcoin-info" class="text-input read-only" value="0"/>
									</div>
									
									</div>
									
									</div>
									<div>
										<span class="buy-bitcoin-notvalid buy-invalid"><?php echo $actualLang["niejespravne"] ?></span>
									</div>
									<div class="col-md-12 info-text column"><p><?php echo $pravastranatext ?></p>
							</div>
									
									
									<div class="button-submit inputs form-horizontal">
										<input type="button" value="<?php echo $actualLang["predatbitcoin"] ?>" id="buy" class="main-btn buy-bitcoin buy-bitcoin-info disabled"/>
									
								
							</div>
						</div><!-- pravy-nakup -->
						<div style="dispaly:none" id="activeOrder" class=""></div>
					</div>
					
					
					<!-- /////////////////////////////////////// second step //////////////////////////////////////// -->
					
					<div class="swiper-slide secondStep" data-hash="secondStep">
					<h3><div class="typeOfServiceTitle"></div></h3>
					<div class="inputs col-md-12">
							<div class="formular-2-step">
							<div class="second-step-inputs secondStepVisible pull-left" style="display:none">
							<div class="stepTitle"><h4><?php echo $actualLang["objednavkovyformular"] ?></h4></div>
							<div class="stateSelect">
							<span class="rovnasa" style="clear:both"><?php echo $actualLang["krajina"] ?>: </span>
								<select name="stateSelect" class="form-control select-country">
									<!--<option value="">Vyberte krajinu…</option>-->
									<option value="sr"><?php echo $actualLang["srepublika"] ?></option>
									<option value="cz"><?php echo $actualLang["crepublika"] ?></option>
								</select>
							</div>
							<span class="rovnasa" style="clear:both"><?php echo $actualLang["email"] ?>: </span>
							<div class="text-row">
								<input type="text" name="" class="emailInput text-input col-md-3"/>
							</div>
							<div>
								<span class="emailInputValidation" style="display:none"><?php echo $actualLang["emailniejespravne"] ?></span>
							</div>
							<div class="menoClass">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["meno"] ?>: </span>
								<span class="account-info pull-left visible-xs"><?php echo $actualLang["nepovinne"] ?></span>
								<div class="text-row">
									<input type="text" name="" class="firstNameInput text-input" />
									<span class="account-info pull-left hidden-xs"><?php echo $actualLang["nepovinne"] ?></span>

								</div>
								<div>
									<span class="firstNameInputValidation" style="display:none"><?php echo $actualLang["menomusivyplnene"] ?></span>
								</div>
							</div>
							<div class="priezviskoClass">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["priezvisko"] ?>: </span>
								<span class="account-info pull-left visible-xs"><?php echo $actualLang["nepovinne"] ?></span>
								<div class="text-row">
									<input type="text" name="" class="lastNameInput text-input" />
									<span class="account-info pull-left hidden-xs"><?php echo $actualLang["nepovinne"] ?></span>
								</div>
								<div>
									<span class="lastNameInputValidation" style="display:none"><?php echo $actualLang["priezviskomusivyplnene"] ?></span>
								</div>
							</div>
							<div class="cisloPenazenky">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["cislopenazenky"] ?>: </span>
								<div class="text-row">
									<input type="text" name="cisloPenazenkyInput" class="cisloPenazenkyInput text-input" />
								</div>
								<div>
									<span class="numberInputValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							<div class="cisloUctu">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["cislouctu"] ?>: </span>
								<span class="account-info pull-left visible-xs cislo-uctu"><?php echo $actualLang["zadavajtevoformate"] ?> 0000000000/0000</span>
								<div class="text-row">
									<input type="text" name="" class="cisloUctuInput text-input" />
									<span class="account-info pull-left hidden-xs"><?php echo $actualLang["zadavajtevoformate"] ?> 0000000000/0000</span>
								</div>
								<div>
									<span class="numberInputValidation" style="display:none"><?php echo $actualLang["niejespravne"] ?></span>
								</div>
							</div>
							<div class="adresaZKtorejSaPosiela">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["adresabtcposielate"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="adresaZKtorejSaPosielaInput text-input" />
								</div>
								<div>
									<span class="adresaZKtorejSaPosielaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							 <div class="menoNazovSepa" style="display:none">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["menonazov"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="menoNazovSepaInput text-input" />
									<span class="account-info pull-left"><?php echo $actualLang["vlastnikuctu"] ?></span>
									
								</div>
								<div>
									<span class="menoNazovSepaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							<div class="ulicaSepa" style="display:none">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["ulica"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="ulicaSepaInput text-input" />
									<span class="account-info pull-left"><?php echo $actualLang["vlastnikuctu"] ?></span>
								</div>
								<div>
									<span class="ulicaSepaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							<div class="mestoSepa" style="display:none">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["mesto"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="mestoSepaInput text-input" />
									<span class="account-info pull-left"><?php echo $actualLang["vlastnikuctu"] ?></span>

								</div>
								<div>
									<span class="mestoSepaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							<div class="smerovacieCisloSepa" style="display:none">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["smerovaciecislo"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="smerovacieCisloSepaInput text-input" />
									<span class="account-info pull-left"><?php echo $actualLang["vlastnikuctu"] ?></span>
								</div>
								<div>
									<span class="smerovacieCisloSepaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							<div class="ibanSepa" style="display:none">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["iban"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="ibanSepaInput text-input" />
								</div>
								<div>
									<span class="ibanSepaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							<div class="swiftBicSepa" style="display:none">
								<span class="rovnasa" style="clear:both"><?php echo $actualLang["swiftbic"] ?>: </span>
								<div class="text-row">
									<input type="text" name="" class="swiftBicSepaInput text-input" />

								</div>
								<div>
									<span class="swiftBicSepaValidation" style="display:none"><?php echo $actualLang["polemusivyplnene"] ?></span>
								</div>
							</div>
							</div><!formular 2 step--></div>
							<div class="navigation">
	     					<div class="button-submit col-md-3 pull-right" style="clear:left">
								<input type="button" value="<?php echo $actualLang["pokrvobj"] ?>" id="goToThirdStep" class="main-btn pull-right"/>
							</div>
							<div class="button-submit col-md-3 pull-left">
								<input type="button" value="<?php echo $actualLang["spat"] ?>" id="backToFirstStep" class="main-btn"/>
							</div>
							</div><!-- navigation-->
						</div>
					</div>
					
					
					<!-- /////////////////////////////////////// third step //////////////////////////////////////// -->
					
					
					<div class="swiper-slide thirdStep" data-hash="thirdStep"> 
						<h3><div class="typeOfServiceTitle"></div></h3>
						
				<div class="inputs col-md-12">
				
					<div class="formular-2-step second-step-inputs">
						
						<div class="stepTitle"><h4><?php echo $actualLang["potvrdenieobj"] ?></h4></div>
						<div class="row">
						<div class="col-md-4">
						<h5>1. <?php echo $actualLang["skontrolujteudaje"] ?></h5>
						<div class="offset-second-step thirdStepVisible" style="display:none">
							<div class="clientFirstName">
								<span class="clientFirstNameTitle"><?php echo $actualLang["vasemeno"] ?>: </span>
								<span class="clientFirstNameValue"></span>
							</div>
							<div class="clientLastName">
								<span class="clientLastNameTitle"><?php echo $actualLang["vasepriezvisko"] ?>: </span>
								<span class="clientLastNameValue"></span>
							</div>
							<div class="clientEmail">
								<span class="clientEmailTitle"><?php echo $actualLang["vasemail"] ?>: </span>
								<span class="clientEmailValue"></span>
							</div>
							<div class="clientCisloPenazenky">
								<span class="clientCisloPenazenkyTitle"><?php echo $actualLang["vasecislopenazenky"] ?>: </span>
								<span class="clientCisloPenazenkyValue"></span>
							</div>
							<div class="clientCisloUctu">
								<span class="clientCisloUctuTitle"><?php echo $actualLang["vasecu"] ?>: </span>
								<span class="clientCisloUctuValue"></span>
							</div>
							<div class="clientHodnotaZ">
								<span class="clientHodnotaZTitle"></span>
								<span class="clientHodnotaZValue"></span>
							</div>
							<div class="clientHodnotaDo">
								<span class="clientHodnotaDoTitle"></span>
								<span class="clientHodnotaDoValue"></span>
							</div>
							<div class="clientAdresaZKtorejSaPosiela">
								<span class="clientAdresaZKtorejSaPosielaTitle"><?php echo $actualLang["adresabtcposielate"] ?>: </span>
								<span class="clientAdresaZKtorejSaPosielaValue"></span>
							</div>
							<div class="clientCisloObjednavky">
								<span class="clientCisloObjednavkyTitle"><?php echo $actualLang["cisloobj"] ?>: </span>
								<span class="clientCisloObjednavkyValue"></span>
							</div>
							<div class="clientMenoNazovSepa">
								<span class="clientMenoNazovSepaTitle"><?php echo $actualLang["menonazov"] ?>: </span>
								<span class="clientMenoNazovSepaValue"></span>
							</div>
							<div class="clientUlicaSepa">
								<span class="clientUlicaSepaTitle"><?php echo $actualLang["ulica"] ?>: </span>
								<span class="clientUlicaSepaValue"></span>
							</div>
							<div class="clientMestoSepa">
								<span class="clientMestoSepaTitle"><?php echo $actualLang["mesto"] ?>: </span>
								<span class="clientMestoSepaValue"></span>
							</div>
							<div class="clientSmerovacieCisloSepa">
								<span class="clientSmerovacieCisloSepaTitle"><?php echo $actualLang["smerovaciecislo"] ?>: </span>
								<span class="clientSmerovacieCisloSepaValue"></span>
							</div>
							<div class="clientIbanSepa">
								<span class="clientIbanSepaTitle"><?php echo $actualLang["iban"] ?>: </span>
								<span class="clientIbanSepaValue"></span>
							</div>
							<div class="clientSwiftBicSepa">
								<span class="clientSwiftBicSepaTitle"><?php echo $actualLang["swiftbic"] ?>: </span>
								<span class="clientSwiftBicSepaValue"></span>
							</div>
							</div><!--offset-second-step-->
						</div>
						
						
						<div class="col-md-4 sposobPlatby">
						<h5>2. <?php echo $actualLang["vybspplatby"] ?></h5>
						<div class="row radio-box">
							<p><strong><?php echo $actualLang["sposobplatby"] ?>:</strong></p>
								<ul class="list">
									<li>
					                  
					                  <label for="flat-radio-1" title="Tooltip on bottom">
					                  <input tabindex="15" type="radio" id="classic" name="flat-radio-sell" checked="checked" style="display:none">
					                  <?php echo $actualLang["bankovymprevodom"] ?>
					                  
					                  </label>
					                </li>
					                
					                
					                <p><?php echo $actualLang["spravapreprijemcu"] ?><strong><?php echo $actualLang["platimzabitcoin"] ?></strong></p>
					                <p></p>
					                <p></p>  
					                </br>
					                
					                <li>
					                <label for="flat-radio-2">
					                  <input tabindex="16" type="radio" id="card" name="flat-radio-sell" style="display:none">
					                  
					                  <!--<a href="#" style="display: block; position: relative; z-index: 999999;" data-toggle="tooltip" data-placement="bottom" rel="tooltip" title=" Slovenská sporiteľňa, VÚB, Tatra Banka, ČSOB, mBank, UNICREDIT, OTP, Poštová banka, Sberbank">-->
					                  <?php echo $actualLang["okamziteprevody"] ?>
					                  <p class="trustpay">TrustPay</p>
					                  <!--</a>--></label>
					                </li>
					                
					             
								</ul>
							</div>
						</div>	
						<div class="captcha col-md-4">
						<h5>3. <?php echo $actualLang["vyplntecaptchu"] ?></h5>	
						<div class="offset-second-step">					
							<div style="pull-left captcha-row" align="left" id="captchaResponse"></div>
							<font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo $actualLang["zadajtehodnotuzobr"] ?></font>
							<div class="vpb_captcha_wrappers captcha-row"><input id="vpb_captcha_code" name="vpb_captcha_code" type="text"></div>
							
							<!--<div style="pull-left captcha-row" align="left">Security Code:</div>-->
							<div style="pull-left captcha-row" align="left">
								<div class="vpb_captcha_wrapper captcha-row">
									<img src="lib/ajax_captcha/vasplusCaptcha.php?rand=1998691101" id='captchaimg' >
								</div>
								<div class="pull-left captcha-row">
									<font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">
										<span class="ccc">
											<a href="javascript:void(0);" onClick="vpb_refresh_aptcha();"><?php echo $actualLang["vymenitobr"] ?></a>
										</span>
									</font>
								</div>
							</div>						
						</div>	</div>	
						</div><!--row-->			
					</div>
							<div class="navigation">
		     					<div class="button-submit col-md-3 pull-right" style="clear:left">
									<input type="button" value="<?php echo $actualLang["odoslatobjednavku"] ?>" id="submitOrder" class="main-btn pull-right"/>
								</div>
								<div class="button-submit col-md-3 pull-left" style="clear:none">
									<input type="button" value="<?php echo $actualLang["spat"] ?>" id="backToSecondStep" class="main-btn" />
								</div>
							</div>
					
				</div>
				
				
							
				<!-- /////////////////////////////////////// fourth step //////////////////////////////////////// -->
				
					</div>
					<div class="swiper-slide fourthStep"  data-hash="fourthStep">
					<h3><div class="typeOfServiceTitle"><?php echo $actualLang["finalizacia"] ?></div></h3>
					<div class="inputs col-md-12">
							<div class="formular-2-step">
							<div class="second-step-inputs pull-left finalizacia">
							<div class="stepTitle"><h4><?php echo $actualLang["finalizacia"] ?></h4></div>
						<?php echo $actualLang["transakciaspracovana"] ?>. <br>
						<?php echo $actualLang["emailsinstrukciami"] ?>
						
						</div></div>
						<div class="navigation">
							<div class="button-submit col-md-3">
								<input type="button" value="<?php echo $actualLang["uvodstranka"] ?>" class="main-btn" onclick="location.href='index.php<?php echo ((CmsNlsOperations::get_current_language() == "sk_SK") ? "" : "?page=home_en" ) ?>';"/>
							</div>
						</div><!-- navigation-->
					</div>
					</div>
				</div>		
			</div>	
		</form>	
	</div><!--main-content-->
</div><!--main-content-wrap-->
  <?php
}
?>
