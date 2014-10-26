<?php

namespace view;

class cinemaView{
	private $role;
	
	private static $ticketShow = "ticketShow";
	private static $ticketUser = "ticketUser";
	private static $ticketAmount = "ticketAmount";
	
	private static $addMovieTitle = "addMovieTitle";
	private static $addMovieDescription = "addMovieDesc";
	
	public static $addShowTime = "addShowTime";
	public static $addShowId = "addShowId";
	
	
	public function __construct($role){
		$this->role = $role;
	}
	
	/* HEADERS START */
	
	private function getMovieHeader(){
		return "<h1>Movies</h1>";
	}
	
	private function getShowHeader(){
		return "<h1>Shows</h1>";
	}
	
	private function getTicketHeader(){
		return "<h1>Tickets</h1>";
	}
	
	private function getStartHeader(){
		return "<h1>Welcome to the start page</h1>";
	}
	
	/* HEADERS END */
	
	/* SHOW START */
	
	public function showMovieList(\model\MovieList $movieList){
		$ret = $this->getMovieHeader();
		$ret .= "<ul>";
		
		foreach ($movieList->toArray() as $movie) {
			
			$movieTitle = $movie->getTitle();
			$movieId = $movie->getId();
			$movieDesc = $movie->getDescription();
			
			$movieNav = \view\navView::getMovieNav($movieTitle, $movieId);
			
			$ret .= "<li><h4>" . $movieNav . "</h4></li>";
		}
		
		if($this->role === \model\Role::$administrator){
			$ret .= "<form action='index.php?action=" . \view\navView::$actionShowAddMovie . "' method='post'>
					<input type='submit' value='Add new movie'> 
			</form>";
		}
		
		$ret .= "</ul>";
			
		return $ret;
	}
	
	public function showMovieInfo(\model\Movie $movie, \model\ShowList $showList){
		$ret = "";
		$title = $movie->getTitle();
		$id = $movie->getId();
		$desc = $movie->getDescription();
		$ret .= "<h1>$title</h1>
				<ul>
					<li>Description: $desc</li>
				</ul>
				<h2>Shows</h2>
				<ul>";
		
		$showList = $showList->toArray();
		if(count($showList) == 0){
			$ret .= "<li>No shows found for this movie</li>";
			
		} else {
			foreach ($showList as $show) {
				$showDate = $show->getShowDate();
				$showTime = $show->getShowTime();
				$ticketNav = "";
				
				if($this->role !== \model\Role::$administrator){ // dont show tickets to admins
					$ticketNav = \view\navView::getTicketNav($show->getShowId());
				} 
				$ret .= "<li>$showDate $showTime " . $ticketNav . "</li>";
			}		
		}
		
		if($this->role === \model\Role::$administrator){ // Admins may add shows to movies
				$ret .= $this->showAddShowForm($id);
			}
		
		$ret .= "</ul>";
		return $ret;	
	}

	public function showAddShowForm($movieId){
		return "<form action='index.php?action=" . \view\navView::$actionDoAddShow . "' method='post'>
					<label for='" . self::$addShowTime . "'>Time: </label>
					<input type='time' name='" . self::$addShowTime . "'>
					<label for='" . \view\navView::$postDate . "'>Date: </label>
					<input type='text' name='" . \view\navView::$postDate . "' id='" . \view\navView::$postDate . "'>
					<input type='hidden' name='" . self::$addShowId . "' value='$movieId'>	
					<input type='submit' value='Add Show'> 
				</form>";
	}
	
	public function showShowList(\model\ShowList $showList, $showDate){
		$ret = "";
		$ret .= $this->getShowHeader();

		// pick date form
		$ret .= "<form action='index.php?action=" . \view\navView::$actionChangeShowDate . "' method='post'>
					<label>Date: </label>
					<input type='text' name='" . \view\navView::$postDate . "' id='" . \view\navView::$postDate . "'>
					<input type='submit' value='Go to date'>
				</form>";
		
		$ret .= "<ul>";
		
		$showList = $showList->toArray();
		
		if(count($showList) == 0){
			$ret .= "<li>No shows found for this date</li>";
		} else {
			foreach ($showList as $show) {
			
				$movieId = $show->getMovieId();
				$movieTitle = $show->getTitle();
				
				$movieNav = \view\navView::getMovieNav($movieTitle, $movieId);
				
				$showTime = $show->getShowTime();
				$ticketNav = "";
				if($this->role !== \model\Role::$administrator){
					$ticketNav = \view\navView::getTicketNav($show->getShowId());
				}
				$ret .= '<li>' . $movieNav .' ' . $showTime . ' ' . $ticketNav . '</li>';
			}
		}

		$ret .= "</ul>";
			
		return $ret;		
	}
	
