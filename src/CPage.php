<?php

class CPage extends CContent {

	function __construct($db) {
		parent::__construct($db);
	}

	function GetPage() {
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$res = $this->SelectPage($url);
		return $res;
	}
}