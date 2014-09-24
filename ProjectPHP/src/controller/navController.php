<?php

namespace controller;
require_once("./src/view/navView.php");
require_once("./src/controller/cinemaController.php");

class navController{
	public function doControll(){
		$controller;
		
		switch(\view\navView::getAction()){
			case \view\navView::$actionShowMovies;
				$controller = new cinemaController();
				return $controller->showMovies();
				break;
			
			case \view\navView::$actionShowShows;
				$controller = new cinemaController();
				return $controller->showShows();
			
			default:
				$controller = new cinemaController();
				return $controller->showStart();
				break;	
		}
	}	
}
