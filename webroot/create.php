<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

// connect to MySQL datyabase using PHP PDO
$db = new CDatabase($eros['database']);
$content = new CContent($db);

if(isset($_POST['create'])) {
	$title = $_POST['title'];
	$content->CreateContent($title);
}

$eros['title'] = "Skapa nyhet";
$eros['debug'] = $db->Dump();

$eros['main'] = <<<EOD
<br/>
<form method=post>
<fieldset>
<legend><b>Skapa Nyhet</b></legend>
<p><lable>Titel:<br/><input type='text' name='title'/></lable></p>
<p><input type='submit' name='create' value='Spara'/></p>
</fieldset>
</form>
EOD;


include(EROS_THEME_PATH);