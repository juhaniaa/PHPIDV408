<?php

class LoginView {
	private $model;
	private $loginForm;
	private $logoutForm;
	private $registryForm;
	
	//Konstruktor
	public function __construct(LoginModel $model) {
		$this->model = $model;
		$userPost;
		
		if(isset($_POST["userName"])){
			$userPost = htmlspecialchars($_POST['userName']);
		} else if(isset($_POST["regName"])){
			$userPost = htmlspecialchars($_POST['regName']);
		}
		
		$this->loginForm .= "
							<form action='index.php' method='post'>
							<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							<label>Namn: </label>
							<input type='text' name='userName' value='" . $userPost . "'/>
							<label>Lösenord: </label>
							<input type='password' name='password'/>
							<label>Håll mig inloggad: </label>
							<input type='checkbox' name='stayLoggedOn'/>
							<input type='submit' name='loginButton' value='Logga in'/>
							<input type='submit' name='register' value='Registrera ny användare'/>
							</fieldset>";
		$this->logoutForm .= "
							<form action='index.php' method='post'>
							<input type='submit' name='logoutButton' value='Logga ut'/>
							</form>";
		$this->registryForm .= "
							<form action='index.php' method='post'>
							<fieldset>
							<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
							<label>Namn: </label>
							<input type='text' name='regName'/>
							<label>Lösenord: </label>
							<input type='password' name='regPassword'/>
							<label>Repetera Lösenord: </label>
							<input type='password' name='regRepeatPassword'/>
							<label>Skicka: </label>
							<input type='submit' name='doRegister' value='Registrera'/>
							</fieldset>";
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
	
	public function showRegisterPage(){
		$ret = "";
		
		$ret .= "<a href='index.php'>Tillbaka</a>";
		
		$ret .= "<h2>Ej inloggad, Registrerar användare</h2>";
		
		$ret .= $this->registryForm;
		
		return $ret;
	}
	
	public function showRegistrySuccess(){
		$ret = "";
		
		$ret .= "<h2>Registrering av ny användare lyckades</h2>";
		
		$ret .= $this->loginForm;
		
		return $ret;
		
	}
	
	public function showPasswordError(){
		
		$ret = "<h2>Passwords do not match</h2>";
		
		$ret .= $this->showRegisterPage();
		
		return $ret;
		
	}
	
	public function showError(){
		
		return $ret = "<h2>Random error occured</h2>";
		
	}
	
	public function showRegNameError(){
		
		$ret = "<h2>Användarnamnet har för få tecken. Minst 3 tecken</h2>";
		
		$ret .= $this->showRegisterPage();
		
		return $ret;
		
	}
	
	public function showRegPassError(){
		
		$ret = "<h2>Lösenord har för få tecken. Minst 6 tecken</h2>";
		
		$ret .= $this->showRegisterPage();
		
		return $ret;
		
	}
	
	public function showRegBothError(){
		
		$ret = "<h2>Användarnamnet har för få tecken. Minst 3 tecken</h2>";
		
		$ret .= "<h2>Lösenord har för få tecken. Minst 6 tecken</h2>";
		
		$ret .= $this->showRegisterPage();
		
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
	
	//Hämtar registrerings namn
	public function getRegName(){
		if(isset($_POST["regName"])){
			$regName = filter_var(trim($_POST["regName"]), FILTER_SANITIZE_STRING);
			return $regName;
		}else{
			exit();
		}
	}
	
	//Hämtar registrerings lösenord
	public function getRegPassword(){
		if(isset($_POST["regPassword"])){
			$regPassword = filter_var(trim($_POST["regPassword"]), FILTER_SANITIZE_STRING);
			return $regPassword;
		}else{
			exit();
		}
	}
	
	//Hämtar registrerings-repetitions lösenord
	public function getRegRepeatPassword(){
		if(isset($_POST["regRepeatPassword"])){
			$regRepeatPassword = filter_var(trim($_POST["regRepeatPassword"]), FILTER_SANITIZE_STRING);
			return $regRepeatPassword;
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
	
	//Kontrollerar om användaren klckat på "Registrera ny användare"
	public function userWantsToRegister(){
		if(isset($_POST["register"])){
			return true;
		} else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på "Registrera"
	public function userPressedRegister(){
		if(isset($_POST["doRegister"])){
			return true;
		} else{
			return false;
		}
	}
	

}
