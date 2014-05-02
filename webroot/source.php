<?php 

include(__DIR__.'/config.php'); 

$eros['stylesheets'][] = 'css/source.css';

$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));

$eros['title'] = "Visa källkod";

$eros['main'] = "<h1>Visa källkod</h1>\n" . $source->View();

include(EROS_THEME_PATH);