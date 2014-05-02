<?php

class CMovies {

	private $db;
	private $id = null;
	private $groupby;
	private $params = array();
	private $sqlOrig; 
    private $where;
    private $acronym = null;

	public function __construct($db) {
		$this->db=$db;

		if(isset($_GET['id']) && $_GET['id'] != null) {
             $this->id = $_GET['id'];
        }

        $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
	}

	function GetQueryString($options = array(), $prepend = '?') { 
    $query = array(); 
    parse_str($_SERVER['QUERY_STRING'], $query); 
    $query = array_merge($query, $options); 
    return $prepend . htmlentities(http_build_query($query)); 
	} 

	function OrderBy($column) {
		$nav = "<a href='" . $this->GetQueryString(array('orderby' => $column,'order' => 'asc')) . "'>&darr;</a>";
		$nav .= "<a href='" . $this->GetQueryString(array('orderby' => $column, 'order' => 'desc')) . "'>&uarr;</a>";
		return "<span class='orderby'>" .$nav . "</span>";
	}

	function EditMovie() {
		// Get parameters 
		$id = isset($_POST['id']) ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
		$title = isset($_POST['title']) ? $_POST['title'] : null;
		$price = isset($_POST['price']) ? $_POST['price'] : null;
		$plot = isset($_POST['plot']) ? $_POST['plot'] : null;
		$director = isset($_POST['director']) ? $_POST['director'] : null;
		$year = isset($_POST['year']) ? $_POST['year'] : null;
		$length = isset($_POST['length']) ? $_POST['length'] : null;
		$imdb = isset($_POST['imdb']) ? $_POST['imdb'] : null;
		$trailer = isset($_POST['trailer']) ? $_POST['trailer'] : null;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

			$sql = 'UPDATE Movie SET
			title = ?,
			price = ?,
			plot = ?,
			director = ?,
			LENGTH = ?,
			YEAR = ?,
			imdb = ?,
			trailer = ? 
			WHERE id = ?';
			/*$sql .='INSERT INTO Movie2Genre (idGenre, idMovie) VALUES (?, ?);';*/
		$params = array($title, $price, $plot, $director, $length, $year, $imdb, $trailer, $id);
		$this->db->ExecuteQuery($sql, $params);
		return 'Informationen är nu spradad.';
	}

	function CreateMovie($title) {
		$sql = 'INSERT INTO Movie (title) VALUES (?)';
		$params = array($title);
		$this->db->ExecuteQuery($sql, $params);
		$id = $this->db->LastInsertId();
		header('Location: editmovie.php?id=' . $id);
	}

	function DeleteMovie($id) {
		$sql = 'DELETE FROM Movie WHERE id = ? LIMIT 1';
		$params = array($id);
		$this->db->ExecuteQuery($sql, $params);
		header('Location: movie.php?');
	}

