<?php



require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController {
	private $model;
	private $view;
	
	//Konstruktor
	public function __construct() {
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function doLogin() {
		//Hämtar användarens IP-address och webbläsare
		$serverInfo = $this->view->getServerInfo();
		//Kontrollerar om användaren är inloggad
		if($this->model->userIsLoggedOn($serverInfo)){
			if($this->view->userPressedLogout()){
				if($this->view->cookiesAreSet()){
					$userName = $this->view->getUserNameCookie();
					$password = $this->view->getPasswordCookie();
					//Raderar data från tabellen "TempUsers" i databasen
					$this->model->deleteCookies($userName, $password);
					//Raderar kakor från webbläsaren
					$this->view->unsetCookies();
				}
				//Förstör sessionen
				$this->model->logoutUser();
				$ret = $this->view->showLoggedOffPage();
			}else{
				//Hämtar det användarnamn som är lagrat i sessionsvariabeln "userName"
				$userName = $this->model->getUserName();
				$ret = $this->view->showLoggedOnPage($userName);
			}
		//Kontrollerar om användaren försöker logga in via kakor	
		}elseif($this->view->cookiesAreSet()){
			$userName = $this->view->getUserNameCookie();
			$password = $this->view->getPasswordCookie();
			$paramsAreCookies = true;
			//Kontrollerar uppgifterna i kakorna mot tabellen "TempUsers" i databasen
			$cookieValResult = $this->model->validateUser($userName, $password, $paramsAreCookies);
				
			if($cookieValResult == "cookievalid"){
				$serverInfo = $this->view->getServerInfo();
				//Lagrar användarens IP-address och webbläsare i sessionsvariabeln "ident"
				$this->model->setServerInfo($serverInfo);
				$ret = $this->view->showJustLoggedOnPage($userName, $cookieValResult);
			}else{
				//Raderar kakor från webbläsaren
				$this->view->unsetCookies();
				$ret = $this->view->showValidationPage($cookieValResult);
			}
			
		//Kontrollerar om användaren vill gå till sidan för att registrera en användare
		}elseif($this->view->userWantsToRegister()){
				
			// Show registry form
			return $this->showRegisterPage();
			
		//Kontrollerar om användaren försöker registrera en användare
		}elseif($this->view->userPressedRegister()){
			
			// UC4. Register a new user
			return $this->doRegister();
		
		//Kontrollerar om användaren försöker logga in, visar annars login-sida	
		}else{
			if($this->view->userPressedLogon()){
				$userName = $this->view->getUserName();
				$password = $this->view->getPassword();
				//Kontrollerar att "username" och "password" inte är tomma
				$inputValResult = $this->model->validateInput($userName, $password);
				
				if($inputValResult == "inputvalid"){
					$paramsAreCookies = false;
					//Kontrollerar användarnamn och lösenord mot tabellen "UserData" i databasen
					$userValResult = $this->model->validateUser($userName, $password, $paramsAreCookies);
					
					if($userValResult == "uservalid"){
						$serverInfo = $this->view->getServerInfo();
						//Lagrar användarens IP-address och webbläsare i sessionsvariabeln "ident"
						$this->model->setServerInfo($serverInfo);
						
						//Kontrollerar om användaren valt alternativet "Håll mig inloggad"
						$userStaysLoggedOn = $this->view->userStaysLoggedOn();
						
						if($userStaysLoggedOn == true){
							//Genererar temporärt lösenord
							$tempPassword = $this->model->generatePassword();
							//Sätter kakor med användarnamn och temporärt lösenord och returnerar tidpunkten kakorna sattes vid
							$timeCookieWasSet = $this->view->setCookies($userName, $tempPassword);
							//Lagrar användarnamn, temporärt lösenord och tidpunkten kakorna sattes vid i tabellen "TempUsers" i databasen
							$this->model->insertCookies($userName, $tempPassword, $timeCookieWasSet);
							$userValResult = "uservalidcookies";
							$ret = $this->view->showJustLoggedOnPage($userName, $userValResult);
						}else{
							$ret = $this->view->showJustLoggedOnPage($userName, $userValResult);
						}
					//Visar att användarnamn och/eller lösenord är felaktigt	
					}else{
						$ret = $this->view->showValidationPage($userValResult);
					}
				//Visar att användarnamn och/eller lösenord saknas
				}else{
					$ret = $this->view->showValidationPage($inputValResult);
				}
			}else{
				$ret = $this->view->showLoginPage();
			}
		}
		return $ret;
	}

	//Funcktion som visar registreringsformulär
	public function showRegisterPage(){
		
		//System ask for username and password
		return $this->view->showRegisterPage();
	}

	//Starts when a user wants to create login-credentials
	public function doRegister(){
		
		//User provides username and password
		$regName = $this->view->getRegName();
		$regPassword = $this->view->getRegPassword();
		$regRepeatPassword = $this->view->getRegRepeatPassword();
		
		// if validation of name and password is ok...
		if(true){
			//System saves the credentials 
			$this->model->insertUser($regName, $regPassword);
			
			//and presents a success message
			return $this->view->showRegistrySuccess();
			
		} else{
			//4a. Credentials could not be registered (Username already used, wrong username format, Wrong password format.
			//1. System presents an error message
			//2. Step 2 in main scenario.
			
		}
	}		
}
