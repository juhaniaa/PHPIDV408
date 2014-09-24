<?php

namespace view;

class cinemaView{
	private $model;
	
	public function __construct(\model\cinemaModel $model){
		$this->model = $model;
	}
	
	public function showMovieList(){
		
		$ret = "";
		
		$ret .= "<ul>";
		
		$movies = $this->model->getMovies();
		
		foreach ($movies as $movie) {
			$movieTitle = $movie->getTitle();
			$ret .= '<li>' . $movieTitle . '</li>';
			
		}
		
		$ret .= "</ul>";
		
		
		return $ret;
	}
	
}
