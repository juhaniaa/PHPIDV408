<?php

namespace model;

class Show{
	private $showDate;
	private $movie;
	
	public function __construct(Movie $movie, \DateTime $showDate){
		$this->movie = $movie;
		$this->showDate = $showDate->format('d-m-Y H:i');
	}
	
	public function getInfo(){
		$info = $this->movie->getTitle();
		return $info;
	}
	
	public function getDateTime(){
		$ret = $this->showDate;
		return $ret;
	}

}