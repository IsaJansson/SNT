<?php 
include(__DIR__.'/config.php'); 

// Connect to a MySQL database using PHP PDO
$db = new CDatabase($eros['database']);
$content = new CContent($db);

function getUrlToContent($content) {
  switch($content->TYPE) {
    case 'page': return "page.php?url={$content->url}"; 
    case 'post': return "blog.php?slug={$content->slug}"; 
    default: return null; 
  }
}

// Get all content
$sql = 'SELECT *, (published <= NOW()) AS available FROM Content;';
$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Put results into a list
$items = null;
foreach($res AS $key => $val) {
  $items .= "<li><b>{$val->TYPE}</b> " . (!$val->available ? '(inte publicerad' : null) . " : " 
  . htmlentities($val->title, null, 'UTF-8') . " <a title='Redigera' href='edit.php?id={$val->id}'><img src='img/edit.png' alt='' width='25' /></a> <a title='Radera' href='delete.php?id={$val->id}'><img src='img/trashcan.png' alt='' width='25' /></a></li>\n";
}

// Do it and store it all in variables in the Anax container.
$eros['title'] = "Redigera";
$eros['debug'] = $db->Dump();

$eros['main'] = <<<EOD
<div class='blog'>
<br/>
<fieldset>

<ul>
{$items}
</ul>

</fieldset>
</div>
EOD;

include(EROS_THEME_PATH);