	public function showStart(){
		
		$ret = "";
		$ret .= $this->getStartHeader();
		$ret .= "
		<div>
		<div><h3>Winter special - get 2 tickets for the price of 1</h3><p>Now is your chance! During november and december we offer you two tickets for the price of one if you book your tickets from our site. Just register, login, choose your show and click tickets.</p></div>
		<div><h3>New movies for week 44</h3><p>We gladly present the week 44 list of movie premieres that will be showing here at our awesome cinema. Check out and book tickets for these movies: 'The Judge', '23 Blast', 'Fury' and 'Gone Girl'</p></div>
		<div><h3>Latest trailer - Avengers: Age of Ultron</h3><p>Check this epic trailer, we will be waiting for this one coming in 2015</p></div>
		</div>";
		
		return $ret;
	}
	
	public function showTicket(\model\Show $show){
		$ret = $this->getTicketHeader();
		$mTitle = $show->getTitle();
		$sDate = $show->getShowDate();
		$sTime = $show->getShowTime();
		$sId = $show->getShowId();
		
		$ret .= "<ul>
			<li>Movie: $mTitle</li>
			<li>Date: $sDate</li>
			<li>Time: $sTime</li>";
		
		if($this->role !== \model\Role::$administrator && $this->role !== \model\Role::$anonymous){
			$submit = "<input type='submit' value='Get Tickets'>";
		} else {
			$submit = "<h4>(You have to log in to book ticket)</h4>";
		}
			
		// book tickets form
		$ret .= "<form action='index.php?action=" . \view\navView::$actionDoBookTicket . "' method='post'>
					<label>Amount: </label>
					<input type='number' name='" . self::$ticketAmount . "' value='1' min='1' max='10'>
					<input type='hidden' name='" . self::$ticketShow . "' value='$sId'>
					" . $submit . "
				</form>";
				
		$ret .= "</ul>";
		
		return $ret;
	}
	
	public function showTicketReservedSuccess(){
		return "Your tickets have now been reserved. Please redeem your tickets 20 min before the show start.";
	}
	
	public function showTicketReservedError(){
		return "An error occured during the reservation please contact support";
	}
	
	public function showAddMovie(){
		$ret = "";
		$ret .= "<form action='index.php?action=" . \view\navView::$actionDoAddMovie . "' method='post'>
					<label for='" . self::$addMovieTitle . "'>Title: </label>
					<input type='text' name='" . self::$addMovieTitle . "' id='" . self::$addMovieTitle . "'>
					<label for='" . self::$addMovieDescription . "'>Description: </label>
					<input type='text' name='" . self::$addMovieDescription . "' id='" . self::$addMovieDescription . "'>
					<input type='submit' value='Add Movie'>
				</form>";
				
		return $ret;
	}
	
	/* SHOW END */
	
	/* INPUT START */
	
	public function getTicketShow(){
		return $_POST[self::$ticketShow];
	}
	
	public function getTicketAmount(){
		return $_POST[self::$ticketAmount];
	}
	
	public function getAddMovieTitle(){
		return $_POST[self::$addMovieTitle];
	}
	
	public function getAddMovieDesc(){
		return $_POST[self::$addMovieDescription];
	}
	
	public function getAddShowDate(){
		return $_POST[\view\navView::$postDate];
	}
	
	public function getAddShowTime(){
		return $_POST[self::$addShowTime];
	}
	
	public function getAddShowId(){
		return $_POST[self::$addShowId];
	}
	
	/* INPUT END */
	
	
	/* ERROR START */
	
	
	public function errorInvalidInput(){
		$ret = "<p>Invalid input was inserted</p>";
		
		return $ret;
	}
	
	public function errorAccess(){
		$ret = "<p>404 HTTP Page Not Found</p>";
		
		return $ret;
	}
	
	/* ERROR END */
}
