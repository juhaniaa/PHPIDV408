<?php

namespace common;

class CookieStorage {

	public function save($cookieName, $cookieInfo) {
		setcookie($cookieName, $cookieInfo, time()+3600);
		$_COOKIE[$cookieName] = $cookieInfo;
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