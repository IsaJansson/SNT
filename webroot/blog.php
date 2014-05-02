<?php
include(__DIR__.'/config.php'); 
include(__DIR__.'/filter.php');

$db = new CDatabase($eros['database']);
$content = new CContent($db);
$blog = new CBlog($db);
$user = new CUser($db);
$filter = new CTextFilter();

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

$posts = $content->getShortPosts($db);

$eros['title'] = "Nyheter";
$eros['debug'] = $db->Dump();

$eros['main'] = null;
$res = $blog->GetPost();

if($slug) {
if(isset($res[0])) {
  foreach($res as $c) {

    // Sanitize content before using it.
    $title  = htmlentities($c->title, null, 'UTF-8');
    $data   = $filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
    $created = htmlentities($c->created, null, 'UTF-8');

      $eros['title'] = "$title | " . $eros['title'];
    
   
    $editLink = $acronym ? "<a title='Redigera posten' href='edit.php?id={$c->id}'><img src='img/edit.png' alt='' width='35' /></a>" : null;
    $deleteLink = $acronym ? "<a title='Radera posten' href='delete.php?id={$c->id}'><img src='img/trashcan.png' alt='' width='35' /></a>" : null;
    
    $eros['main'] .= <<<EOD
    <div id='posts'>
    <h3><a href='blog.php?slug={$c->slug}'>{$title}</h3>
    {$data}</a>
    {$editLink}
    {$deleteLink}
    </div>
EOD;
    }
}
}
else {
  $eros['main'] .= "{$posts}";
}


include(EROS_THEME_PATH);