var validFirstStepAjax = false;
var swiperForm;
var typeOfTransaction;
var ajaxCounting = false;
$(document).ready(function(){	
    $("[rel='tooltip']").tooltip();
	var validFirstStep = false;
	var validSecondStep = false;
	swiperForm = new Swiper('.swiper-container',{
	    mode : 'horizontal',
	    simulateTouch : false,
	    followFinger : false,
	    calculateHeight : true,
	    autoResize : true,
	    resizeReInit : true,
	    createPagination : true
    });
    
	$('input').iCheck({
	    checkboxClass: 'icheckbox_flat',
	    radioClass: 'iradio_flat'
	});
	
	setTimeout('refreshCurrency()', 60000);
	
	//--------------------------------------------------------FIRST STEP----------------------------------------------------
		
	$(".firstStep .numbers-row").append('<div class="inc button">+</div><div class="dec button">-</div>');
	$(".firstStep .button").bind("click", function() {
		if(!ajaxCounting){
			ajaxCounting = true;
			validFirstStep = changeInputValueFirstStep(this,"button");
		}
	});
	$(".firstStep input").bind("keyup change", function(e) {
		this.value = this.value.replace(/[^0-9\.,]/g,'');     
		if(!ajaxCounting){
			ajaxCounting = true;
			validFirstStep = changeInputValueFirstStep(this,"input");
		}
	});
	$(".firstStep input[type='button']").click(function(){
		if(validFirstStep && validFirstStepAjax && !$(this).hasClass("disabled") && isMoreThanTenEur(this)){
			typeOfTransaction = $(this).attr("id");
			$("#activeOrder").removeClass();
			$("#activeOrder").addClass($(this).attr("id"));
			showOrderFieldByTransaction(typeOfTransaction);
			
			if(typeOfTransaction == "buy"){
				value = $("#buy-bitcoin").val();
				isSepa = $(".stateSelect option:selected").val() != "sr";
				showSepa(isSepa);
			}else{
				value = $("#sell-online-card").val();
			}
			if(value.toString().indexOf(",") != -1){
				value = newVal.replace(",",".");
			}
			value = value.replace(/^[0]+/g,"");
			$.ajax({
				type: "POST",
				url: "lib/order_process/firstStep.php",
				data: {
					"valueOfTransaction" : value,
					"typeOfTransaction" : typeOfTransaction
				},
				beforeSend: function() 
				{
					//sem dat gifko
				},
				success: function(response)
				{
					if(response.status == 'success'){
						thirdStepValuesInfo(typeOfTransaction,response.hodnota_transakcie_z,response.hodnota_transakcie_do);
						$(".clientCisloObjednavkyValue").html(response.cislo_objednavky);
						setStepVisible("first",false);
						setStepVisible("second",true);
						setStepVisible("third",false);
						swiperForm.swipeNext();
					}else{
						alert("Chyba pri validácii prvého kroku");
					}     
				},
				error: function(response)
				{
					alert("Chyba pri validácii prvého kroku");
				}
			});
		}else{
			if($(this).attr("id") == "card" && $("#sell-online-card").val() == 0){
				$(".sell-online-card-notvalid").css("display","block").html("Prosím vyplnte hodnotu väčšiu od nuly");
			}
			if($(this).attr("id") == "buy" && $("#buy-bitcoin").val() == 0){
				$(".buy-bitcoin-notvalid").css("display","block").html("Prosím vyplnte hodnotu väčšiu od nuly");
			}
		}
	});
	
		
	//--------------------------------------------------------SECOND STEP----------------------------------------------------
	
	emailValid = false;
	menoValid = false;
	priezviskoValid = false;
	cisloPenazenkyValid = false;
	cisloUctuValid = false;
	isSepa = false;
	$(".secondStep .emailInput").change(function() {
		isEmailValid(this);
	});
	$(".secondStep .cisloPenazenkyInput").keyup(function() {
		isCisloPenazenkyValid(this);
	});
	$(".secondStep .cisloUctuInput").change(function() {
		isCisloUctuValid(this);
	});
	$(".secondStep .menoNazovSepaInput").change(function() {
		isMenoNazovSepaValid(this);
	});
	$(".secondStep .ulicaSepaInput").change(function() {
		isUlicaSepaValid(this);
	});
	$(".secondStep .mestoSepaInput").change(function() {
		isMestoSepaValid(this);
	});
	$(".secondStep .smerovacieCisloSepaInput").keyup(function() {
		isSmerovacieCisloSepaValid(this);
	});
	$(".secondStep .ibanSepaInput").change(function() {
		isIbanSepaValid(this);
	});
	$(".secondStep .swiftBicSepaInput").change(function() {
		isSwiftBicSepaValid(this);
	});
	$(".secondStep .adresaZKtorejSaPosielaInput").keyup(function() {
		isAdresaZKtorejSaPosielaValid(this);
	});
	$(".stateSelect").bind("change keypress",function() {
		isSepa = $(".stateSelect option:selected").val() != "sr";
		showSepa(isSepa);
	});
	
	$(".secondStep input[type='button']").click(function(){
		action = $(this).attr("id");
		if(action == "backToFirstStep"){
			setStepVisible("first",true);
			setStepVisible("second",false);
			setStepVisible("third",false);
			swiperForm.swipePrev();
		}else if(action == "goToThirdStep"){
			cisloUctuOrCisloPenazenkyValid = false;
			adresaZKtorejSaPosielaValid = true;
			menoNazovSepaValid = false;
			ulicaSepaValid = false;
			mestoSepaValid = false;
			smerovacieCisloSepaValid = false;
			swiftBicSepaValid = false;
			ibanSepaValid = false;
			if(typeOfTransaction == "buy"){
				isSepa = $(".stateSelect option:selected").val() != "sr";
				showSepa(isSepa);
				adresaZKtorejSaPosielaValid = isAdresaZKtorejSaPosielaValid(".adresaZKtorejSaPosielaInput");
				if(isSepa){
					menoNazovSepaValid = isMenoNazovSepaValid(".menoNazovSepaInput");
					ulicaSepaValid = isUlicaSepaValid(".ulicaSepaInput");
					mestoSepaValid = isMestoSepaValid(".mestoSepaInput");
					smerovacieCisloSepaValid = isSmerovacieCisloSepaValid(".smerovacieCisloSepaInput");
					ibanSepaValid = isIbanSepaValid(".ibanSepaInput");
					swiftBicSepaValid = isSwiftBicSepaValid(".swiftBicSepaInput");
					if(menoNazovSepaValid && ulicaSepaValid && mestoSepaValid 
							&& smerovacieCisloSepaValid && ibanSepaValid && swiftBicSepaValid){
						sepaValid = true;
					}else{
						sepaValid = false;
					}
					cisloUctuOrCisloPenazenkyValid = true;
				}else{
					sepaValid = true;
					cisloUctuOrCisloPenazenkyValid = isCisloUctuValid(".cisloUctuInput");
				}
			}else{
				isSepa = false;
				sepaValid = true;
				cisloUctuOrCisloPenazenkyValid = isCisloPenazenkyValid(".cisloPenazenkyInput");
			}
			if(isEmailValid(".emailInput") 
				&& cisloUctuOrCisloPenazenkyValid
				&& adresaZKtorejSaPosielaValid
				&& sepaValid){
					//naplnenie info hodnot v tretom kroku 
					$(".clientEmailValue").html($(".emailInput").val());
					$(".clientFirstNameValue").html($(".firstNameInput").val());
					$(".clientLastNameValue").html($(".lastNameInput").val());
					$(".clientCisloPenazenkyValue").html($(".cisloPenazenkyInput").val());
					$(".clientCisloUctuValue").html($(".cisloUctuInput").val());
					$(".clientAdresaZKtorejSaPosielaValue").html($(".adresaZKtorejSaPosielaInput").val());
					$(".clientMenoNazovSepaValue").html($(".menoNazovSepaInput").val());
					$(".clientUlicaSepaValue").html($(".ulicaSepaInput").val());
					$(".clientMestoSepaValue").html($(".mestoSepaInput").val());
					$(".clientSmerovacieCisloSepaValue").html($(".smerovacieCisloSepaInput").val());
					$(".clientIbanSepaValue").html($(".ibanSepaInput").val());
					$(".clientSwiftBicSepaValue").html($(".swiftBicSepaInput").val());					
					$.ajax({
						type: "POST",
						url: "lib/order_process/secondStep.php",
						data: {
							"clientEmailValue" : $(".emailInput").val(),
							"clientFirstNameValue" : $(".firstNameInput").val(),
							"clientLastNameValue" : $(".lastNameInput").val(),
							"clientCisloPenazenkyValue" : $(".cisloPenazenkyInput").val(),
							"clientCisloUctuValue" : $(".cisloUctuInput").val(),
							"clientAdresaZKtorejSaPosielaValue" : $(".adresaZKtorejSaPosielaInput").val(),
							"isSepa" : isSepa,
							"menoNazovSepa" : $(".menoNazovSepaInput").val(),
							"ulicaSepa" : $(".ulicaSepaInput").val(),
							"mestoSepa" : $(".mestoSepaInput").val(),
							"smerovacieCisloSepa" : $(".smerovacieCisloSepaInput").val(),
							"ibanSepa" : $(".ibanSepaInput").val(),
							"swiftBicSepa" : $(".swiftBicSepaInput").val()
						},
						beforeSend: function() 
						{
							//sem dat gifko
						},
						success: function(response)
						{
							if(response.status == 'success'){
								setStepVisible("second",false);
								setStepVisible("third",true);
								setStepVisible("first",false);
								swiperForm.swipeNext();
								$(".currency-chart").hide();
							}else{
								alert("Chyba pri validácii druhého kroku");
							}     
						},
						error: function(response)
						{
							alert("Chyba pri validácii druhého kroku");
						}
					});
					
			}
		}
	});
	
	
	//--------------------------------------------------------THIRD STEP----------------------------------------------------
	
	
	$(".thirdStep input[type='button']").click(function(){
		action = $(this).attr("id");
		if(action == "backToSecondStep"){
			setStepVisible("second",true);
			setStepVisible("third",false);
			setStepVisible("first",false);
			swiperForm.swipePrev();
			$(".currency-chart").show();
		}else{
			vpb_submit_captcha();
		}
	});
});

	//--------------------------------------------------------FUNCTIONS----------------------------------------------------

