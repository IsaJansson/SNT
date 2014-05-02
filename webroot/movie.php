<?php

/* including the important configuration file */
include(__DIR__.'/config.php');

/* site specific stylesheet */
$eros['stylesheets'][] = 'css/table.css';

/* create a connection to the database using php pdo */
$db = new CDatabase($eros['database']);
$movies = new CMovies($db);

/* site title */
$eros['title'] = 'Turer';

/* Get parameters */
$tr = $movies->GetTable();

$sqlDebug = $db->Dump();

$eros['main'] = <<<EOD
<br />
<table>
{$tr}
</table>

<div class=debug>{$sqlDebug}</div>
EOD;

include(EROS_THEME_PATH);

