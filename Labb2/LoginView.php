<?php

class LoginView{
	private $model;
	
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	// did user press the "login" - button
	public function userTryLogin(){	
		if(isset($_GET["login"])){
			return true;
		} else {
			return false;
		}
	}
	
	public function getInputCredentials(){
		return array($_POST["LoginView::usrNameId"], $_POST["LoginView::passwordId"]);
	}
	
	public function showLogin($isLogged, $userName){
		$ret;
		$name = $userName;
		
		if($isLogged){
			
			$ret = '<h1>Welcome '. $name . '</h1>';
			
		} else {
			
			$ret = '<form action="?login" method="post">
			<fieldset><legend>Login - Input username and password</legend>
			<label for="usrNameId">Username:</label>
			<input type="text" name="LoginView::usrNameId" id="usrNameId">
			<label for="passwordId">Password:</label>
			<input type="password" name="LoginView::passwordId" id="passwordId"
			<label for="keepLoggedId">Save credentials:</label>
			<input type="checkbox" name="LoginView::Logged" id="keepLoggedId">
			<input type="submit" value="Log in">';
				
		}
		
		
		
		return $ret;
		
	}
	
}
