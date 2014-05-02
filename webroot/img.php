<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 

$eros['title'] = "Bilder";
$db = new CDatabase($eros['database']);
$image = new CImage($db); 
$output = null; 

$output = "hej";


$eros['main'] = <<<EOD
{$output}
EOD;


include(EROS_THEME_PATH);


