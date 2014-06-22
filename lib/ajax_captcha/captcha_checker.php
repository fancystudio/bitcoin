<?php 
/********************************************************************************************************************
* This script is brought to you by Vasplus Programming Blog by whom all copyrights are reserved.
* Website: www.vasplus.info
* Email: info@vasplus.info
* Please, do not remove this information from the top of this page.
*********************************************************************************************************************/
session_start();
if(empty($_SESSION['vpb_captcha_code']) || strcasecmp($_SESSION['vpb_captcha_code'], $_POST['vpb_captcha_code']) != 0)
{
	//Note: the captcha code is compared case insensitively. If you want case sensitive match, update the check above to strcmp()
	echo '<div class="vpb_info" align="left">'.(($_POST['lang'] == "sk_SK") ? "Nevyplnená vyplená captcha" : "Captcha is not ok" ).'.</div>';
}
else
{
	echo '<div class="vpb_success" align="left">'.(($_POST['lang'] == "sk_SK") ? "Správne vyplnená captcha" : "Captcha is ok" ).'</div>';
}
?>