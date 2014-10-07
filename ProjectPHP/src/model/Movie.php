<?php

namespace model;

class Movie{
	private $id;
	private $title;
	private $description;
	
	public function __construct($title, $id, $description){
		$this->title = $title;
		$this->id = $id;
		$this->description = $description;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getDescription(){
		return $this->description;
	}
}
