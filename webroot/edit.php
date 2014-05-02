<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

// connect to MySQL datyabase using PHP PDO
$db = new CDatabase($eros['database']);
$content = new CContent($db);

// Get parameters 
$id			= isset($_POST['id']) ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title		= isset($_POST['title']) ? $_POST['title'] : null;
$slug		= isset($_POST['slug']) ? $_POST['slug'] : null;
$url		= isset($_POST['url']) ? strip_tags($_POST['url']) : null;
$data 		= isset($_POST['data']) ? $_POST['data'] : array();
$type 		= isset($_POST['type']) ? strip_tags($_POST['type']) : array();
$filter 	= isset($_POST['filter']) ? $_POST['filter'] : array();
$published  = isset($_POST['published']) ? strip_tags($_POST['published']) : array();
$save		= isset($_POST['save']) ? true : false;
$acronym 	= isset($_SESSION['user']) ? $_SESSION['user']->acronym : null; 

// check if valid
isset($acronym) or die('Check: You must login to edit this file.');
is_numeric($id) or die('Check: Id must be numeric.');

$output = null;
if($save) {
	$output = $content->EditContent();
}

$c = $content->SelectFromTable($id);

// Sanitize content 
$title = htmlentities($c->title, null, 'UTF-8');
$slug = htmlentities($c->slug, null, 'UTF-8');
$url = $c->url;
$data = htmlentities($c->DATA, null, 'UTF-8');
$type = $c->TYPE;
$filter = htmlentities($c->FILTER, null, 'UTF-8');
$published = $c->published;

$eros['title'] = "Redigera nyhet";
$eros['debug'] = $db->Dump();

$eros['main'] = <<<EOD
<br/>
<form method=post>
	<fieldset>
		<legend><b>Uppdatera innehållet</b></legend>
		<input type='hidden' name='id' value='{$id}'/>
		<p><lable>Titel:<br/><input type='text' name='title' value='{$title}'/></lable></p>
		<p><lable>Slug:<br/><input type='text' name='slug' placeholder='tex: blogginlägg' value='{$slug}'/></lable></p>
		<p><lable>Text:<br/><textarea name='data'>{$data}</textarea></lable></p>
		<p><lable>Type:<br/><input type='text' name='type' placeholder='post' value='{$type}'/></lable></p>
		<p><lable>Filter:<br/><input type='text' name='filter' placeholder='bbcode, n12br, markdown, link' value='{$filter}'/></lable></p>
		<p><lable>Publiceringsdatum:<br/><input type='text' name='published' placeholder='0000-00-00' value='{$published}'/></lable></p>
		<p class='buttons'><input type='submit' name='save' value='Spara'/><input type='reset' value='Återställ'/></p>
		<p><a href='view.php'>Visa alla</a></p>
		<output>{$output}</output>
	</fieldset>
</form>
EOD;


include(EROS_THEME_PATH);