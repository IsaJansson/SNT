<?php
/* including the important configuration file */
include(__DIR__.'/config.php');

$db = new CDatabase($eros['database']);
$movie = new CMovies($db); 

$eros['title'] = "Sökresultat"; 

$query = isset($_GET['search']) ? $_GET['search'] : null;

$query = '%'.$query.'%';

$output = $movie->getSearchResult($db, $query);

$eros['main'] = <<<EOD
    <article>
        <h3>Sökresultat</h3>
        {$output}
    </article>
EOD;

include(EROS_THEME_PATH);