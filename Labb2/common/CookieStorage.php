<?php

class CookieStorage {

	public function save($cookieName, $cookieInfo) {
		setcookie($cookieName, $cookieInfo, time()+3600);
		setcookie("test", "another test", time()+3600);
	}

	public function load($cookieName) {
		
		if (isset($_COOKIE[$cookieName])){
			$ret = $_COOKIE[$cookieName];
		}
		
		else {
			$ret = "";
		}

		setcookie($cookieName, "", time() -1);

		return $ret;
	}
}