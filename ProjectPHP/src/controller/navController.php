<?php

namespace controller;

require_once("./src/view/navView.php");
require_once("./src/controller/cinemaController.php");

require_once("./login/view/loginView.php");
require_once("./login/controller/loginController.php");

class navController{
	public function doControll(){
		
		/*$loginController = new \login\controller\loginController();
		return $loginController->authenticate();*/
		
		// getTypeOfUser()
		
		// Customer
		
		// SalesPerson
		
		// Admin
		
		// Unlogged
		
		$controller;
		
		switch(\view\navView::getAction()){
			/* UC 1.1 */
			case \view\navView::$actionShowMovies;
				$controller = new cinemaController();
				return $controller->showMovies();
				break;
				
			case \view\navView::$actionChangeShowDate;
				/* UC 1.2b */
				$controller = new cinemaController();
				$controller->changeShowDate(); // redirects to self via header->location after changing the date
				break;
				
			case \view\navView::$actionShowShows;
				/* UC 1.2 */
				$controller = new cinemaController();
				return $controller->showShowsByDate();
				break;
			
			case \view\navView::$actionShowMovieInfo;
				/* UC 1.3 */
				$controller = new cinemaController();
				return $controller->showMovieInfo();
			
			default:
				/* UC 4.1 */
				$controller = new cinemaController();
				return $controller->showStart();
				break;	
		}
	}	
}
