<?php
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('output_buffering', 0);


/* definera sökväg*/
define('EROS_INSTALL_PATH', __DIR__ . '/..');
define('EROS_THEME_PATH', EROS_INSTALL_PATH . '/theme/render.php');

define('IMG_PATH', __DIR__ . '/');
define('CACHE_PATH', __DIR__ . '/cache/');

define('GALLERY_PATH', realpath(__DIR__ . '/img/'));
define('GALLERY_BASEURL', '');
 
/* inkludera bootstrap-funktionen */
include(EROS_INSTALL_PATH . '/src/bootstrap.php');

/* starta en session */
session_name(preg_replace('/[:\.\/-_]/', '', __DIR__) ."user");
session_start();

/* skapa Eros variabeln */
$eros = array();

/* inställningar för sidan */
$eros['lang']	='sv';
$eros['title_append'] = ' | Stockholm Nature Tourism';

/* Tema relaterade inställningar */
$eros['stylesheets'] = array('css/style.css');
$eros['favicon'] = 'img/logo.png';

/* settings for javasqrip */
$eros['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
//$anax['jquery'] = null; // To disable jQuery

/* Google analytics. */
$eros['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics

/* Sätt acronym variabeln */
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

/* Sidans header */
if($acronym) {
$eros['header'] = <<<EOD
<div id='minimenu'>
<p><a href='admin.php'>Logga ut<img src='img/logout.png' alt='' width='12' /></a>
<form action='search.php'><input type='text' name='search' placeholder='Sök på turer' />
<input class='searchbtn' type='submit' value='Sök' /></form>
</div>
EOD;
}
else {
  $eros['header'] = <<<EOD
<div id='minimenu'>
<form action='search.php'><input type='text' name='search' placeholder='Sök på turer' />
<input class='searchbtn' type='submit' value='Sök' /></form>
</div>
EOD;
}
$eros['header'] .= <<<EOD
<a href='home.php'><img class='sitelogo' src='img/logo.png' alt='RM Logo'/></a>
<p class='sitetitle'>Stockholm Nature Tourism</p>
<p class='siteslogan'>Bortom storstaden</p>
<hr>
EOD;

/* navigationsmenyn */


if($acronym) {
$eros['navbar'] = array(
  'items' => array(
    'hem' => 
    array('text'=>'Hem', 'url'=>'home.php', 'title' => 'presentation av företaget'),

     /* 'submenu' => array(
              'items' => array(
                // This is a menu item of the submenu
                'kmom01'  => array(
                  'text'  => 'Kmom01',   
                  'url'   => 'report.php#kmom01',  
                  'title' => 'kmom01'
                ),

                'kmom02'  => array(
                  'text'  => 'Kmom02',   
                  'url'   => 'report.php#kmom02',  
                  'title' => 'kmom02'
                ),
              ),
          ), */
    'tours' => 
    array('text'=>'Turer', 'url'=>'blog.php', 'title' => 'Våra turer'),
    'addnews' => 
    array('text'=>'Lägg till tur', 'url'=>'create.php', 'title' => 'addnews',),
    'adminnews' => 
    array('text'=>'Redigera tur', 'url'=>'view.php', 'title' => 'adminnews',),
    'about' => 
    array('text'=>'Om företaget', 'url'=>'about.php', 'title' => 'info om företaget',),
    
  ),
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);
}
else {
  $eros['navbar'] = array(
  'items' => array(
    'hem' => 
    array('text'=>'Hem', 'url'=>'home.php', 'title' => 'presentation av företaget'),
    'tours' => 
    array('text'=>'Turer', 'url'=>'blog.php', 'title' => 'Våra turer'),
    'about' => 
    array('text'=>'Om företaget', 'url'=>'about.php', 'title' => 'info om företaget'),


  ),
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);
}

/* sidans footer */

$eros['footer'] = <<<EOD
<footer>
<span class='sitefooter'>
<p>Copyright (C) 2014 | Stockholm Nature Tourism | Designed by Isa Jansson
</p>
</span>
</footer>

EOD;

/* inloggning till skolans databas  
$eros['database'] ['dsn']             = 'mysql:host=blu-ray.student.bth.se;dbname=isja13;';
$eros['database'] ['username']        = 'isja13';
$eros['database'] ['password']        = 'YQP=_8mW';
$eros['database'] ['driver_options']  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"); */

//inloggning till localhost databasen  
$eros['database'] ['dsn']             = 'mysql:host=localhost;dbname=movies;';
$eros['database'] ['username']        = 'root';
$eros['database'] ['password']        = 'isajansson0280';
$eros['database'] ['driver_options']  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"); 