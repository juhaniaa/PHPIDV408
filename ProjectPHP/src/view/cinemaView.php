<?php

namespace view;

class cinemaView{
	private $model;
	
	private static $ticketShow = "ticketShow";
	private static $ticketUser = "ticketUser";
	private static $ticketAmount = "ticketAmount";
	
	
	public function __construct(\model\cinemaModel $model){
		$this->model = $model;
	}
	
	public function showMovieList(\model\MovieList $movieList){
		
		$ret = "<ul>";
		
		foreach ($movieList->toArray() as $movie) {
			
			$movieTitle = $movie->getTitle();
			$movieId = $movie->getId();
			$movieDesc = $movie->getDescription();
			
			$movieNav = \view\navView::getMovieNav($movieTitle, $movieId);
			
			$ret .= "<li>" . $movieNav . "</li>";
		}
		
		$ret .= "</ul>";
			
		return $ret;
	}
	
	public function showMovieInfo(\model\Movie $movie, \model\ShowList $showList){
		
		$ret = "<ul>";
		$title = $movie->getTitle();
		$id = $movie->getId();
		$desc = $movie->getDescription();
		$ret .= "<li>Title: $title</li><li>Description: $desc</li>";
		$ret .= "</ul>";
		
		$ret .= "<h2>Shows</h2>";
		$ret .= "<ul>";
		
		$showList = $showList->toArray();

		foreach ($showList as $show) {
			$showDate = $show->getShowDate();
			$showTime = $show->getShowTime();
			$ret .= "<li>$showDate $showTime " . \view\navView::getTicketNav($show->getShowId()) . "</li>";
		}
		
		$ret .= "</ul>";
		return $ret;
		
	}
	
	public function showShowList(\model\ShowList $showList, $showDate){
		$ret = "";

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
				$ret .= '<li>' . $movieNav .' ' . $showTime . ' ' . \view\navView::getTicketNav($show->getShowId()) . '</li>';
			}
		}

		$ret .= "</ul>";
			
		return $ret;		
	}
	
	public function showStart(){
		
		$ret = "<div>
			<h3>Welcome to the start page of this awesome cinema site</h3>
			<p>Advertising and latest news right here</p>
			</div>";
		
		return $ret;
	}
	
	public function getTicketShow(){
		return $_POST[self::$ticketShow];
	}
	
	
	public function getTicketAmount(){
		return $_POST[self::$ticketAmount];
	}
	
	public function showCustomerTicket(\model\Show $show){
		$mTitle = $show->getTitle();
		$sDate = $show->getShowDate();
		$sTime = $show->getShowTime();
		$sId = $show->getShowId();
		
		$ret = "<ul>
			<li>Movie: $mTitle</li>
			<li>Date: $sDate</li>
			<li>Time: $sTime</li>";
			
		$ret .= "<form action='index.php?action=" . \view\navView::$actionDoTicket . "' method='post'>
					<label>Amount: </label>
					<input type='number' name='" . self::$ticketAmount . "' value='1' min='1' max='10'>
					<input type='hidden' name='" . self::$ticketShow . "' value='$sId'>
					<input type='submit' value='Get Tickets'>
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
	
	public function showAdminTicket($show){
			
		$ret = "Not yet implemented";
		
		return $ret;
		
	}
	
	public function showSalesTicket($show){
			
		$ret = "Not yet implemented";
		
		return $ret;
		
	}
	
	public function showAnonTicket($show){
		$ret = "Not yet implemented";
		
		return $ret;
			
		
	}
}
