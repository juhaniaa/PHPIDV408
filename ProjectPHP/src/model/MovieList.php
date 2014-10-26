<?php

namespace model;

require_once("Movie.php");

/* Collection of movies with type security */

class MovieList{
	
	private $movieList;
	
	public function __construct(){
		$this->movieList = array();
	}
	
	public function getList(){
		
		return $this->movieList;
	}
	
	public function add(Movie $movie){	
		if(!$this->contains($movie)){		
			$this->movieList[] = $movie;
		}
	}
	
	/* Check if movies already has the movie being added */
	public function contains(Movie $newMovie){
		foreach ($this->movieList as $key => $movie) {
			if($newMovie->getTitle() == $movie->getTitle()){
				return true;	
			}
		}
	}
	
	public function toArray(){
		return $this->movieList;
	}
}
