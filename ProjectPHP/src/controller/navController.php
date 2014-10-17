<?php

namespace controller;

require_once("./src/view/navView.php");
require_once("./src/controller/cinemaController.php");

require_once("./login/view/loginView.php");
require_once("./login/controller/loginController.php");

require_once("./src/view/AppContent.php");

class navController{
	public function doControll(){
		
		/*
		 * $return \view\AppContent
		 * */
		
		$loginController = new \login\controller\loginController();
		$loginHtml = $loginController->authenticate();
		
		// TODO: Different options for userTypes
		// TODO: also get type of user? - string in db?
				
		// Customer
		
		// SalesPerson
		
		// Admin
		
		// Unlogged
		
		$controller;
		
		switch(\view\navView::getAction()){
			/* UC 1.1 */
			case \view\navView::$actionShowMovies;
				$controller = new cinemaController();
				$cinemaBody = $controller->showMovies();
				break;
				
			case \view\navView::$actionChangeShowDate;
				/* UC 1.2b */
				$controller = new cinemaController();
				$controller->changeShowDate(); // redirects to self via header->location after changing the date
				break;
				
			case \view\navView::$actionShowShows;
				/* UC 1.2 */
				$controller = new cinemaController();
				$cinemaBody = $controller->showShowsByDate();
				break;
			
			case \view\navView::$actionShowMovieInfo;
				/* UC 1.3 */
				$controller = new cinemaController();
				$cinemaBody = $controller->showMovieInfo();
				break;
			
			default:
				/* UC 4.1 */
				$controller = new cinemaController();
				$cinemaBody = $controller->showStart();
				break;	
		}
		
		return new \view\AppContent($loginHtml, $cinemaBody);
	}	
}
