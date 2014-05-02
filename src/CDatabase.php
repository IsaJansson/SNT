<?php

class CDatabase {
	private $options;
	private $db	= null;
	private $stmt	= null;
	private static $numQueries = 0;
	private static $queries = array();
	private static $params = array();

	public function __construct($options) {
		$default = array(
			'dsn' => null,
			'username' => null,
			'password' => null,
			'driver_options' => null,
			'fetch_style' => PDO::FETCH_OBJ,
			);

		$this->options = array_merge($default, $options);
		$this->db = new PDO($this->options['dsn'], $this->options['username'], $this->options['password'], $this->options['driver_options']);
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->options['fetch_style']);

		if(isset($_SESSION['CDatabase'])) {
			self::$numQueries = $_SESSION['CDatabase'] ['numQueries'];
			self::$queries = $_SESSION['CDatabase'] ['queries'];
			self::$params = $_SESSION['CDatabase'] ['params'];
			unset($_SESSION['CDatabase']);
		}
	}

	public function ExecuteSelectQueryAndFetchAll($query, $params=array(), $debug=false) {
		self::$queries[] = $query;
		self::$params[] = $params;
		self::$numQueries++;

		if($debug) {
			echo "<p>Query = <br /><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>" . print_r($params, 1) . "</pre></p>";
		}

    	$this->stmt = $this->db->prepare($query); 
   		$this->stmt->execute($params); 
    	return $this->stmt->fetchAll();
	}

	public function ExecuteQuery($query, $params = array(), $debug=false) { 
	  
	    self::$queries[] = $query;  
	    self::$params[]  = $params;  
	    self::$numQueries++; 
	  
	    if($debug) { 
	      echo "<p>Query = <br/><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>"; 
    	} 
  
    	$this->stmt = $this->db->prepare($query); 
   		return $this->stmt->execute($params); 
  } 

    public function LastInsertId() { 
    	return $this->db->lastInsertid(); 
    }

	public function SaveDebug($debug=null) {
	  if($debug) { 
     	 self::$queries[] = $debug; 
     	 self::$params[] = null; 
    } 

    self::$queries[] = 'Saved debuginformation to session.'; 
    self::$params[] = null; 

    $_SESSION['CDatabase']['numQueries'] = self::$numQueries; 
    $_SESSION['CDatabase']['queries']    = self::$queries; 
    $_SESSION['CDatabase']['params']     = self::$params; 
	}

	public function Dump() {
		$html = '<p><i>You have made' . self::$numQueries . ' database queries.</i></p>';
		foreach(self::$queries as $key => $val) { 
      		$params = empty(self::$params[$key]) ? null : htmlentities(print_r(self::$params[$key], 1), null, 'UTF-8') . '<br/><br/>'; 
     		$html .= htmlentities($val, null, 'UTF-8') . '<br/><br/>' . htmlentities($params, null, 'UTF-8'); 
		}
	}
}