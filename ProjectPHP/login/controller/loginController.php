<?php

namespace login\controller;

require_once("./login/view/loginView.php");
require_once("./login/model/loginModel.php");

class LoginController{
	private $model;
	private $view;
	private $messageStorage = "cookieMessage";
	
	public function __construct(){
		$this->model = new \login\model\LoginModel();
		$this->view = new \login\view\LoginView($this->model);
	}
	
	public function authenticate(){
		
		// return a html representation of either logged in or logged out with possibility to log in
		// also return typeOfUser???

		// if user is  logged
		if($this->model->isUserLogged($this->view->getServerInfo())){
			
			/* Use Case 2 Logging out an authenticated user */
			return $this->logoutUser();
			
		// if user wants to register
		} else if($this->view->userGoRegister()){
			
			return $this->view->showRegisterPage();
		
		// if user tries to save new credentials
		} else if($this->view->userTryRegister()){
	
			return $this->doRegister();
	
		// if user is out logged and...
		} else {
			
			// ...has stored credentials
			if($this->view->hasStoredCredentials()){
				
				/* Use Case 3 Authentication with saved credentials */
				return $this->authCredUser();
				
			// ...does not have stored credentials
			} else {
				
				/* Use Case 1 Authenticate user */
				return $this->authUser();
			}
		}
	}

	/* Use Case 1 Authenticate user */
	public function authUser(){
			
		if($this->view->userTryLogin()){
			
		 	// UC 1 3: user provides username and password
			$inpName = $this->view->getInputName(false);
			
			if($inpName == null){
				$this->view->storeMessage("Användarnamn saknas");
				return $this->view->showLogin(false);
			}
			
			$inpPass = $this->view->getInputPassword(false);

			if($inpPass == null){
				$this->view->storeMessage("Lösenord saknas");
				return $this->view->showLogin(false);
			}
					
			// UC 1 3a: user wants system to keep user credentials for easier login
			$keepCreds = $this->view->keepCredentials();
			
			// UC 1 4: authenticate user...
			$answer = $this->model->loginUser($inpName, $inpPass, $this->view->getServerInfo());
			
			// UC 1 4a: user could not be authenticated
			if($answer === false){
				
				// 1. System presents an error message
				// 2. Step 2 in main scenario
				$this->view->storeUserInput($inpName);
				$this->view->storeMessage("Felaktigt användarnamn och/eller lösenord");
				return $this->view->showLogin(false);
				
			} else {
				
				if($keepCreds){
					
					// UC 1 3a-1: ...system presents that...the user credentials were saved
					$this->view->storeCredentials($inpName, $inpPass);
					$this->model->storeCookieTime($inpName);
					$this->view->storeMessage("Inloggning lyckades och vi kommer ihåg dig nästa gång");
					
				} else {
					
					// ...and present success message
					$this->view->storeMessage("Inloggningen lyckades");
				}	
				return $this->view->showLogin(true);
			}
		} else {
			
			// UC 1 1: user wants to authenticate
		 	// UC 1 2: system asks for username, password and if system should save the user credentials
			return $this->view->showLogin(false);
		}
	}
	
	/* Use Case 2 Logging out an authenticated user */
	public function logoutUser(){
		 
		// UC 2 3: User tells the system he wants to log out
		if($this->view->userTryQuit()){
			
			// UC 2 4: The system logs the user out and presents a feedback message
			$this->model->logoutUser();
			$this->view->removeCredentials();
			
			// does not /* redirects to self */
			$this->view->storeMessage("Du har blivit utloggad");
			return $this->view->showLogin(false);
			
		// UC 2 1: The system presents a logout choice	
		} else {
			return $this->view->showLogin(true);
		}
	}
	
	/* Use Case 3 Authentication with saved credentials */
	private function authCredUser(){
		
		// UC 3 1: User wants to authenticate with saved credentials
			// - System authenticates the user and presents that the authentication succeeded and that it happened with saved credentials
		$inpName = $this->view->getInputName(true);	
		$inpPass = $this->view->getInputPassword(true);

		$answer = $this->model->loginCredentialsUser($inpName, $inpPass, $this->view->getServerInfo());
		
		if($answer == null){
			$this->view->showLogin(false);
			
		} else if($answer == true){		
			$this->view->storeMessage("Inloggning lyckades via cookies");
			return $this->view->showLogin(true);
		} else {		
			// 2a. The user could not be authenticated (too old credentials > 30 days) (Wrong credentials) Manipulated credentials.
				// 1. System presents error message
				// Step 2 in UC 1				
			$this->view->removeCredentials();
			$this->view->storeMessage("Felaktig eller föråldrad information i cookie");
			return $this->view->showLogin(false);
		}
	}	
	
	//Starts when a user wants to create login-credentials
	public function doRegister(){
		
		$do = "";
		
		//User provides username and password
		$regName = $this->view->getRegName();
		$regPassword = $this->view->getRegPassword();
		$regRepeatPassword = $this->view->getRegRepeatPassword();
			
		$nameLengthOk = $this->model->checkNameLength($regName);
		$passLengthOk = $this->model->checkPassLength($regPassword);
			
		// if something is wrong, store message then show registry-page again
		if(!$nameLengthOk and $passLengthOk){
			$this->view->storeMessage("Användarnamnet har för få tecken. Minst 3 tecken");
			return $this->view->showRegisterPage();
			
		} elseif(!$passLengthOk and $nameLengthOk){
			$this->view->storeMessage("Lösenordet har för få tecken. Minst 6 tecken");
			return $this->view->showRegisterPage();
			
		} elseif(!$passLengthOk and !$nameLengthOk){
			$this->view->storeMessage("Användarnamnet har för få tecken. Minst 3 tecken och Lösenordet har för få tecken. Minst 6 tecken");
			return $this->view->showRegisterPage();
		}
		
		if($regPassword !== $regRepeatPassword){
			$this->view->storeMessage("Lösenorden matchar inte");
			return $this->view->showRegisterPage();
		}
		
		$badInput = $this->model->nameInputValidation($regName);
		
		if($badInput != null){
			$this->view->storeMessage("Användarnamnet innehåller felaktiga tecken");
			return $this->view->showRegisterPage();
		}
		
		$uniqueUser = $this->model->checkUniqueUser($regName);
		
		if(!$uniqueUser){
			$this->view->storeMessage("Användarnamnet är upptaget");
			return $this->view->showRegisterPage();
		}
	
		//If input is valid, system saves the credentials 
		$this->model->insertUser($regName, $regPassword);
		
		//and presents a success message
		$this->view->storeMessage("Registreringen lyckades");
		return $this->view->showLogin(false);
	
	}
}