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
			$ret .= '<li>' . $movieTitle . '</li>';
		}
		
		$ret .= "</ul>";
			
		return $ret;
	}
	
	public function showShowList(){
		$ret = "<ul>";
		
		$shows = $this->model->getShows();
		
		foreach ($shows as $show) {
			$showInfo = $show->getInfo();
			$ret .= '<li>' . $showInfo . '</li>';
		}
		
		
		$ret .= "</ul>";
			
		return $ret;
		
	}
	
	public function showStart(){
		
		$ret = "<div>
			<h3>Welcome to the start page of this awesome cinema site</h3>
			</div>";
		
		return $ret;
	}
}
