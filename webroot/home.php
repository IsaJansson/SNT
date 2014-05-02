<?php 
include(__DIR__.'/config.php'); 
 
$eros['title'] = "Hem";
 
$db = new CDatabase($eros['database']);
$content = new CContent($db);

$posts = $content->getLatestPosts($db);

$eros['main'] = <<<EOD
<div id="content">
<p>Stockholm är omgivet av en fantastisk natur. Här finns djupa skogar, 
små glittrande sjöar blandat med öppna åkrar och ängar. Här finner du också 
Stockholms underbara skärgård  med mer än 30.000 öar, kobbar och skär. 
Stockholm NatureTourism hjälper dig att hitta lokala guider som arrangerar 
naturupplevelser i Stockholms närhet.</p>
</div>

EOD;


include(EROS_THEME_PATH);
