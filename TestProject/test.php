<?php

require_once("HTMLView.php");

session_start();

class LikeModel {
	private $sessionLocation = "LikeModel::NumLikes";
	
	public function __construct(){
		if(isset($_SESSION[$this->$sessionLocation]) == FALSE){
			
			$_SESSION[$this->$sessionLocation] = 0;
		}		
	}
	
	public function getNumLikes(){
		return $_SESSION[$this->$sessionLocation];
	}
	
	public function addLike(){
		$_SESSION[$this->$sessionLocation] ++;	
	}
	
}

class LikeView {
	private $model;
	
	public function __construct(LikeModel $model){ // dependancy injection
		$this->model = $model;	
	}
	
	public function didUserPressLike(){
		if(isset($_GET["iLike"]))
			return true;
		return false;
		
	}
	
	public function showLikes(){
		
		$likes = $this->model->getNumLikes();
		$ret = "Antalet likes är $likes";
		$ret .= "<a href='?iLike'>Like!</a>";
		
		if($this->didUserPressLike()){
			
			$ret .= "You Like!";
		}
		return $ret;
		
	}
}

class LikeController{
	private $view;
	private $model;
	
	public function __construct() {
		$this->model = new LikeModel();
		$this->view = new LikeView($this->model);
	}
	
	public function doControl(){
		
		if($this->view->didUserPressLike()){
			$this->model->addLike();
			
		}
		
		return $this->view->showLikes();
	}
	
}

$c = new LikeController();
$htmlBody = $c->doControl();

$view = new HTMLView();
$view->echoHTML($htmlBody);
