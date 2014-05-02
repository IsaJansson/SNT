<?php

class CUser {
	protected $db;

	public function __construct($db) {
		$this->db=$db;
	}

	public function IsAuthenticated() {
		if(isset($_SESSION['user'])) {
			return true;
		}
		else {
			return false;
		}
	}

	public function AuthentificationOutput() {
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
 
		if($acronym) {
  			$output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
		}
		else {
  			$output = "Du är INTE inloggad.";
		}
		return $output;
	}


	public function Login($acronym, $password) {
            $sql = "SELECT acronym, name FROM USER WHERE acronym = ? AND password = md5(concat(?, salt));"; 
            $params = array();
    		$params = [htmlentities($acronym),  htmlentities($password)]; 
            $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params); 
            if(isset($res[0])) { 
                $_SESSION['user'] = $res[0]; 
                return true; 
            } 
            else{  
                return false; 
            }
 	}

 	 public function Logout() {
		unset($_SESSION['user']);
	}

}