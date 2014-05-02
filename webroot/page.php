<?php
include(__DIR__.'/config.php'); 

$db = new CDatabase($eros['database']);
$page = new CPage($db);
$textfilter = new CTextFilter();
$res = $page->GetPage();

$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
$editLink = $acronym ? "<a href='edit.php?id={$res->id}'>Uppdatera sidan</a>" : null;

$title = htmlentities($res->title, null, 'UTF-8');
$data = $textfilter->doFilter(htmlentities($res->DATA, null, 'UTF-8'), $res->FILTER);

$anax['title'] = $title;
$anax['debug'] = $db->Dump();

$eros['main'] = <<<EOD
<article>
<header>
<h1>{$title}</h1>
</header>

{$data}

<footer>
<br/>
{$editLink}
</footer
</article>

EOD;

include(EROS_THEME_PATH);