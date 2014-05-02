<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

// connect to MySQL datyabase using PHP PDO
$db = new CDatabase($eros['database']);
$movie = new CMovies($db);

// Get parameters 
		$id = isset($_POST['id']) ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
		$title = isset($_POST['title']) ? $_POST['title'] : array();
		$price = isset($_POST['price']) ? $_POST['price'] : null;
		$plot = isset($_POST['plot']) ? $_POST['plot'] : null;
		$director = isset($_POST['director']) ? $_POST['director'] : array();
		$year = isset($_POST['YEAR']) ? $_POST['YEAR'] : null;
		$length = isset($_POST['LENGTH']) ? $_POST['LENGTH'] : null;
		$imdb = isset($_POST['imdb']) ? $_POST['imdb'] : array();
		$trailer = isset($_POST['trailer']) ? $_POST['trailer'] : array();
		$save = isset($_POST['save']) ? true : false;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// check if valid
isset($acronym) or die('Check: You must login to edit this file.');
is_numeric($id) or die('Check: Id must be numeric.');

$output = null;
if($save) {
	$output = $movie->EditMovie();
}

$c = $movie->SelectFromTable($id);
// Sanitize content 
$title = htmlentities($c->title, null, 'UTF-8');
$plot = htmlentities($c->plot, null, 'UTF-8');
$price = htmlentities($c->price, null, 'UTF-8');
$year = $c->YEAR;
$length = $c->LENGTH;
$image = htmlentities($c->image, null, 'UTF-8');
$director = htmlentities($c->director, null, 'UTF-8');
$imdb = htmlentities($c->imdb, null, 'UTF-8');
$trailer = htmlentities($c->trailer, null, 'UTF-8');



$eros['title'] = "Redigera film";
$eros['debug'] = $db->Dump();


$eros['main'] = <<<EOD
<br/>
<form method=post>
	<fieldset>
		<legend><b>Uppdatera innehållet</b></legend>
		<input type='hidden' name='id' value='{$id}'/>
		<p><lable>Titel:<br/><input type='text' name='title' value='{$title}'/></lable></p>
		<p><lable>Årtal:<br/><input type='text' name='year' value='{$year}'/></lable></p>
		<p><lable>Längd i minuter:<br/><input type='text' name='length' value='{$length}'/></lable></p>
		<p><lable>Handling:<br/><textarea name='plot'>{$plot}</textarea></lable></p>
		<p><lable>Regissör:<br/><input type='text' name='director' value='{$director}'/></lable></p>
		<p><lable>Pris:<br/><input type='text' name='price' value='{$price}'/></lable></p>
		<p><lable>Bild:<br/><input type='text' name='image' value='{$image}'/></lable></p>
		<p><lable>Länk till IMDB:<br/><input type='text' name='imdb' value='{$imdb}'/></lable></p>
		<p><lable>Länk till trailern:<br/><input type='text' name='trailer' value='{$trailer}'/></lable></p>
		<p class='buttons'><input type='submit' name='save' value='Spara'/><input type='reset' value='Återställ'/></p>
		<p><a href='movie.php'>Visa alla</a></p>
		<output>{$output}</output>
	</fieldset>
</form>
EOD;


include(EROS_THEME_PATH);