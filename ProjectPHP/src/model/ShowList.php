<?php

namespace model;

require_once("Show.php");

/* Collection of shows with type security */

class ShowList{
	
	private $showList;
	
	public function __construct(){
		$this->showList = array();
	}
	
	public function getShowList(){
		return $this->showList;
	}
	
	public function addShow(Show $show){
			$this->showList[] = $show;
	}
	
	public function toArray(){
		return $this->showList;
	}
}
