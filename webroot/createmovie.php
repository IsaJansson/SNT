<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

// connect to MySQL datyabase using PHP PDO
$db = new CDatabase($eros['database']);
$movie = new CMovies($db);

if(isset($_POST['create'])) {
	$title = $_POST['title'];
	$movie->CreateMovie($title);
}

$eros['title'] = "Lägg till film";
$eros['debug'] = $db->Dump();

$eros['main'] = <<<EOD
<br/>
<form method=post>
<fieldset>
<legend><b>Lägg till ny film</b></legend>
<p><lable>Titel:<br/><input type='text' name='title'/></lable></p>
<p><input type='submit' name='create' value='Spara'/></p>
</fieldset>
</form>
EOD;


include(EROS_THEME_PATH);