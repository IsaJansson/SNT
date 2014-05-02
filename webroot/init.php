<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

// connect to MySQL datyabase using PHP PDO
$db = new CDatabase($eros['database']);
$content = new CContent($db);

$output = $content->RestoreContent();

$eros['title'] = "återställ";
$eros['debug'] = $db->Dump();

$eros['main'] = <<<EOD

<h2>{$output}</h2>

<p><a href='create.php'>Skapa ny post</a></p>
<p><a href='blog.php'>Visa alla bloggposter</a></p>

EOD;


include(EROS_THEME_PATH);