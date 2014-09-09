<?php

require_once("HTMLView.php");

session_start();

class LikeModel { // har hand om sessionen
	private $sessionLocation = "LikeModel::NumLikes";

	public function __construct(){
		if(isset($_SESSION[$this->sessionLocation]) == FALSE){
			
			$_SESSION[$this->sessionLocation] = 0;
		}		
	}
	
	public function getNumLikes(){
		return $_SESSION[$this->sessionLocation];
	}
	
	public function addLike(){
		$_SESSION[$this->sessionLocation] ++;	
	}
	
}

class LikeView { // har hand om det visuella som visas
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
		$ret .= "<form action='' method='post'>
		<input type='submit' value='Gilla!' name='iLike'/>
		</form>";
		
		if($this->didUserPressLike()){
			
			$ret .= "You Like!";
			header("Location : " . $_SERVER["PHP_SELF"]);
		} else {
			$ret .= $this->messages->load();
			
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
