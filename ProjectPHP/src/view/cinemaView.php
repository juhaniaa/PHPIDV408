<?php

namespace view;

class cinemaView{
	private $model;
	
	public function __construct(\model\cinemaModel $model){
		$this->model = $model;
	}
	
	public function showMovieList(){
		
		$ret = "<ul>";
		
		$movies = $this->model->getMovies();
	
		foreach ($movies as $movie) {
		
			$movieTitle = $movie->getTitle();
			$movieId = $movie->getId();
			$movieNav = \view\navView::getMovieNav($movieTitle, $movieId);
			$ret .= $movieNav;
		}
		
		$ret .= "</ul>";
			
		return $ret;
	}
	
	public function showMovieInfo(){
		
		$ret = "<ul>";
		$MovieId = \view\navView::getMovieId();
		$chosenMovie = $this->model->getMovieById($MovieId);
		$title = $chosenMovie->getTitle();
		$id = $chosenMovie->getId();
		$ret .= "<li>Title: $title</li><li>Id: $id</li>";
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
