<?php

namespace controller;

require_once("./src/view/navView.php");
require_once("./src/controller/cinemaController.php");

require_once("./login/view/loginView.php");
require_once("./login/controller/loginController.php");

require_once("./src/view/AppContent.php");
require_once("./src/model/Role.php");

class navController{
	/*
	 * $return \view\AppContent
	 * */
	public function doControll(){	
	
		$loginController = new \login\controller\loginController();
		$loginHtml = $loginController->authenticate();
		
		$role = $loginController->getRole();
		
		$cinemaController = new cinemaController($role);
		
		switch(\view\navView::getAction()){
			
			case \view\navView::$actionShowMovies;
				/* UC 1.1 Customer views list of all availble movies */
				$cinemaBody = $cinemaController->showMovies();
				break;
				
			case \view\navView::$actionChangeShowDate;
				/* UC 1.2b Customer views list of all shows on a specific date */
				$cinemaBody = $cinemaController->changeShowDate(); // redirects to self via header->location after changing the date - IF date is ok
				break;
				
			case \view\navView::$actionShowShows;
				/* UC 1.2 Customer views list of all shows for todays date */
				$cinemaBody = $cinemaController->showShowsByDate();
				break;
			
			case \view\navView::$actionShowMovieInfo;
				/* UC 1.3 Customer views specific movie information */
				$cinemaBody = $cinemaController->showMovieInfo();
				break;
				
			case \view\navView::$actionShowBookTicket;
				/* UC 1.4 Cusomter books tickets to specific show 
				 * UC 2.6 Salesperson books ticket on specific show for customer */
				$cinemaBody = $cinemaController->showBookTicket();
				break;	
				
			case \view\navView::$actionDoBookTicket;
				/* UC 1.4 Cusomter books tickets to specific show 
				 * UC 2.6 Salesperson books ticket on specific show for customer */
				$user = $loginController->getUser();
				
				// If there is a ticcket and a user
				if($cinemaController->ticketIsSet() && $user){
					$cinemaBody = $cinemaController->doReserveTicket($user);
				} else {
					$cinemaController->goToStart(); // redirects to self via header->location
				}		
				break;	
				
			case \view\navView::$actionShowAddMovie;
				/* UC 3.2 Administrator adds movie */
				$cinemaBody = $cinemaController->showAddMovie();
				break;
				
			case \view\navView::$actionDoAddMovie;
				/* UC 3.2 Administrator adds movie */
				$cinemaBody = $cinemaController->doAddMovie();
				break;
				
			case \view\navView::$actionDoAddShow;
				/* UC 3.3 Administrator adds show */
				$cinemaBody = $cinemaController->doAddShow();
				break;
			
			default:
				/* UC 4.1 User views start page */
				$cinemaBody = $cinemaController->showStart();
				break;	
		}
		
		return new \view\AppContent($loginHtml, $cinemaBody, $role);
	}	
}