	function SelectFromTable($id) {
		// Select from table 
		$sql = 'SELECT * FROM Movie WHERE id = ?';
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));

		if(isset($res[0])) {
			$c = $res[0];
			return $c;
		}
		else {
			die('Misslyckades: Det finns inget innehåll med angivet id' . $id);
		}
	}

	function SelectGenreName($id) {
		// Select from table 
		$sql = 'SELECT DISTINCT G.name FROM Genre AS G INNER JOIN Movie2Genre AS M2G ON G.id = M2G.idGenre WHERE M2G.idMovie= ?;';
		$params = array($id);
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);

		return $res;
	}

	function SelectGenreId() {
		// Select from table 
		$sql = 'SELECT DISTINCT G.id FROM Genre AS G INNER JOIN Movie2Genre AS M2G ON G.id = M2G.idGenre WHERE M2G.idMovie= ?;';
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

		return $res;
	}

	function GetHitsPerPage($hits, $current = null) {
		$nav = "Träffar per sida: ";
		foreach ($hits AS $val) {
			if ($current == $val) {
				$nav .= "$val";
			}
			else {
				$nav .= "<a href='" . $this->GetQueryString(array('hits' => $val)) . "'>$val</a>";
			}
		}
		return $nav;
	}

	function GetPageNavigation($hits, $page, $max, $min = 1) { 
   		$nav = ($page != $min) ? "<a href='".$this->getQueryString(array('page' => $min))."'>&lt;&lt;</a>" : '&lt;&lt;'; 
    	$nav .= ($page > $min) ? "<a href='".$this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min)))."'>&lt;</a>" : '&lt;'; 

    	for ($i = $min; $i <= $max; $i++) { 
        	if ($page == $i) { 
            	$nav .= "$i "; 
        	} else { 
            	$nav .= "<a href='".$this->getQueryString(array('page' => $i)) ."'>$i</a> "; 
        	} 
    	} 

   		$nav .= ($page < $max) ? "<a href='".$this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max)))."'>&gt;</a>" : '&gt;'; 
    	$nav .= ($page != $max) ? "<a href='".$this->getQueryString(array('page' => $max))."'>&gt;&gt;</a> " : '&gt;&gt; '; 
    	return $nav; 
	}	

	function getMovie() {
         $sql = "SELECT * FROM Movie WHERE id = $this->id";
         $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
         
         $movie = "<h1>{$res[0]->title}</h1><span class='bild'><img src='{$res[0]->image}' width='270' height='400' /></span>
         <p class='infostring'>Regisserad av: <b>{$res[0]->director}</b></p>
         <p class='infostring'>Filmen är <b>{$res[0]->LENGTH}</b> min lång</p>
         <p class='infostring'>Filmen släpptes år<b> {$res[0]->YEAR}</b></p>
         <p class='infostring'><b>Teaser >></b><br />{$res[0]->plot}</p>
         <p class='links'><a title='Kolla in filmen på IMDB' href='{$res[0]->imdb}' target='blank'><img src='img/imdb.png' alt='imdb' width='40' /></a></p>
         <p class='links'><a title='Kolla in filmens trailer' href='{$res[0]->trailer}' target='blank'><img src='img/youtube.png' alt='trailer' width='43' /></a></p>";
         
         if($this->acronym != null){
             $movie .= "<p class='links'><a title='Uppdatera filmen' href='editmovie.php?id=$this->id'><img src='img/edit.png' alt='edit' width='45' /></a></p>
             <p class='links'><a title='Radera filmen' href='deletemovie.php?id=$this->id'><img src='img/trashcan.png' alt='trash' width='45' /></a></p>";
         }
		    $movie    	.= "<div id='imagesizes'><a href='img.php?src={$res[0]->image}&width=200'>Se en mindre bild</a><a href='img.php?src={$res[0]->image}&width=500'>Se en större bild</a></div>";

         return $movie;
     }

    function GetResMaxPages() { 
		$sql = "SELECT COUNT(id) AS rows FROM ($this->sqlOrig $this->where $this->groupby) AS Movie;";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $this->params); 
		return $res; 
	}

	function getSearchResult($database, $search) {
        $output = null;
        $sql = "SELECT * FROM Movie WHERE title LIKE ? OR director LIKE ?;";
            $res = $database->ExecuteSelectQueryAndFetchAll($sql, array($search, $search));
			foreach ($res as $key => $value) {
                $output .= "<a href='movie.php?id={$res[$key]->id}'><div class='searchres'><h2>{$res[$key]->title}</h2><p>{$res[$key]->director}</p></div></a><hr />";
            }
            return $output;
        }

	function GetTable() {

		$genres = $this->GetGenres();
		$genre = isset($_GET['genre']) ? $_GET['genre'] : null;
		$title = htmlentities(isset($_GET['title']) ? $_GET['title'] : null);
		$title = str_replace('*', '%', $title);
		$hits = isset($_GET['hits']) ? $_GET['hits'] : 16;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$yearfrom = isset($_GET['yearfrom']) && !empty($_GET['yearfrom']) ? $_GET['yearfrom'] : null;
		$yearto = isset($_GET['yearto']) && !empty($_GET['yearto']) ? $_GET['yearto'] : null;
		$orderby = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
		$order = isset($_GET['order']) ? strtolower($_GET['order']) : 'asc';

		is_numeric($hits) or die('Check: Hits must be numeric');
		is_numeric($page) or die('Check: Page must be numeric');
		is_numeric($yearfrom) || !isset($yearfrom) or die('Check: Year must be numeric or not set');
		is_numeric($yearto) || !isset($yearto) or die('Check: Year must be numeric or not set');
		
		$this->sqlOrig = ' SELECT M.*,
    	GROUP_CONCAT(G.name) AS genre FROM Movie AS M LEFT OUTER JOIN Movie2Genre AS M2G
     	ON M.id = M2G.idMovie INNER JOIN Genre AS G ON M2G.idGenre = G.id'; 

     	if($this->id){ return $this->getMovie(); break; }

		$this->where = null; 
		$this->groupby = ' GROUP BY M.id'; 
		$limit = null; 
		$sort = " ORDER BY $orderby $order"; 
		$this->params= array();

		/* search by title */
		if ($title) {
			$this->where .= ' AND title LIKE ?';
			$this->params[] = $title;
		}

		/* search by year */
		if ($yearfrom) {
			$this->where .= ' AND YEAR >= ?';
			$this->params[] = $yearfrom;
		}

		if ($yearto) {
			$this->where .= ' AND YEAR <= ?';
			$this->params[] = $yearto;
		}

		/* Search by genre */
		if($genre) {
 			$this->where .= ' AND G.name = ?';
  			$this->params[] = $genre;
		}	 

		/* page index */
		if ($hits && $page) {
			$limit = " LIMIT $hits OFFSET " . (($page - 1) * $hits);
		} 

		$this->where = $this->where ? " WHERE 1 {$this->where}" : null; 
		$sql = $this->sqlOrig . $this->where . $this->groupby . $sort . $limit; 
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $this->params);
		$hits = isset($_GET['hits']) ? $_GET['hits'] : 16;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$res2 = $this->GetResMaxPages();
		$rows = $res2[0]->rows;
		$max =  ceil($rows / $hits);

		$hitsPerPage = $this->GetHitsPerPage(array(4, 8, 16), $hits);
		$navigatePage = $this->GetPageNavigation($hits, $page, $max);
		

		/* create the HTML-table */
		$tr = "<form>
		<fieldset>
		<legend><b>Sök</b></legend>
		<div class='search'>
		<input type=hidden name=genre value='{$genre}'/>
		<input type=hidden name=hits value='{$hits}'/> 
		<input type=hidden name=page value='1'/> 

		<input type='search' name='title' value='{$title}' placeholder='Titel'/>
		<input type='text' name='yearfrom' value='{$yearfrom}' placeholder='Årtal från'/>
		-  
		<input type='text' name='yearto' value='{$yearto}' placeholder='Årtal till'/> 
		<input type='submit' name='submit' value='Sök'/>
		<a href='?'><b>Visa alla</b></a>
		<p><label><b>Välj genre:</b></label> {$genres}
		</p>
		</div>
		</fieldset>
		</form><br />
		<div id='hits'>{$hitsPerPage}</div>
		<tr><th>Id " . $this->orderby('id') . "</th><th>Bild</th><th>Titel " . $this->orderby('title') . "</th><th>År " . $this->orderby('year') . "</th><th>Handling</th><th>Genre</th><th>Pris</th></tr>"; 
		foreach ($res AS $key => $val) { 
   		 	$tr .= "<tr><td>{$val->id}</td><td><img width='80' height='110' src='{$val->image}' alt='{$val->title}' /></td><td><a href='movie.php?id={$val->id}'>{$val->title}</a></td><td>{$val->YEAR}</td><td>{$val->plot}</td><td>{$val->genre}</td><td>{$val->price}</td></tr>"; 
		} 
		$tr .= "<div id='navigate'>{$navigatePage}</div>";
	return $tr; 
	}

	function GetGenres() {
		$genre = isset($_GET['genre']) ? $_GET['genre'] : null;

		$sql = 'SELECT DISTINCT G.name FROM Genre AS G INNER JOIN Movie2Genre AS M2G ON G.id = M2G.idGenre;';
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

		$genres = null;
		foreach($res as $val) {
  			if($val->name == $genre) {
    			$genres .= "$val->name ";
  			}
  			else {
    			$genres .= "<a href='movie.php" . $this->GetQueryString(array('genre' => $val->name)) . "'>{$val->name}</a> ";
  			}
		}
		return $genres;
	}

	function getLatestMovies($database) {
        $sql = "SELECT * FROM Movie ORDER BY id DESC LIMIT 8;";
        $res = $database->ExecuteSelectQueryAndFetchAll($sql);
        $output = "<hr><div id='latestnews'><h4>Senaste filmerna</h4></div><hr>";
        foreach ($res as $key => $value) {
            $output .= "<div id='latestmovies'><a href='movie.php?id=$value->id'><img src='$value->image' width='130' height='200' alt='$value->title'/> </a></div>";
        }
        return $output;
    }
 
	
}
