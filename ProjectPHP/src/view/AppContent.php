<?php

namespace view;

class AppContent{
	
	private $cinemaBody;
	private $loginHtml;
	
	public function __construct($loginHtml, $cinemaBody){
		$this->cinemaBody = $cinemaBody;
		$this->loginHtml = $loginHtml;
	}
	
	public function getCinemaBody(){
		return $this->cinemaBody;
	}
	
	public function getLoginHtml(){
		return $this->loginHtml;
	}
	
}
