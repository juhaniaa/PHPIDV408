<?php

namespace view;

class CookieStorage {
	
	public function save($string){
		setcookie($string, $string, -1);
		
	}
	
	public function load() {
		$ret = isset($_COOKIE["CookieStorage"]) ? $_COOKIE["CookieStorage"] : "";
		
		setcookie("CookieStorage", "", time() -1);
		return $ret;
	}
	
}
