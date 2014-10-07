<?php

namespace model;

require_once("Movie.php");
require_once("Show.php");
require_once("MovieRepository.php");

class cinemaModel{
	
	private $movies = array();
	private $shows = array();
	private $movieRepository;
	
	public function __construct(){
		$this->movieRepository = new MovieRepository();
	}

	public function getMovies(){
		$this->setMovies();
		return $this->movies;
	}
	
	public function getMovieList(){
		return $this->movieRepository->getAllMoviesList();
	}
	
	public function getMovieById($id){
		return new Movie("Movie $id", $id, "Still static data");
	}
	
	public function getShows(){
		$this->setMovies();
		$this->setShows();
		return $this->shows;
	}
	
	public function getShowsByMovie($movieId){
		$this->movies[] = new Movie("Movie $movieId", $movieId, "Nice static");
		$this->setShows();
		return $this->shows;
	}
	
	/* temporary help-functions to create static data */
	private function setMovies(){
		$this->movies[] = new Movie("Movie 1", 1, "Nice static");
		$this->movies[] = new Movie("Movie 2", 2, "Cool static");	
	}
	
	private function setShows(){
		foreach ($this->movies as $movie) {
			
			$dateTime = \DateTime::createFromFormat('d/m/Y/H/i', '21/04/2015/14/30');
			
			$this->shows[] = new Show($movie, $dateTime);	
		}
	}
}
