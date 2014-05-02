<?php
include(__DIR__.'/config.php');

$eros['title'] = "404";
$eros['header'] = "";
$eros['main'] = "This is a Eros 404. Document dose not exist.";
$eros['footer'] = "";

header("HTTP/1.0 404 Not Found");

include(EROS_THEME_PATH);