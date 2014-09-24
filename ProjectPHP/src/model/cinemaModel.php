<?php

namespace model;

require_once("Movie.php");
require_once("Show.php");

class cinemaModel{
	
	private $movies = array();
	private $shows = array();

	public function getMovies(){
		$this->setMovies();
		return $this->movies;
	}
	
	public function getShows(){
		$this->setMovies();
		$this->setShows();
		return $this->shows;
	}
	
	private function setMovies(){
		$this->movies[] = new Movie("Movie 1");
		$this->movies[] = new Movie("Movie 2");	
	}
	
	private function setShows(){
		foreach ($this->movies as $movie) {
			$this->shows[] = new Show($movie);
		}
	}
}
