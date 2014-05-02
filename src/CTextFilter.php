<?php

use \michelf\MarkdownExtra;

class CTextFilter {

// function for converting bbcode to html
function bbcode2html($text) {
	$search = array(
		'/\[b\](.*?)\[\/b\]/is', 
    	'/\[i\](.*?)\[\/i\]/is', 
    	'/\[u\](.*?)\[\/u\]/is', 
    	'/\[img\](https?.*?)\[\/img\]/is', 
    	'/\[url\](https?.*?)\[\/url\]/is', 
    	'/\[url=(https?.*?)\](.*?)\[\/url\]/is'
	);

	$replace = array( 
	    '<strong>$1</strong>', 
	    '<em>$1</em>', 
	    '<u>$1</u>', 
	    '<img src="$1" />', 
	    '<a href="$1">$1</a>', 
	    '<a href="$1">$2</a>' 
    );
	return preg_replace($search, $replace, $text);
}

// make clickable links 
function make_clickable($text) {
	return preg_replace_callback(
		'#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
		create_function(
			'$matches',
			'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'),
		$text
		);
}

function markdown($text) {
	require_once(__DIR__ . '/php-markdown/Michelf/Markdown.php');
	require_once(__DIR__ . '/php-markdown/Michelf/MarkdownExtra.php');
	return MarkdownExtra::defaultTransform($text);
}

//function for filtering content 
function doFilter($text, $filters) {
	$all = array(
		'bbcode' => 'bbcode2html',
		'link' => 'make_clickable',
		'markdown' => 'markdown',
		'nl2br' => 'rowbreak',
	);

	$filter = preg_replace('/\s/', '', explode(',', $filters));
	foreach($filter as $val) {
		$text = $this->$all[$val]($text);
	}
	return $text;
}

public function rowbreak($text) { 
return nl2br($text); 
} 

}

