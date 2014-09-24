<?php

namespace view;

class navView{
	private static $action = "action";
	
	public static $actionShowStart = "start";
	public static $actionShowMovies = "movies";
	public static $actionShowShows = "shows";
	
	public static function getMenu(){
		$html = "<div id='menu'><ul>";
		$html .="<li><a href='?" . self::$action . "=" . self::$actionShowStart . "'>Start</a></li>";
		$html .="<li><a href='?" . self::$action . "=" . self::$actionShowMovies . "'>Movies</a></li>";
		$html .="<li><a href='?" . self::$action . "=" . self::$actionShowShows . "'>Shows</a></li>";
		$html .="</ul></div>";
		return $html;
	}

	public static function getAction(){
		if(isset($_GET[self::$action])){
			return $_GET[self::$action];
		} else {
			return self::$actionShowStart;
		}
	}
}
