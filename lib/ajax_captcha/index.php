<?php
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>vasPLUS Programming Blog</title>



<!-- Required header files -->
<script language="javascript" type="text/javascript" src="js/jquery_1.5.2.js"></script>
<script language="javascript" type="text/javascript" src="js/vpb_captcha_checker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">





</head>
<body>
<br clear="all">
<center>
<div style="font-family:Verdana, Geneva, sans-serif; font-size:24px;">Simple Ajax, Jquery and PHP Anti-Spam Captcha Script - Updated</div><br clear="all" /><br clear="all" />
<center>











<!-- Code Begins Here -->
<div class="vasplus_programming_blog_wrapper" align="left">
<br clear="all">
<center>
<div style="width:400px; font-family:Verdana, Geneva, sans-serif; font-size:12px;" align="left">
<div style="width:400px; float:left;" align="left" id="captchaResponse"></div><br clear="all">
<div style="width:100px; float:left; padding-top:16px;" align="left">&nbsp;</div>
<div style="width:300px; float:left;" align="left"><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">Enter the below security code here</font><br><br>

<div class="vpb_captcha_wrappers"><input id="vpb_captcha_code" name="vpb_captcha_code" type="text"></div></div><br clear="all">

<div style="width:100px; float:left;" align="left">Security Code:</div>

<div style="width:300px; float:left;" align="left"><div class="vpb_captcha_wrapper"><img src="vasplusCaptcha.php?rand=<?php echo rand(); ?>" id='captchaimg' ></div><br clear="all">

<div style=" padding-top:5px;" align="left"><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">Nedokážete text prečitať? <span class="ccc"><a href="javascript:void(0);" onClick="vpb_refresh_aptcha();">Obnoviť</a></span></font></div>

</div>
<br clear="all"><br clear="all"><br clear="all">

<div style="width:100px; float:left;" align="left">&nbsp;</div>
<div style="width:300px; float:left;" align="left"><input type="submit" class="vpb_general_button"  value="Submit" onClick="vpb_submit_captcha();"></div>

</div>
<br clear="all"><br clear="all"><br clear="all">
</center>
</div>
<!-- Code Ends Here -->





</center>
</center>
</body>
</html>