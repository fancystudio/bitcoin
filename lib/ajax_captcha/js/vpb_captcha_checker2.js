/********************************************************************************************************************
* This script is brought to you by Vasplus Programming Blog by whom all copyrights are reserved.
* Website: www.vasplus.info
* Email: info@vasplus.info
* Please, do not remove this information from the top of this page.
*********************************************************************************************************************/


//This function refreshes the security or captcha code when clicked on the refresh link
function vpb_refresh_aptcha()
{
	console.log("volso5");
	return $("#vpb_captcha_code").val('').focus(),document.images['captchaimg'].src = document.images['captchaimg'].src.substring(0,document.images['captchaimg'].src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}



//This function checks to see if the code provided is correct or wrong and displays the appropriate result on the screen to the user
function vpb_submit_captcha(lang)
{
	console.log("volso4");
	var returnValue = false;
	var vpb_captcha_code = $("#vpb_captcha_code").val();
	
	if(vpb_captcha_code == "")
	{
		$("#captchaResponse").html('<div class="vpb_info" align="left">'+ ((lang == "sk_SK") ? "Nevyplnená captcha" : "Captcha is not filled" )+'.</div>');
		$("#vpb_captcha_code").focus();
	}
	else
	{
		var ajaxEnd = false;
		var dataString = 'vpb_captcha_code='+ vpb_captcha_code + '&lang='+ lang;
		$.ajax({
			type: "POST",
			url: "lib/ajax_captcha/captcha_checker.php",
			data: {
				vpb_captcha_code : vpb_captcha_code,
				lang : lang
			},
			cache: false,
			beforeSend: function() 
			{
				$("#captchaResponse").html('<div style="padding-left:100px;margin-bottom:30px;"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:black;">'+ ((lang == "sk_SK") ? "Prosím čakajte" : "Please wait" )+'</font> <img src="lib/ajax_captcha/load.gif" align="absmiddle" /></div>');
			},
			success: function(response)
			{
				vpb_refresh_aptcha();
				$("#vpb_captcha_code").val('');
				if(!response.indexOf(((lang == "sk_SK") ? "Správne vyplnená captcha" : "Captcha is ok" )) != -1){
					console.log("volso");
					$("#captchaResponse").hide().fadeIn('slow').html(response);
				}
				if(response.indexOf(((lang == "sk_SK") ? "Správne vyplnená captcha" : "Captcha is ok" )) != -1){
					console.log("volso2");
					sendData();
				}
			},complete : function(){
				return returnValue;
			}
		});
	}
	
}