<?php

namespace model;

require_once("Movie.php");

class cinemaModel{
	
	private $movies = array();

	public function getMovies(){
		$this->movies[] = new Movie("Movie 1");
		$this->movies[] = new Movie("Movie 2");
		return $this->movies;
	}
}
