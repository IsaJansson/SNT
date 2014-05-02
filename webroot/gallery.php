<?php

// This is a Eros pagecontroller 

// including the essential configuration file  
include(__DIR__.'/config.php'); 
$eros['stylesheets'][] = 'css/gallery.css';
$eros['stylesheets'][] = 'css/figure.css';
$eros['stylesheets'][] = 'css/breadcrumb.css';


$eros['title'] = "Galleri";

$validImages = array('jpeg', 'jpg', 'png', 'gif');
$gallery = new CGallery($validImages);

$path = isset($_GET['path']) ? $_GET['path'] : null; 

$pathToGallery = realpath(GALLERY_PATH . '/' . $path); 

$html = $gallery->ShowGallery($pathToGallery); 
$breadcrumb = $gallery->createBreadcrumb($pathToGallery); 

$eros['main'] = <<<EOD
{$breadcrumb}
{$html}
EOD;


include(EROS_THEME_PATH);