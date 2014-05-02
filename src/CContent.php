<?php	

class CContent {

	protected $db; 

	function __construct($db) {
		$this->db=$db;
	}

	function EditContent() {
		// Get parameters 
		$id = isset($_POST['id']) ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
		$title = isset($_POST['title']) ? $_POST['title'] : null;
		$slug = isset($_POST['slug']) ? $_POST['slug'] : null;
		$url = isset($_POST['url']) ? strip_tags($_POST['url']) : null;
		$data = isset($_POST['data']) ? $_POST['data'] : array();
		$type = isset($_POST['type']) ? strip_tags($_POST['type']) : array();
		$filter = isset($_POST['filter']) ? $_POST['filter'] : array();
		$published = isset($_POST['published']) ? strip_tags($_POST['published']) : array();
		$save = isset($_POST['save']) ? true : false;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

		// check if form was submitted 
		if($save) {
			$sql = 'UPDATE Content SET
			title = ?,
			slug = ?,
			url = ?,
			TYPE = ?,
			DATA = ?,
			FILTER = ?,
			published = ?,
			updated = NOW() 
			WHERE id = ?';
		$params = array($title, $slug, $url, $type, $data, $filter, $published, $id);
		$this->db->ExecuteQuery($sql, $params);
		return 'Informationen är nu spradad.';
		}

	}

	function DeleteContent($id) {
		$sql = 'DELETE FROM Content WHERE id = ? LIMIT 1';
		$params = array($id);
		$this->db->ExecuteQuery($sql, $params);
		header('Location: view.php?');

	}

	function CreateContent($title) {
		$sql = 'INSERT INTO Content (title) VALUES (?)';
		$params = array($title);
		$this->db->ExecuteQuery($sql, $params);
		$id = $this->db->LastInsertId();
		header('Location: edit.php?id=' . $id);
	}

	function RestoreContent() {
		$sql = "DROP TABLE IF EXISTS Content;";

		$this->db->ExecuteQuery($sql);

		$sql = "CREATE TABLE Content(
				id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
				slug CHAR(80) UNIQUE,
				url CHAR(80) UNIQUE,
				TYPE CHAR(89),
				title CHAR(80),
				DATA TEXT,
				FILTER CHAR(80),
				published DATETIME,
				created DATETIME,
				updated DATETIME,
				deleted DATETIME)
				ENGINE INNODB CHARACTER SET utf8;";

		$this->db->ExecuteQuery($sql);

		$sql = 	"INSERT INTO Content (slug, url, TYPE, title, DATA, FILTER, published, created) VALUES 
			('Tyresta', NULL, 'post', 'Vandring i Tyresta', 'Välkommen till en härlig kvällsvandring i Tyresta Naturreservat. Vår lokala guide visar vägen genom skog och över ängar och bjuder på kvällsfika vid en glittrande sjö. Vandringen är 5 km lång och tar ungefär 2 timmar.

Samlingsplatsen ligger ca 20 km söder om Stockholm. Du når den enkelt med buss eller bil.
Pris 150 SEK.

Mer information om resväg med mera får du via mail så snart du har bokat.', 'bbcode, markdown', NOW(), NOW()),
			('filmklubb', NULL, 'post', 'Filmklubb', 'Bokklubb låter ju bra tråkigt men däremot filmklubb verkar riktigt fett så vi tänkte försöka dra igång en sådan här. Filmklubben går ut på att de som sett dagens filmtips skriver vad de tycker om den (utan att avslöja för mycket så att desom inte sett filmen också kan läsa) och på så vis startas en diskussion här på bloggen om de olika filmerna som det tipsas om. Alla som tycker att det är en bra idé kan kasta sig in direkt. kör hårt!', 'bbcode, markdown', NOW(), NOW());";

		$this->db->ExecuteQuery($sql);
		return 'Databasen är nu återställd!';
	}

	function SelectFromTable($id) {
		// Select from table 
		$sql = 'SELECT * FROM Content WHERE id = ?';
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));

		if(isset($res[0])) {
			$c = $res[0];
			return $c;
		}
		else {
			die('Misslyckades: Det finns inget innehåll med angivet id' . $id);
		}
	}

	function SelectPage($url) {
		$sql = "SELECT * FROM Content WHERE TYPE = 'page' AND url = ? AND published <= NOW();";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($url));

		if(isset($res[0])) {
			$c = $res[0];
			return $c;
		}
		else {
			die('Misslyckades: Det finns inget sådant innehåll.');
		}
	}

	function SelectPost($slug) {
		$slugSql = $slug ? 'slug = ?' : '1'; 
		$sql = "SELECT * FROM Content WHERE TYPE = 'post' AND $slugSql AND published <= NOW() ORDER BY updated DESC;";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($slug));
		return $res;
	}

	function getLatestPosts($database) {
        $sql = "SELECT * FROM Content WHERE TYPE = 'post' ORDER BY updated DESC LIMIT 6;";
        $res = $database->ExecuteSelectQueryAndFetchAll($sql);
        $output = "<hr><div id='latestnews'><h4>Senaste nyheterna</h4></div><hr>";
      foreach ($res as $key => $value) {
            $output .= "<div id='latestposts'><li><a href='blog.php?slug=$value->slug'><p><b>$value->title</b><br />".substr($value->DATA, 0, 80)."...<br />Läs mer >></p></a></li></div>";
        }
        return $output;
    }

    function getShortPosts($database) {
        $sql = "SELECT * FROM Content WHERE TYPE = 'post' ORDER BY updated DESC;";
        $res = $database->ExecuteSelectQueryAndFetchAll($sql);
        $output = "<div id='latestnews'><h4>RM:s nyheter</h4></div><hr>";
      foreach ($res as $key => $value) {
            $output .= "<div id='latestposts'><li><a href='blog.php?slug=$value->slug'><p><b>$value->title</b><br />".substr($value->DATA, 0, 150)."...<br />Läs mer >></p></a></li></div>";
        }
        return $output;
    }


}