<?php

class LoginModel{
	
	public function __construct(){
		
	}
	/*
	 * Check if LoginModel.txt has the kombination of username and password
	 * */
	public function loginUser($user, $pass){
		
		//$fp = fopen("LoginModel.txt", "a");
		//fwrite($fp, $user . "-" . $pass ."\n");
		
		$lines = @file("LoginModel.txt");

		foreach($lines as $existingUser){
			
			$line = explode("-", $existingUser);
			
			$lineUser = $line[0];
			$linePass = $line[1];
			
			if($lineUser === $user){
	
				if($linePass === $pass){
					return true;
				} else {
					return false;
				}
			} else {
				return false;	
			}	
		}
	}
	
	public function isUserLogged(){
		/* 
		 * Checks session for user
		 */
		return true;
		
	}
}
