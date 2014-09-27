<?php

namespace model;

class Movie{
	private $title;
	private $id;
	
	public function __construct($title, $id){
		$this->title = $title;
		$this->id = $id;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getId(){
		return $this->id;
	}
}
