<?php
//error_reporting( E_ALL );
//ini_set('display_errors', 1);
require_once('lib/HelperClass.php');
$help = new Helper(cmsms()->config);	
$selectedLang = CmsNlsOperations::get_current_language();
$actualLang = $help->getTranslate(CmsNlsOperations::get_current_language());
//If the form is submitted

if(isset($_POST['submit']) && $_SESSION["emailSent"] != true) {

	//Check to make sure that the name field is not empty
	if(trim($_POST['contactname']) == '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contactname']);
	}



	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!filter_var( trim($_POST['email'], FILTER_VALIDATE_EMAIL ))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['message']) == '') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['message']));
		} else {
			$comments = trim($_POST['message']);
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = 'dotaznik@kupitbitcoin.sk'; // info.buysellbitcoin@gmail.com Put your own email address here
		//$emailTo = 'info@fancystudio.sk';
		$body = "Meno: $name \n\nEmail: $email   \n\nSpráva:\n $comments";
		$headers = 'From: dotaznik@kupitbitcoin.sk <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
		//$headers = 'From: info@fancystudio.sk <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
		$subject = 'dotaznik od zakaznika';
		mail($emailTo, $subject, $body, $headers);
		$_SESSION["emailSent"] = true;
		$emailSent = true;
	}
}
?>


		
		<div class="content container">
<h2></h2>

<div class="col-md-4 pull-left kontakt-image hidden-sm hidden-xs">
<img src="img/kontakt-img.png" alt="kúpiť bitcoin - kontakt"></img>
<span><a href="mailto:info.buysellbitcoin@gmail.com">info.buysellbitcoin@gmail.com</a></span>
</div>

<form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?page=kontakt".(($selectedLang == "en_US") ? "_en" : ""); ?>" id="contactform" class="col-md-8 col-sm-12 col-xs-12 pull-left">
          <fieldset>
            <legend><?php echo $actualLang["napistenam"] ?>!</legend>

            <?php if(isset($hasError)) { //If errors are found 
	            
            ?>
              <p class="alert alert-danger"><?php echo $actualLang["kontaktniejespravne"] ?></p>
            <?php } ?>

            <?php if(isset($emailSent) && $emailSent == true) { //If email is sent 
	            
            ?>
              <div class="alert alert-success">
                <p><strong><?php echo $actualLang["kontaktodoslany"] ?></strong></p>
                              </div>
            <?php } ?>

            <div class="form-group">
              
              <input type="text" name="contactname" id="contactname" value="<?php echo (isset($_POST['contactname']) ? $_POST['contactname'] : "") ?>" class="form-control required" role="input" aria-required="true" placeholder="<?php echo $actualLang["vasemeno"] ?>" />
            </div>

            


            <div class="form-group">
              
              <input type="text" name="email" id="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : "") ?>" class="form-control required email" role="input" aria-required="true" placeholder="<?php echo $actualLang["vasemail"] ?>" />
            </div>

            


            

            <div class="form-group">
              
              <textarea rows="8" name="message" id="message" class="form-control required" role="textbox" aria-required="true" placeholder="<?php echo $actualLang["vasasprava"] ?>"><?php echo (isset($_POST['message']) ? $_POST['message'] : "") ?></textarea>
            </div>

            <div class="actions">
              <input type="submit" value="<?php echo $actualLang["odoslat"] ?>" name="submit" id="submitButton" class="btn btn-primary pull-right" title="Odoslať správu" />
            </div>
          </fieldset>
        </form>

		</div><!--content-->