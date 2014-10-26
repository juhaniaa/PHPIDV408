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
	private static $cookieTimer = 300; // cookie life-time limit
	
	private static $roleSession = "role";
	private static $loggedSession = "logged";
	private static $userSession = "loggedUser";
		
	protected $dbConnection;
	
	// set up connection to db
	protected function connection() {
		try{
		if ($this->dbConnection == NULL){
			$this->dbConnection = new \PDO(\Settings::$DB_CONNECTION, \Settings::$DB_USERNAME, \Settings::$DB_PASSWORD);
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} 		
		return $this->dbConnection;
		
		} catch(PDOException $ex){

		}
	}
	
	// returns the role of the user
	public function getRole(){
		if(isset($_SESSION[self::$roleSession])){
			return $_SESSION[self::$roleSession];
		} else {
			return \model\Role::$anonymous;
		}
	}
	
	// return name of user
	public function getUser(){
		return $_SESSION[self::$userSession];
	}
	
	// returns the value of how long cookies should last
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
			$role = $result[self::$roleSession];
			$userId = $result[$id];

			$_SESSION[self::$loggedSession] = hash("sha256", $aip . $bip . $agent);
			$_SESSION[self::$userSession] = $user;
			$_SESSION[self::$roleSession] = $role;
			
			return true;
		} else {
			return false;
		}		
	}
	
	// unsets login information from session
	public function logoutUser(){ 
		unset($_SESSION[self::$loggedSession]);
		unset($_SESSION[self::$userSession]);
		unset($_SESSION[self::$roleSession]);
		return true;
	}
	
	// login user with stored credentials
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
	
	// register new user to db
	public function insertUser($name, $pass){
		
		$db = $this->connection();
		
		$mdPass = md5($pass);
		
		$sql = "INSERT INTO " . self::$userTable . "(" . self::$name . ", " . self::$password . ") VALUES (?, ?)";
		$params = array($name, $mdPass);
		
		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// checks if user exists in db
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
	
	// store time when cookies are set in tempUsers table
	public function storeCookieTime($user){
		
		$time = time();
		
		$db = $this->connection();
		
		$sql = "INSERT INTO " . self::$tempUserTable . "(" . self::$name . ", " . self::$timestamp . ") VALUES (?, ?)";
		$params = array($user, $time);
		
		$query = $db->prepare($sql);
		$query->execute($params);	
	}
	
	// return user name
	public function getUserName(){
		return $_SESSION[self::$userSession];
	}
	
	// check if user is logged in to session
	public function isUserLogged($client){
		
		$aip = $client[0];
		$bip = $client[1];
		$agent = $client[2];
		
		$ident = hash("sha256", $aip . $bip . $agent);
		
		if(isset($_SESSION[self::$loggedSession])){
			if($_SESSION[self::$loggedSession] == $ident){
				return true;
			}
		} 
		return false;
	}
	
	// validation of name length
	public function checkNameLength($name){
		if(strlen($name) < 3){
			return false;
		} else{
			return true;
		}
	}
	
	// validation of password length
	public function checkPassLength($pass){
		
		$length = strlen($pass);
		
		if($length < 6){
			return false;
		} else{
			return true;
		}
		
	}
	
	// validation of name input
	public function nameInputValidation($name){
		$res = null;
				
		if (!ctype_alnum($name)) {
			$name = filter_var($name, FILTER_SANITIZE_STRING);
			$res = $name;			
		} 	
		
		return $res;
	}
}
