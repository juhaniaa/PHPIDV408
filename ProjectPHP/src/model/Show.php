<?php

namespace model;

class Show{
	private $showDateTime;
	private $movie;
	
	public function __construct(Movie $movie, \DateTime $showDateTime){
		$this->movie = $movie;
		$this->showDateTime = $showDateTime;
	}
	
	public function getInfo(){
		$info = $this->movie->getTitle();
		return $info;
	}
	
	public function getShowDate(){
		$ret = $this->showDateTime->format("d/m/Y");
		return $ret;
	}
	
	public function getShowTime(){
		$time = $this->showDateTime->format("H:i");
		return $time;
	}
}