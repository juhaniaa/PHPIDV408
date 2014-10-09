<?php

namespace controller;

require_once("./src/view/navView.php");
require_once("./src/controller/cinemaController.php");

require_once("./login/view/loginView.php");
require_once("./login/controller/loginController.php");

class navController{
	public function doControll(){
		
		$loginController = new \login\controller\loginController();
		return $loginController->authenticate();
		
		// getTypeOfUser()
		
		// Customer
		
		// SalesPerson
		
		// Admin
		
		// Unlogged
		
		$controller;
		
		switch(\view\navView::getAction()){
			case \view\navView::$actionShowMovies;
				$controller = new cinemaController();
				return $controller->showMovies();
				break;
			
			case \view\navView::$actionShowShows;
				$controller = new cinemaController();
				return $controller->showShows();
				break;
				
			case \view\navView::$actionShowMovieInfo;
				$controller = new cinemaController();
				return $controller->showMovieInfo();
			
			default:
				$controller = new cinemaController();
				return $controller->showStart();
				break;	
		}
	}	
}
