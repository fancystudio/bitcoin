		<?php
//If the form is submitted
if(isset($_POST['submit'])) {

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
		$emailTo = 'info@adblocmedia.sk'; // Put your own email address here
		$body = "Meno: $name \n\nEmail: $email   \n\nSpráva:\n $comments";
		$headers = 'From: info@adblocmedia.sk <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
}
?>

<h2>Kontakt</h2>

</div><!--main-content-->
		</div><!--main-content-wrap-->
		
		<div class="content container">
<h2></h2>


<form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform" class="well col-md-8 pull-right">
          <fieldset>
            <legend>Napíšte nám!</legend>

            <?php if(isset($hasError)) { //If errors are found ?>
              <p class="alert alert-danger">Prosím skontrolujte či ste vyplnili všetky polia</p>
            <?php } ?>

            <?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
              <div class="alert alert-success">
                <p><strong>Správa bola úspešne odoslaná</strong></p>
                              </div>
            <?php } ?>

            <div class="form-group">
              
              <input type="text" name="contactname" id="contactname" value="" class="form-control required" role="input" aria-required="true" placeholder="Vaše meno" />
            </div>

            


            <div class="form-group">
              
              <input type="text" name="email" id="email" value="" class="form-control required email" role="input" aria-required="true" placeholder="Váš e-mail" />
            </div>

            


            

            <div class="form-group">
              
              <textarea rows="8" name="message" id="message" class="form-control required" role="textbox" aria-required="true" placeholder="Vaša správa"></textarea>
            </div>

            <div class="actions">
              <input type="submit" value="Odoslať" name="submit" id="submitButton" class="btn btn-primary pull-right" title="Odoslať správu" />
              <!--<input type="reset" value="Clear Form" class="btn btn-danger" title="Remove all the data from the form." />-->
            </div>
          </fieldset>
        </form>

		</div><!--content-->