<?php 
include(__DIR__.'/config.php'); 
 
$eros['title'] = "Kontakt";

if (isset($_POST["submit"])) {  // the user has submitted the form
	$name = $_POST["name"]; // sender
    $from = $_POST["mail"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $to = 'isa.jansson@hotmail.com';
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail($to,$subject,$message,"From: $name <$from>");
    $message = "<p class='message'>Tack för ditt meddelande!</p>";
  }

$eros['main'] = <<<EOD

<div id="content">

<p>information om företaget.</p>
	<form method='post' action=''>
	<fieldset>
	<legend>Maila mig här!</legend>
	Namn:<br>
	<input type='text' name='name' placeholder='John Doe' size='25'><br>
	E-mail:<br>
	<input type='text' name='mail' placeholder='någon@exempel.se' size='25'><br>
	Ämne:<br>
	<input type='text' name='subject' size='25'><br>
	Meddelande:<br>
	<textarea rows='10' cols='40' name='message'></textarea><br />
	<input type='submit' name='submit' value='Skicka'>
	<input type='reset' value='Rensa'>
	</fieldset>
	</form> 

</div>

EOD;


include(EROS_THEME_PATH);