function changeInputValueFirstStep(object,type){
	isBitcoin = false;
	input = ((type == "button") ? $(object).parent().find("input") : $(object));
	if(($(object).parents().hasClass("lavy-predaj") && input.hasClass("read-only")) || 
    		(!$(object).parents().hasClass("lavy-predaj") && !input.hasClass("read-only"))){ //zaokruhlenie na dve alebo 6 desatinnych miest v zadavanej hodnote
    	 isBitcoin = true;
    }
	isSellSide = $(object).parents().hasClass("lavy-predaj");
	if(type == "button"){
		$button = $(object);
	    oldValue = $button.parent().find("input").val();
	    if(oldValue.toString().indexOf(",") != -1){
	    	oldValue = oldValue.replace(",",".");
		}
	    if($button.text() == "+"){
	    	if(isNaN(oldValue)){
	    		newVal = 1;
	    	}else{
	    		if(isBitcoin){
	    			newVal = parseFloat(oldValue) + 0.01;
	    		}else{
	    			newVal = parseFloat(oldValue) + 1;
	    		}
	    	}
	  	}else{
	      if(oldValue > 0){
	    	  if(isBitcoin){
	    		  newVal = parseFloat(oldValue) - 0.01;
	    	  }else{
    			  newVal = parseFloat(oldValue) - 1;
	    	  }
		    }else{
		    	newVal = 0;
		    }
	  	}
	    roundPrecision = (isBitcoin ? 1000000 : 100);
		$button.parent().find("input").val((Math.round(newVal * roundPrecision) / roundPrecision));
		
	}else{
		newVal = $(object).val();
	}
	if(newVal.toString().indexOf(",") != -1){
		newVal = newVal.replace(",",".");
	}
	inputId = input.attr("id");	
	if(newVal > 0){
		if(input.hasClass("read-only")){
			valueCount(newVal,isSellSide,true,inputId,isBitcoin);
		}else{
			valueCount(newVal,isSellSide,false,inputId,isBitcoin);
		}
		return true;
	}else{
		showValidationFirstStep(newVal,false,"Prosím vyplnte hodnotu väčšiu od nuly",((isSellSide) ? "sell-online-card" : "buy-bitcoin"),isBitcoin);
		$("#"+inputId+"-info").val(0);
		ajaxCounting = false;
		return false;
	}
}
function isNumber(value) {
	if ((undefined === value) || (null === value)) {
        return false;
    }
    if (typeof value == 'number') {
        return true;
    }
    return !isNaN(value - 0);
}
function showValidationFirstStep(value,isValid,message,input,isBitcoin){
	if(isValid){
		$("."+input+"-notvalid").css("display","none");
		$("."+inputId).removeClass("disabled");
		if(value < ((isBitcoin) ? 0.01 : 1 )){
			$("#"+inputId).siblings(".dec").hide();
		}else{
			$("#"+inputId).siblings(".dec").show();
		}
	}else{
		$("."+input+"-notvalid").css("display","block").html(message);
		$("."+inputId).addClass("disabled");
	}
}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}
function isEmailValid(object){
	if(!isValidEmailAddress($(object).val())){
		$(".emailInputValidation").show();
		return false;
	}else{
		$(".emailInputValidation").hide();
		return true;
	}
}
function isCisloPenazenkyValid(object){
	if($(object).val() == ""){
		$(object).parents(".cisloPenazenky").find(".numberInputValidation").show();
		return false;
	}else{
		$(object).parents(".cisloPenazenky").find(".numberInputValidation").hide();
		return true;
	}
}
function isCisloUctuValid(object){
	splitObject = $(object).val().split("/");
	if(!splitObject[0] || !splitObject[1]){
		$(object).parents(".cisloUctu").find(".numberInputValidation").show();
		return false;
	}else{
		if((!isNumber(splitObject[0]) || !isNumber(splitObject[1]))
				&& ((!(splitObject[0].toString().indexOf(".") != -1)) 
				|| (!(splitObject[1].toString().indexOf(".") != -1)))
				|| $(object).val() == ""){
			$(object).parents(".cisloUctu").find(".numberInputValidation").show();
			return false;
		}else{
			$(object).parents(".cisloUctu").find(".numberInputValidation").hide();
			return true;
		}
	}
}
function isAdresaZKtorejSaPosielaValid(object){
	if($(object).val() == ""){
		$(".adresaZKtorejSaPosielaValidation").show();
		return false;
	}else{
		$(".adresaZKtorejSaPosielaValidation").hide();
		return true;
	}
}
function isMenoNazovSepaValid(object){
	
	if($(object).val() == ""){
		$(".menoNazovSepaValidation").show();
		return false;
	}else{
		$(".menoNazovSepaValidation").hide();
		return true;
	}
}
function isUlicaSepaValid(object){
	
	if($(object).val() == ""){
		$(".ulicaSepaValidation").show();
		return false;
	}else{
		$(".ulicaSepaValidation").hide();
		return true;
	}
}
function isMestoSepaValid(object){
	
	if($(object).val() == ""){
		
		$(".mestoSepaValidation").show();
		return false;
	}else{
		$(".mestoSepaValidation").hide();
		return true;
	}
}
function isSmerovacieCisloSepaValid(object){
	if($(object).val() == ""){
		$(".smerovacieCisloSepaValidation").show();
		return false;
	}else{
		$(".smerovacieCisloSepaValidation").hide();
		return true;
	}
}
function isIbanSepaValid(object){
	if($(object).val() == ""){
		$(".ibanSepaValidation").show();
		return false;
	}else{
		$(".ibanSepaValidation").hide();
		return true;
	}
}
function isSwiftBicSepaValid(object){
	if($(object).val() == ""){
		$(".swiftBicSepaValidation").show();
		return false;
	}else{
		$(".swiftBicSepaValidation").hide();
		return true;
	}
}
function sendData(){
	typeOfSellTransaction = $(".sposobPlatby input[name=flat-radio-sell]:checked").attr("id");
	$.ajax({
		type: "POST",
		url: "lib/order_process/sendOrder.php",
		data: {
			"sendOrder" : true,
			"typeOfSellTransaction" : typeOfSellTransaction
		},
		beforeSend: function() 
		{
			//sem dat gifko
		},
		success: function(response)
		{
			if(response.status == 'success'){
				if(response.pay_type == 'trustPay'){
					self.location = response.trust_pay;
				}else{
					swiperForm.swipeNext();
				}
			}else{
				alert("Chyba pri odoslaní objednávky");
			}	
		},
		error: function(response)
		{
			alert("Chyba pri odoslaní objednávky");
		}
	});
}
function valueCount(value,isSellSide,isReadOnly,inputId,isBitcoin){
	$.ajax({
		type: "POST",
		url: "lib/order_process/sumCount.php",
		data: {
			"value" : value,
			"isSellSide" : isSellSide,
			"isReadOnly" : isReadOnly
		},
		beforeSend: function() 
		{
			//sem dat gifko
		},
		success: function(response)
		{
			if(response.status == 'success'){
				newVal = $("#" + inputId).val();
				if(newVal.toString().indexOf(",") != -1){
					newVal = newVal.replace(",",".");
				}
				if(newVal != value){
					valueCount(newVal,isSellSide,isReadOnly,inputId,isBitcoin);
				}else{
					if(isReadOnly){
						$("#"+inputId.substring(0,inputId.length-5)).val(response.value);
					}else{
						$("#"+inputId+"-info").val(response.value);
					}
					validFirstStepAjax = true;
					if(response.value < ((isBitcoin) ? 1 : 0.01 )){
						$(((!isSellSide) ? "#buy-bitcoin" : "#"+inputId+"-info")).siblings(".dec").hide();
					}else{
						$(((!isSellSide) ? "#buy-bitcoin" : "#"+inputId+"-info")).siblings(".dec").show();
					}
					showValidationFirstStep(value,true,"",((isSellSide) ? "sell-online-card" : "buy-bitcoin"),isBitcoin);
					ajaxCounting = false;
				}
			}else if(response.status == 'moreThan'){
				newVal = $("#" + inputId).val();
				if(newVal.toString().indexOf(",") != -1){
					newVal = newVal.replace(",",".");
				}
				if(newVal != value){
					valueCount(newVal,isSellSide,isReadOnly,inputId,isBitcoin);
				}else{
					validFirstStepAjax = false;
					message = "Výsledná suma prevyšuje hodnotu v " + (isSellSide ? "€" : "BTC") + ",ktorá je k dispozícii";
					showValidationFirstStep(value,false,message,((isSellSide) ? "sell-online-card" : "buy-bitcoin"),isBitcoin);
					ajaxCounting = false;
				}
			}else{
				validFirstStepAjax = false;
				message = "Chyba pri výpočte sumy";
				showValidationFirstStep(value,false,message,((isSellSide) ? "sell-online-card" : "buy-bitcoin"),isBitcoin);
				ajaxCounting = false;
			}	
		},
		error: function(response)
		{
			alert("Chyba pri výpočte sumy");
			ajaxCounting = false;
		}
	});
}
function refreshCurrency() {
	$.ajax({
		type: "POST",
		url: "lib/refreshCurrency.php",
		data: {
			"refreshCurrency" : true
		},
		beforeSend: function() 
		{
			//sem dat gifko
		},
		success: function(response)
		{
			if(response.status == 'success'){
				$(".chart-sell").html(response.predaj);
				$(".chart-buy").html(response.nakup);
			}else{
				alert("Chyba pri obnovení kurzov");
			}	
		},
		error: function(response)
		{
			alert("Chyba pri obnovení kurzov");
		}
	});
    setTimeout('refreshCurrency()', 60000);
}
function setStepVisible(step,isVisible){
	if(isVisible){
		$("." + step + "StepVisible").show();
	}else{
		$("." + step + "StepVisible").hide();
	}
}
function showOrderFieldByTransaction(typeOfTransaction){
	showSepa(false);
	if(typeOfTransaction == "buy"){
		$(".cisloPenazenky,.clientCisloPenazenky").hide();
		$(".cisloUctu,.clientCisloUctu,.adresaZKtorejSaPosiela,.clientAdresaZKtorejSaPosiela,.stateSelect").show();
		$(".typeOfServiceTitle").html("Predať bitcoin");
		$(".sposobPlatby").hide();
		$(".captcha h5").html("2. Vyplnte captchu");
	}else{
		$(".cisloUctu,.clientCisloUctu,.adresaZKtorejSaPosiela,.clientAdresaZKtorejSaPosiela,.stateSelect").hide();
		$(".cisloPenazenky,.clientCisloPenazenky").show();
		$(".typeOfServiceTitle").html("Kúpiť bitcoin");
		$(".sposobPlatby").show();
		$(".captcha h5").html("3. Vyplnte captchu");
	}
}
function thirdStepValuesInfo(typeOfTransaction,hodnotaTransakcieZ,hodnotaTransakcieDo){
	if(typeOfTransaction == "buy"){
		$(".clientHodnotaZTitle").html("Predávate:");
		$(".clientHodnotaZValue").html(hodnotaTransakcieZ + " BTC");
		$(".clientHodnotaDoTitle").html("Cena ~");
		$(".clientHodnotaDoValue").html(hodnotaTransakcieDo + " Eur");
	}else{
		$(".clientHodnotaZTitle").html("Cena:");
		$(".clientHodnotaZValue").html(hodnotaTransakcieZ + " Eur");
		$(".clientHodnotaDoTitle").html("Nákup ~");
		$(".clientHodnotaDoValue").html(hodnotaTransakcieDo + " BTC");
	}
}
function resetSession(){
	$.ajax({
		type: "POST",
		url: "lib/order_process/resetProcess.php"
	});
}
function showSepa(isSepa){	
	if(isSepa){
		$(".menoClass,.priezviskoClass,.cisloUctu").hide();
		$(".clientFirstName,.clientLastName,.clientCisloUctu").hide();
		$(".clientMenoNazovSepa,.clientUlicaSepa,.clientMestoSepa,.clientSmerovacieCisloSepa,.clientIbanSepa,.clientSwiftBicSepa").show();
		$(".menoNazovSepa,.ulicaSepa,.mestoSepa,.smerovacieCisloSepa,.ibanSepa,.swiftBicSepa").show();	
	}else{
		$(".menoClass,.priezviskoClass,.cisloUctu").show();
		$(".clientFirstName,.clientLastName,.clientCisloUctu").show();
		$(".clientMenoNazovSepa,.clientUlicaSepa,.clientMestoSepa,.clientSmerovacieCisloSepa,.clientIbanSepa,.clientSwiftBicSepa").hide();
		$(".menoNazovSepa,.ulicaSepa,.mestoSepa,.smerovacieCisloSepa,.ibanSepa,.swiftBicSepa").hide();
	}	
}
function isMoreThanTenEur(object){
	if($(object).parents().hasClass("lavy-predaj")){
		if($("#sell-online-card").val() < 10){
			$(".sell-online-card-notvalid").css("display","block");
			$(".sell-online-card-notvalid").html("Hodnota eur musí byť minimálne 10");
			return false;
		}else{
			$(".sell-online-card-notvalid").hide();
			$(".sell-online-card-notvalid").html("Pole nie je vyplnené správne");
			return true;
		}
		
	}else{
		if($("#buy-bitcoin-info").val() < 10){
			$(".buy-bitcoin-notvalid").css("display","block");
			$(".buy-bitcoin-notvalid").html("Hodnota eur musí byť minimálne 10");
			return false;
		}else{
			$(".buy-bitcoin-notvalid").hide();
			$(".buy-bitcoin-notvalid").html("Pole nie je vyplnené správne");
			return true;
		}
	}
}

