<?php

namespace login\model;

require_once("Settings.php");

class LoginModel{
	
	private static $id = "uniqueId";
	private static $name = "name";
	private static $password = "password";
	private static $timestamp = "timestamp";
	private static $userTable = "CinUsers";
	private static $tempUserTable = "CinTempUsers";
	private static $cookieTimer = 300;
	
	public function __construct(){
		//$this->dbTable = self::$movieTable;
	}
	
	protected $dbConnection;
	protected $dbTable;
	
	protected function connection() {
		try{
		if ($this->dbConnection == NULL){
			$this->dbConnection = new \PDO(\Settings::$DB_CONNECTION, \Settings::$DB_USERNAME, \Settings::$DB_PASSWORD);
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} 
		
		return $this->dbConnection;
		
		} catch(PDOException $ex){
			var_dump($ex);
		
		}
	}
	
	public function getCookieTimer(){
		return self::$cookieTimer;
	}

	/*
	 * Check if db has the kombination of username and password
	 * @return success:bool
	 */
	public function loginUser($user, $pass, $clientId){
		
		$db = $this->connection();
		
		$sql = "SELECT * FROM " . self::$userTable . " WHERE " . self::$name . " = ? AND " . self::$password . " = ?";
		$params = array($user, $pass);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		$result = $query->fetch();
		
		if($result){
			$aip = $clientId[0];
			$bip = $clientId[1];
			$agent = $clientId[2];

			$_SESSION["logged"] = hash("sha256", $aip . $bip . $agent);
			$_SESSION["loggedUser"] = $user;
			return true;
		} else {
			return false;
		}		
	}
	
	public function logoutUser(){ 
		
		unset($_SESSION["logged"]);
		unset($_SESSION["loggedUser"]);
		return true;
	}
	
	public function loginCredentialsUser($user, $pass, $clientId){
		
		$db = $this->connection();
		
		$sql = "SELECT * FROM " . self::$tempUserTable . " WHERE " . self::$name . " = ? ORDER BY " . self::$timestamp . " DESC";
		$params = array($user);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		$result = $query->fetch();
		
		$now = time();
		$then = (int)$result[self::$timestamp];	
	
		if(($now - $then) <= self::$cookieTimer){
			
			return $this->loginUser($user, $pass, $clientId);
		} else {
			return null;
		}
	}
	
	public function insertUser($name, $pass){
		
		$db = $this->connection();
		
		$mdPass = md5($pass);
		
		$sql = "INSERT INTO " . self::$userTable . "(" . self::$name . ", " . self::$password . ") VALUES (?, ?)";
		$params = array($name, $mdPass);
		
		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	public function checkUniqueUser($name){
		
		$db = $this->connection();
		
		$sql = "SELECT * FROM " . self::$userTable . " WHERE " . self::$name . " = ?";
		$params = array($name);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		$result = $query->fetch();
		
		if($result){
			return false;
		} else {
			return true;
		}	
	}
	
	public function storeCookieTime($user){
		
		$time = time();
		
		$db = $this->connection();
		
		$sql = "INSERT INTO " . self::$tempUserTable . "(" . self::$name . ", " . self::$timestamp . ") VALUES (?, ?)";
		$params = array($user, $time);
		
		$query = $db->prepare($sql);
		$query->execute($params);	
	}
	
	public function getUserName(){
		return $_SESSION["loggedUser"];
	}
	
	public function isUserLogged($client){
		
		$aip = $client[0];
		$bip = $client[1];
		$agent = $client[2];
		
		$ident = hash("sha256", $aip . $bip . $agent);
		
		if(isset($_SESSION["logged"])){
			if($_SESSION["logged"] == $ident){
				return true;
			}
		} 
		return false;
	}
	
	public function checkNameLength($name){
		if(strlen($name) < 3){
			return false;
		} else{
			return true;
		}
	}
	
	public function checkPassLength($pass){
		
		$length = strlen($pass);
		
		if($length < 6){
			return false;
		} else{
			return true;
		}
		
	}
	
	public function nameInputValidation($name){
		$res = null;
				
		if (!ctype_alnum($name)) {
			$name = filter_var($name, FILTER_SANITIZE_STRING);
			$res = $name;			
		} 	
		
		return $res;
	}
	
	
	
	
}
