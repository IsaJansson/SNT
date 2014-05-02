<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

// connect to MySQL datyabase using PHP PDO
$db = new CDatabase($eros['database']);
$movie = new CMovies($db);

$id = strip_tags($_GET['id']); 
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null; 

isset($acronym) or die('Check: You must login to delete.'); 
is_numeric($id) or die('Check: Id must be numeric.'); 

$output1 = null;
$output = null;
$title = null;

if (!isset($_POST['delete'])) { 
    $c = $movie->SelectFromTable($id); 
    $title  = htmlentities($c->title, null, 'UTF-8'); 
} 
else 
{ 
    $output = $movie->DeleteMovie($id); 
    if ($output==null) {
        $output="Det fungerade inte!"; 
    }
}

if(isset($_POST['return'])) {
	header('location: movie.php?');
}

$output1 = "Radera " . $title;

$eros['title'] = "Radera innehåll";
$eros['debug'] = $db->Dump();

$eros['main'] = <<<EOD
<form method=post> 
<h2>{$output1}?</h2>
<p>Är du säker på att du vill <input type='submit' name='delete' value='Ta bort'/>detta innehåll? annars kan du <input type='submit' name='return' value='Återgå'/></p> 
</form> 
EOD;


include(EROS_THEME_PATH);