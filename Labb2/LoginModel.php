<?php

class LoginModel{
	
	public function __construct(){
		
	}

	/*
	 * Check if LoginModel.txt has the kombination of username and password
	 * @return success:bool
	 */
	public function loginUser($user, $pass){
				
		$success = false;
		
		$lines = @file("LoginModel.txt");

		foreach($lines as $existingUser){
			
			$line = explode("-", $existingUser);
			
			$lineUser = $line[0];
			$linePass = $line[1];
			
			if($lineUser === $user){ // if input is same as excisting user
				if($linePass === $pass){ //...and password is correct
					$success = true; // success
					
					// save session
					$_SESSION["logged"] = $user;
					
					return $success;
				} 
			} 
		}
		return $success;
	}
	
	public function loginCredentialsUser($user, $pass){
		
		$lines = @file("LoginDates.txt");
		
		foreach ($lines as $userLine) {
			
			$line = explode("-", $userLine);
			
			$lineUser = $line[0];
			$lineExp = $line[1];
			
			$now = time();
			
			$interval = $now - $lineExp;
	
			if($lineUser === $user){
				if($interval > 0){
					return $this->loginUser($user, $pass);
				}
			}
		}
		return false;
	}
	
	public function storeCookieDate($user, $expSeconds){
		
		$expTime = time() + $expTime;
		
		$fp = fopen("LoginDates.txt", 'a');
		fwrite($fp, $user . "-" . $expTime . "\n");
	}
	
	public function isUserLogged(){
		
		if(isset($_SESSION["logged"])){
			return $_SESSION["logged"];
		} else {
			return false;
		}
	}
	
	public function logoutUser(){ 
		
		unset($_SESSION["logged"]);
		return true;
	}
}
