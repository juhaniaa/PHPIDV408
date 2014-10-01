<?php

class DAL {
	private $dbc;
	
	//Konstruktor
	public function __construct() {
		$this->dbc = new mysqli("aavanenprogramming.com.mysql", "aavanenprogramm", "jaba24163conn", "aavanenprogramm");
	}
	
	//Lägger till uppgifter om kakor (användarnamn, temporärt lösenord, tidpunkt kakorna sattes vid) i tabellen "TempUsers"
	public function insertEntries($userName, $tempPassword, $timeCookieWasSet){
		
		$escUserName = $this->dbc->real_escape_string($userName);
		$escTempPassword = $this->dbc->real_escape_string($tempPassword);
		$escTimeCookieWasSet = $this->dbc->real_escape_string($timeCookieWasSet);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			$this->dbc->query("INSERT INTO TempUsers (`ID`, `username`, `password`, `timestamp`) 
			VALUES (NULL, '$escUserName', '$escTempPassword', '$escTimeCookieWasSet')");
		}else{
			exit();
		}
	}	
	//Kontrollerar om angivna uppgifter finns i tabellen "UserData" eller om uppgifter i kakor finns i tabellen "TempUsers" 
	//(https://www.daniweb.com/web-development/php/threads/181577/validate-user-login)
	public function readEntries($userName, $password, $paramsAreCookies){
		
		$escUserName = $this->dbc->real_escape_string($userName);
		$escPassword = $this->dbc->real_escape_string($password);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			if($paramsAreCookies){
				$result = $this->dbc->query("SELECT * FROM TempUsers WHERE username='" . $escUserName . "'
				AND password='" . base64_decode($escPassword) . "'");
			}else{
				$result = $this->dbc->query("SELECT * FROM UserData WHERE username='" . $escUserName . "'
				AND password='" . $escPassword . "'");
			}
			if(mysqli_num_rows($result) === 1){
				return true;
			}else{
				return false;
			}
		}else{
			exit();
		}
	}
	//Hämtar tidpunkten kakorna sattes vid ur tabellen "TempUsers"
	//(http://stackoverflow.com/questions/13868591/php-mysqli-selecting-one-column-as-an-string-and-not-as-an-array)
	public function getTimeCookieWasSet($userName, $tempPassword){
		
		$escUserName = $this->dbc->real_escape_string($userName);
		$escTempPassword = $this->dbc->real_escape_string($tempPassword);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			$result = $this->dbc->query("SELECT * FROM TempUsers WHERE username='" . $escUserName . "'
			AND password='" . base64_decode($escTempPassword) . "'");
			$data = $result->fetch_array();
			$timeCookieWasSet = $data["timestamp"];
			return $timeCookieWasSet;
		}else{
			exit();
		}
	}
	//Tar bort uppgifter om kakor ur tabellen "TempUsers"
	public function deleteEntries($userName, $tempPassword){
		
		$escUserName = $this->dbc->real_escape_string($userName);
		$escTempPassword = $this->dbc->real_escape_string($tempPassword);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			$this->dbc->query("DELETE FROM TempUsers WHERE username='" . $escUserName . "' 
			AND password='" . base64_decode($escTempPassword) . "'");
		}else{
			exit();
		}
	}
	
	//Lägger till ny användares anv-namn och lösenord i tabellen UserData
	public function insertUser($userName, $password){
		$escUserName = $this->dbc->real_escape_string($userName);
		$escPassword = $this->dbc->real_escape_string($password);
		
		$utf8 = mysqli_set_charset($this->dbc, "utf8");
		
		if($utf8){
			$this->dbc->query("INSERT INTO UserData (`username`, `password`) 
			VALUES ('$escUserName', '$escPassword')");
		}else{
			exit();
		}
	}
}
