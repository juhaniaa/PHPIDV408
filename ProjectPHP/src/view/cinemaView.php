<?php

namespace view;

class cinemaView{
	private $model;
	
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
			
			$ret .= $movieNav;
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
			$ret .= "<li>$showDate $showTime</li>";
		}
		$ret .= "</ul>";
		return $ret;
		
	}
	
	public function showShowList(\model\ShowList $showList, $showDate){
		$ret = "";

		$ret .= "<form action='index.php?action=" . \view\navView::$actionChangeShowDate . "' method='post'>
					<label>Date: </label>
					<input type='text' name='" . \view\navView::$postDate . "' id='datepicker'>
					<input type='submit' value='Go to date'>
				</form>";
		
		$ret .= "<ul>";
		
		$showList = $showList->toArray();
		
		if(count($showList) == 0){
			$ret .= "<li>No shows found for this date</li>";
		} else {
			foreach ($showList as $show) {
				$showInfo = $show->getInfo();
				$showTime = $show->getShowTime();
				$ret .= '<li>' . $showInfo .' ' . $showTime . '</li>';
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
}
