<?php
	$from = $_POST["from"]; // sender
    $mail = $_POST["mail"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $to = 'isa.jansson@hotmail.com';

if (mail($to,$subject,$message,$from,$mail)) {  // the user has submitted the form
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    echo "<p>Thank you for sending us feedback</p>";
  }

echo nl2br("<h2>Ditt meddelande har skickats!</h2> 
<b>mottagare:</b> $to
<b>ämne:</b> $subject
<b>meddelande:</b>
$message
");