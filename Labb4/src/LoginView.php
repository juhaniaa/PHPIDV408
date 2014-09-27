<?php

class LoginView {
	private $model;
	private $loginForm;
	private $logoutForm;
	
	//Konstruktor
	public function __construct(LoginModel $model) {
		$this->model = $model;
		$this->loginForm .= "
							<form action='index.php' method='post'>
							<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							<label>Namn: </label>
							<input type='text' name='userName' value='" . htmlspecialchars($_POST['userName']) . "'/>
							<label>Lösenord: </label>
							<input type='password' name='password'/>
							<label>Håll mig inloggad: </label>
							<input type='checkbox' name='stayLoggedOn'/>
							<input type='submit' name='loginButton' value='Logga in'/>
							</fieldset>
							</form>";
		$this->logoutForm .= "
							<form action='index.php' method='post'>
							<input type='submit' name='logoutButton' value='Logga ut'/>
							</form>";
	}

	//Visar Login-sida
	public function showLoginPage() {
		$ret .= "
				<h2>Ej inloggad</h2>" . $this->loginForm;
		return $ret;
	}
	//Visar meddelande vid utloggning
	public function showLoggedOffPage(){
		$ret .= "
				<h2>Ej inloggad</h2>
				<p>Du har nu loggat ut.</p>" . $this->loginForm;
		return $ret;
	}
	//Visar meddelande om användarnamn och/eller lösenord saknas eller är felaktigt
	public function showValidationPage($valResult){
		if($valResult == "nousername"){
			$ret .= "
				<h2>Ej inloggad</h2>
				<p>Användarnamn saknas</p>" . $this->loginForm;
		}if($valResult == "nopassword"){
			$ret .= "
				<h2>Ej inloggad</h2>
				<p>Lösenord saknas</p>" . $this->loginForm;
		}if($valResult == "userinvalid"){
			$ret .= "
				<h2>Ej inloggad</h2>
				<p>Användarnamn och/eller lösenord felaktigt.</p>" . $this->loginForm;
		}if($valResult == "cookieinvalid"){
			$ret .= "
				<h2>Ej inloggad</h2>
				<p>Felaktig information i cookie.</p>" . $this->loginForm;
		}
		return $ret;
	}
	//Visar inloggad-sida
	public function showLoggedOnPage($userName){
		$ret .= "
				<h2>" . $userName . " är inloggad</h2>" . $this->logoutForm;
		return $ret;
	}
	//Visar meddelande vid lyckad inloggning
	public function showJustLoggedOnPage($userName, $valResult){
		if($valResult == "uservalid"){
			$ret .= "
				<h2>" . $userName . " är inloggad</h2>
				<p>Inloggningen lyckades.</p>" . $this->logoutForm;
		}if($valResult == "uservalidcookies"){
			$ret .= "
				<h2>" . $userName . " är inloggad</h2>
				<p>Inloggning lyckades och vi kommer ihåg dig nästa gång.</p>" . $this->logoutForm;
		}
		if($valResult == "cookievalid"){
			$ret .= "
				<h2>" . $userName . " är inloggad</h2>
				<p>Inloggning lyckades via cookies.</p>" . $this->logoutForm;
		}
		return $ret;
	}
	//Hämtar användarens IP-address och webbläsare
	public function getServerInfo(){
		$aip = $_SERVER["REMOTE_ADDR"];
		$bip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		$agent = $_SERVER["HTTP_USER_AGENT"];
		return array($aip, $bip, $agent); 
	}
	//Hämtar användarnamn
	public function getUserName(){
		if(isset($_POST["userName"])){
			$userName = filter_var(trim($_POST["userName"]), FILTER_SANITIZE_STRING);
			return $userName;
		}else{
			exit();
		}
	}
	//Hämtar lösenord
	public function getPassword(){
		if(isset($_POST["password"])){
			$password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);
			return $password;
		}else{
			exit();
		}
	}
	//Hämtar värde i användarnamn-kaka
	public function getUserNameCookie(){
		if(isset($_COOKIE["LoginView::UserName"])){
			$userName = filter_var(trim($_COOKIE["LoginView::UserName"]), FILTER_SANITIZE_STRING);
			return $userName;
		}else{
			exit();
		}
	}
	//Hämtar värde i lösenord-kaka
	public function getPasswordCookie(){
		if(isset($_COOKIE["LoginView::Password"])){
			$password = filter_var(trim($_COOKIE["LoginView::Password"]), FILTER_SANITIZE_STRING);
			return $password;
		}else{
			exit();
		}
	}
	//Sätter kakor och returnerar den tidpunkt kakorna sattes vid
	public function setCookies($userName, $tempPassword){
		setcookie("LoginView::UserName", $userName, time() +300);
		setcookie("LoginView::Password", base64_encode($tempPassword), time() +300);
		$timeCookieWasSet = time();
		return $timeCookieWasSet;
	}
	//Tar bort kakor
	public function unsetCookies(){
		setcookie("LoginView::UserName", "", time() -3600);
		setcookie("LoginView::Password", "", time() -3600);
	}
	//Kontrollerar om kakor har satts
	public function cookiesAreSet(){
		if (isset($_COOKIE["LoginView::UserName"]) && isset($_COOKIE["LoginView::Password"])) {
			return true;
		} else{
			return false;
		}
	}
	//Kontrollerar om användaren klickat på "Logga in"
	public function userPressedLogon() {
		if(isset($_POST["loginButton"])){
			return true;
		}else{
			return false;
		}
	}
	//Kontrollerar om användaren valt alternativet "Håll mig inloggad"
	public function userStaysLoggedOn(){
		if(isset($_POST["stayLoggedOn"])){
			return true;
		}else{
			return false;
		}
	}
	//Kontrollerar om användaren klickat på "Logga ut"
	public function userPressedLogout() {
		if(isset($_POST["logoutButton"])){
			return true;
		}else{
			return false;
		}
	}
}
