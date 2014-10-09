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
	
	public function showMovieInfo(\model\Movie $movie){
		
		$ret = "<ul>";
		//$MovieId = \view\navView::getMovieId();
		//$chosenMovie = $this->model->getMovieById($MovieId);
		$title = $movie->getTitle();
		$id = $movie->getId();
		$desc = $movie->getDescription();
		$ret .= "<li>Title: $title</li><li>Id: $id</li><li>Description: $desc</li>";
		$ret .= "</ul>";
		
		$ret .= "<h2>Shows</h2>";
		$ret .= "<ul>";
		$shows = $this->model->getShowsByMovie($MovieId);
		foreach ($shows as $show) {
			$showInfo = $show->getDateTime();
			$ret .= "<li>$showInfo</li>";
		}
		$ret .= "</ul>";
		return $ret;
		
	}
	
	public function showShowList(){
		$ret = "<ul>";
		
		$shows = $this->model->getShows();
		
		foreach ($shows as $show) {
			$showInfo = $show->getInfo();
			$showDate = $show->getDateTime();
			$ret .= '<li>' . $showInfo . ' ' . $showDate .'</li>';
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
