<?php

require_once("src/DAL.php");

class LoginModel {
	private $dal;
	
	//Konstruktor
	public function __construct() {
		$this->dal = new DAL();
	}
	
	//Kontrollerar att användarens IP-adress och webbläsare är samma som de som är lagrade i sessionsvariabeln "ident"
	//(http://stackoverflow.com/questions/22880/what-is-the-best-way-to-prevent-session-hijacking) 
	public function userIsLoggedOn($serverInfo) {
		$aip = $serverInfo[0];
		$bip = $serverInfo[1];
		$agent = $serverInfo[2];
		
		$ident = hash("sha256", $aip . $bip . $agent);
		
		if ($ident != $_SESSION["ident"]){
			return false;
		}else{
			return true;
		}
	}
	//Returnerar det användarnamn som är lagrat i sessionsvariabeln "userName"
	public function getUserName(){
		$userName = $_SESSION["userName"];
		return $userName;
	}
	//Förstör sessionen (http://php.net/manual/en/function.session-destroy.php)
	public function logoutUser(){
		session_start();
		
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}
		session_destroy();
	}
	//Kontrollerar om "username" och/eller "password är tomma
	public function validateInput($userName, $password){
		if(empty($userName) && empty($password) || empty($userName)){
			return "nousername";
		}elseif(empty($password)){
			return "nopassword";
		}else{
			return "inputvalid";
		}
	}
	//Kontrollerar om angivna uppgifter eller kakor är korrekta
	public function validateUser($userName, $password, $paramsAreCookies) {
		
		//Kontrollerar angivna uppgifter eller kakor mot databasen
		$valResult = $this->dal->readEntries($userName, $password, $paramsAreCookies);

		if($paramsAreCookies){
			//Hämtar den tidpunkt kakorna sattes vid ur tabellen "TempUsers" i databasen
			$timeCookieWasSet = $this->dal->getTimeCookieWasSet($userName, $password);
			$timeNow = time();
			//Kontrollerar om kakorna har förfallit, dvs om det har gått mer än 5 minuter sedan de sattes
			if($valResult == true && ($timeNow - $timeCookieWasSet) <= 300){
				$_SESSION["userName"] = $userName;
				return "cookievalid";
			}else{
				return "cookieinvalid";
			}
		}else{
			if($valResult == true){
				$_SESSION["userName"] = $userName;
				return "uservalid";
			}else{
				return "userinvalid";
			}
		}
	}
	//Lagrar användarens IP-adress och webbläsare i sessionsvariabeln "ident"
	public function setServerInfo($serverInfo){
		$aip = $serverInfo[0];
		$bip = $serverInfo[1];
		$agent = $serverInfo[2];
		$_SESSION["ident"] = hash("sha256", $aip . $bip . $agent);
	}
	//Genererar temporärt lösenord (http://php.net/manual/en/function.str-shuffle.php)
	public function generatePassword(){
		$tempPassword = substr(str_shuffle("abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 10);
		return $tempPassword;
	}
	//Lägger till uppgifter om kakor i tabellen "TempUsers" i databasen
	public function insertCookies($userName, $tempPassword, $timeCookieWasSet){
		$this->dal->insertEntries($userName, $tempPassword, $timeCookieWasSet);
	}
	//Tar bort uppgifter om kakor i tabellen "TempUsers" i databasen
	public function deleteCookies($userName, $password){
		$this->dal->deleteEntries($userName, $password);
	}
}
