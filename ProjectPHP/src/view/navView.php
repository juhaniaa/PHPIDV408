<?php

namespace view;

class navView{
	private static $action = "action";
	private static $movie = "movie";
	private static $show = "showDate";
	private static $ticket = "showTicket";
	
	public static $postDate = "datepicker";
	
	public static $actionShowStart = "start";
	public static $actionShowMovies = "movies";
	public static $actionShowShows = "shows";
	public static $actionShowMovieInfo = "movie";
	public static $actionChangeShowDate = "changeDate";
	public static $actionBookTicket = "ticket";
	public static $actionDoTicket = "getTicket";
	
	public static function getMenu(){
		$html = "<div id='menu'><ul>";
		$html .="<li><a href='?" . self::$action . "=" . self::$actionShowStart . "'>Start</a></li>";
		$html .="<li><a href='?" . self::$action . "=" . self::$actionShowMovies . "'>Movies</a></li>";
		$html .="<li><a href='?" . self::$action . "=" . self::$actionShowShows . "&" . self::$show . "=" . self::getTodayDate() . "'>Shows</a></li>";
		$html .="</ul></div>";
		return $html;
	}
	
	/* ex 2014-11-03 */
	private static function getTodayDate(){
		return date("Y-m-d");
	}

	public static function getAction(){
		if(isset($_GET[self::$action])){
			return $_GET[self::$action];
		} else {
			return self::$actionShowStart;
		}
	}
	
	public static function getMovieNav($movieTitle, $movieId){
		$ret = '<a href="?' . self::$action . '=' . self::$actionShowMovieInfo . '&' . self::$movie . '=' . $movieId . '">' . $movieTitle . '</a>';
		return $ret;
	}
	
	/*public static function getDateNav(){
		$ret = '<li><a href="?' . self::$action . '=' . self::$actionShowShows . '&' . self::$show . '=';
		return $ret;
	}*/
	
	public function getTicketNav($showId){
		$ret = '<a href="?' . self::$action . '=' . self::$actionBookTicket . '&' . self::$ticket . '=' . $showId . '">Ticket</a>';
		return $ret;		
	}
	
	public static function getMovieId(){
		return $_GET[self::$movie];
	}
	
	public static function getShowDate(){
		return $_GET[self::$show];
	}
	
	public static function setShowDate(){
		$showDate = $_POST[self::$postDate];
		header("Location: ?" . self::$action . "=" . self::$actionShowShows . "&" . self::$show . "=" . $showDate);
	}
	
	public static function getShowId(){
		return $_GET[self::$ticket];
	}
}
