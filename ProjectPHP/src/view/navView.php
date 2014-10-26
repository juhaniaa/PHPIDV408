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
	public static $actionShowBookTicket = "ticket";
	public static $actionDoBookTicket = "getTicket";
	public static $actionShowAddMovie = "showAddMovie";
	public static $actionDoAddMovie = "doAddMovie";
	public static $actionDoAddShow = "doAddShow";
	
	// return main menu with correct action links
	public static function getMenu(){
		$html = "<div id='menu'><ul>";
		$html .="<li><a class='menuAtag' href='?" . self::$action . "=" . self::$actionShowStart . "'>Start</a></li>";
		$html .="<li><a class='menuAtag' href='?" . self::$action . "=" . self::$actionShowMovies . "'>Movies</a></li>";
		$html .="<li><a class='menuAtag' href='?" . self::$action . "=" . self::$actionShowShows . "&" . self::$show . "=" . self::getTodayDate() . "'>Shows</a></li>";
		$html .="</ul></div>";
		return $html;
	}
	
	/* ex 2014-11-03 */
	private static function getTodayDate(){
		return date("Y-m-d");
	}

	// return the user chosen action - go to start-page by default
	public static function getAction(){
		if(isset($_GET[self::$action])){
			return $_GET[self::$action];
		} else {
			return self::$actionShowStart;
		}
	}
	
	// return link with the show movie info action
	public static function getMovieNav($movieTitle, $movieId){
		$ret = '<a href="?' . self::$action . '=' . self::$actionShowMovieInfo . '&' . self::$movie . '=' . $movieId . '">' . $movieTitle . '</a>';
		return $ret;
	}
	
	// return link with the show book ticket action
	public static  function getTicketNav($showId){
		$ret = '<a href="?' . self::$action . '=' . self::$actionShowBookTicket . '&' . self::$ticket . '=' . $showId . '">Tickets</a>';
		return $ret;		
	}
	
	// return link with the add movie action
	public static  function getAddMovieNav(){
		$ret = '<a href="?' . self::$action . '=' . self::$actionShowAddMovie . '">Add Movie</a>';
		return $ret;		
	}
	
	// return id of chosen movie
	public static function getMovieId(){
		return $_GET[self::$movie];
	}
	
	// return value of user chosen date
	public static function getShowDate(){
		return $_GET[self::$show];
	}
	
	// return value posted date data
	public static function getSetShowDate(){
		return $_POST[self::$postDate];
	}
	
	// set data for show date and go there
	public static function setShowDate($showDate){
		header("Location: ?" . self::$action . "=" . self::$actionShowShows . "&" . self::$show . "=" . $showDate);
	}
	
	// go to start-page
	public static  function goToStart(){
		header("Location: ?" . self::$action . "=" . self::$actionShowStart);
	}
	
	// return id of chosen show
	public static function getShowId(){
		return $_GET[self::$ticket];
	}
}
