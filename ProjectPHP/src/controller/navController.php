<?php

namespace controller;

require_once("./src/view/navView.php");
require_once("./src/controller/cinemaController.php");

require_once("./login/view/loginView.php");
require_once("./login/controller/loginController.php");

require_once("./src/view/AppContent.php");
require_once("./src/model/Role.php");

class navController{
	public function doControll(){
		
		/*
		 * $return \view\AppContent
		 * */
		
		$loginController = new \login\controller\loginController();
		$loginHtml = $loginController->authenticate();
		
		$role = $loginController->getRole();
				
		// Customer
		
		// SalesPerson
		
		// Admin
		
		// Unlogged
		
		$cinemaController = new cinemaController($role);
		
		switch(\view\navView::getAction()){
			/* UC 1.1 */
			case \view\navView::$actionShowMovies;
				$cinemaBody = $cinemaController->showMovies();
				break;
				
			case \view\navView::$actionChangeShowDate;
				/* UC 1.2b */
				$cinemaController->changeShowDate(); // redirects to self via header->location after changing the date
				break;
				
			case \view\navView::$actionShowShows;
				/* UC 1.2 */
				$cinemaBody = $cinemaController->showShowsByDate();
				break;
			
			case \view\navView::$actionShowMovieInfo;
				/* UC 1.3 */
				$cinemaBody = $cinemaController->showMovieInfo();
				break;
				
			case \view\navView::$actionBookTicket;
				/* UC 1.4 and UC 2.6 */
				$cinemaBody = $cinemaController->showBookTicket($role); // let user choose amount?
				break;	
				
			case \view\navView::$actionDoTicket;
				/* some1 pressed getTicket */
				
				$user = $loginController->getUser();
				
				if($cinemaController->ticketIsSet() && $user){
					$cinemaBody = $cinemaController->doReserveTicket($user);
				} else {
					$cinemaController->goToStart(); // redirects to self via header->location
				}
				
				break;	
				
			case \view\navView::$actionShowAddMovie;
				$cinemaBody = $cinemaController->showAddMovie();
				break;
				
			case \view\navView::$actionDoAddMovie;
				$cinemaBody = $cinemaController->doAddMovie();
				break;
				
			case \view\navView::$actionDoAddShow;
				$cinemaBody = $cinemaController->doAddShow();
				break;
			
			default:
				/* UC 4.1 */
				$cinemaBody = $cinemaController->showStart();
				break;	
		}
		
		return new \view\AppContent($loginHtml, $cinemaBody, $role);
	}	
}
