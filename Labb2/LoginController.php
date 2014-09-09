<?php

require_once("LoginView.php");
require_once("LoginModel.php");

class LoginController{
	private $model;
	private $view;
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function authorize(){
		//var_dump($_POST);
		$answer = "";
		$credentials = array("","");
		// hantera indata - @returns true if user tries to log in
		if($this->view->userTryLogin()){
			
			$credentials = $this->view->getInputCredentials();
				
			$answer = $this->model->loginUser($credentials[0], $credentials[1]); // attempts to login user
			
		} 
		
		// generera utdata
		return $this->view->showLogin($answer, $credentials[0]);
	}
	
}
