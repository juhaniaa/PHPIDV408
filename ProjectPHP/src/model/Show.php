<?php

namespace model;

class Show{
	private $showDate = "20 sep 2014";
	private $movie;
	
	public function __construct(Movie $movie){
		$this->movie = $movie;
	}
	
	public function getInfo(){
		$info = "";
		$info .= $this->movie->getTitle();
		$info .= $this->showDate;
		return $info;
	}
}