<?php

namespace login\view;

require_once("./common/CookieStorage.php");

class LoginView{
	
	private $cookieMessage = "cookieMessage";
	private $cookieUser = "cookieUser";
	private $message;
	private $model;
	private $svDay = array("Mon"=>"Måndag", "Tue"=>"Tisdag", "Wed"=>"Onsdag", "Thu"=>"Torsdag", "Fri"=>"Fredag", "Sat"=>"Lördag", "Sun"=>"Söndag");
	private $svMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Mars", "04"=>"April", "05"=>"Maj", "06"=>"Juni", "07"=>"Juli", "08"=>"Augusti", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"December");
	
	
	public function __construct(\login\model\LoginModel $model){
		$this->model = $model;
		$this->message = new \common\CookieStorage();
	}
	
	/* INPUT START */
	
	public function getClientIdentifier() {
		return $_SERVER["HTTP_USER_AGENT"];
	}
	
	//Hämtar användarens IP-address och webbläsare
	public function getServerInfo(){
		$aip = $_SERVER["REMOTE_ADDR"];
		$bip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		$agent = $_SERVER["HTTP_USER_AGENT"];
		return array($aip, $bip, $agent); 
	}
	
	// did user press "log in"
	public function userTryLogin(){		
		if(isset($_POST["login"])){
			return true;
		} else {
			return false;
		}
	}
	
	// did user press "log out"
	public function userTryQuit(){
		if(isset($_POST["logout"])){
			return true;
		} else {
			return false;
		}
	}
	
	// did user press "register new user"
	public function userGoRegister(){
		if(isset($_POST["register"])){
			return true;
		} else {
			return false;
		}
	}
	
	// did user try to save new user
	public function userTryRegister(){
		if(isset($_POST["doRegister"])){
			return true;
		} else {
			return false;
		}
	}
	
	// retrieve user input name or stored username
	public function getInputName($stored){
		if($stored){
			return $_COOKIE['loginUser'];
		} else {	
			if(isset($_POST["LoginView::usrNameId"]) and strlen(trim($_POST["LoginView::usrNameId"])) !== 0){
				$name = $_POST["LoginView::usrNameId"];
				return $name;
			} else {

				return null;
			}
		}
	}
	
	// retrieve user input password or stored
	public function getInputPassword($stored){
		
		if($stored){
			return $_COOKIE['loginPassword'];
		} else {
			
			if(isset($_POST["LoginView::passwordId"]) and strlen(trim($_POST["LoginView::passwordId"])) !== 0){	
		
				$pass = md5($_POST["LoginView::passwordId"]);
				return $pass;
			} else {
				
				$this->storeUserInput($_POST["LoginView::usrNameId"]);	
				return null;		
			}
		}
	}
	
	//Hämtar registrerings namn
	public function getRegName(){
		if(isset($_POST["regName"])){
			$regName = trim($_POST["regName"]);
			return $regName;
		}else{
			return "";
		}
	}
	
	//Hämtar registrerings lösenord
	public function getRegPassword(){
		if(isset($_POST["regPassword"])){
			$regPassword = trim($_POST["regPassword"]);
			return $regPassword;
		}else{
			return "";
		}
	}
	
	//Hämtar registrerings-repetitions lösenord
	public function getRegRepeatPassword(){
		if(isset($_POST["regRepeatPassword"])){
			$regRepeatPassword = trim($_POST["regRepeatPassword"]);
			return $regRepeatPassword;
		}else{
			return "";
		}
	}
	
	/* INPUT END */
	
	/* CREDENTIALS START */
	
	// does user have stored credentials
	public function hasStoredCredentials(){ 
		if(isset($_COOKIE["loginUser"]) and isset($_COOKIE["loginPassword"])){
			return true;
		} else {
			return false;
		}
	}
	
	// did user check to keep credentials
	public function keepCredentials(){
		if(isset($_POST["LoginView::Logged"])){
			return true;
		} else {
			return false;
		}
	}
	
	// store credentials
	public function storeCredentials($name, $pass){
		$timer = $this->model->getCookieTimer();
		setcookie("loginUser", $name, time() + $timer);
		setcookie("loginPassword", $pass, time() + $timer);
	}
	
	// remove credentials
	public function removeCredentials(){ 
		setcookie("loginUser", "", 1);
		setcookie("loginPassword", "", 1);
		return true;
	}
	
	/* CREDENTIALS END */
	
	/* COOKIE START */
	
	public function storeMessage($msg){		
		$this->message->save($this->cookieMessage, $msg);
		//header('Location: ' . $_SERVER['PHP_SELF']);
	}
	
	public function storeUserInput($userName){		
		$this->message->save($this->cookieUser, $userName);
		//header('Location: ' . $_SERVER['PHP_SELF']);
	}
	
	/* COOKIE END */
	
	/* SHOW START */
		
	// show login
	public function showLogin($usrLogged){
		
		$ret = "";
		
		$msg = $this->message->load($this->cookieMessage);
		
		$userInput = $this->message->load($this->cookieUser);
		
		if($usrLogged){
			
			$user = $this->model->getUserName();
			
			$ret .= "<h1>Welcome " . $user . "</h1>
			<p>" . $msg . "</p>
			<form action='index.php' method='post'>
				<input type='submit' name='logout' value='Log out'>
			</form>";
		
		} else {
		
			$ret .= '<h1>Ej inloggad</h1>
			<form action="index.php" method="post">
				<fieldset>
					<legend>Login - Input username and password</legend>
					<p>' . $msg . '</p>
					<label for="usrNameId">Username:</label>
					<input type="text" name="LoginView::usrNameId" id="usrNameId" value="' . $userInput . '">
					<label for="passwordId">Password:</label>
					<input type="password" name="LoginView::passwordId" id="passwordId">
					<label for="keepLoggedId">Save credentials:</label>
					<input type="checkbox" name="LoginView::Logged" id="keepLoggedId">
					<input type="submit" name="login" value="Log in">
					<input type="submit" name="register" value="Registrera ny användare"/>
				</fieldset>
			</form>';
			
		}
		
		$ret .= $this->showDate();
		return $ret;	
	}

	public function showRegisterPage(){
		$ret = "";
		
		$msg = $this->message->load($this->cookieMessage);
		
		$userInput = $this->message->load($this->cookieUser);
		
		$ret .= "<a href='index.php'>Tillbaka</a>";
		
		$ret .= "<h2>Ej inloggad, Registrerar användare</h2>";
		
		$ret .= "
		<form action='index.php' method='post'>
			<fieldset>
				<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
				<p>$msg</p>
				<label>Namn: </label>
				<input type='text' name='regName' value='" . $userInput . "'/>
				<label>Lösenord: </label>
				<input type='password' name='regPassword'/>
				<label>Repetera Lösenord: </label>
				<input type='password' name='regRepeatPassword'/>
				<label>Skicka: </label>
				<input type='submit' name='doRegister' value='Registrera'/>
			</fieldset>
		</form>";
		
		$ret .= $this->showDate();
		return $ret;
	}


	
	// show Date-message in swedish
	public function showDate(){
		return "<p>" . $this->svDay[date("D")] . ", den " . date("d") . " " . $this->svMonth[date("m")]  . " år " . date("Y") . ". Klockan är " . date("H:i:s") . ".</p>";
	}
	
	/* SHOW END */
	
}
