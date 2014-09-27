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
	
	public function getMovieById($id){
		return new Movie("Movie $id", $id);
	}
	
	public function getShows(){
		$this->setMovies();
		$this->setShows();
		return $this->shows;
	}
	
	public function getShowsByMovie($movieId){
		$this->movies[] = new Movie("Movie $movieId", $movieId);
		$this->setShows();
		return $this->shows;
	}
	
	/* temporary help-functions to create static data */
	private function setMovies(){
		$this->movies[] = new Movie("Movie 1", 1);
		$this->movies[] = new Movie("Movie 2", 2);	
	}
	
	private function setShows(){
		foreach ($this->movies as $movie) {
			
			$dateTime = \DateTime::createFromFormat('d/m/Y/H/i', '21/04/2015/14/30');
			
			$this->shows[] = new Show($movie, $dateTime);	
		}
	}
}
