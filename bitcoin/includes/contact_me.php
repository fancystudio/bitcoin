<?php
// check if fields passed are empty
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
	
// create email body and send it	
$to = 'roman.sekeres@fancystudio.sk'; // put your email
$email_subject = "Formular od:  $name";
$email_body = "Prijali ste novú správu  \n\n".
				  " Text:\n \nName: $name \n ".
				  "Email: $email_address\n Message \n $message";
//$headers = "Z: info@adblocmedia.sk\n";
//$headers .= "Odpoveď na: $email_address";	
$headers = 'From: info@fancystudio.sk <'.$to.'>' . "\r\n" . 'Reply-To: ' . $email_address;
mail($to, $email_subject, $email_body, $headers);
return true;			
?>


