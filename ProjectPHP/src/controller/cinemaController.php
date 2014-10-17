<?php

namespace controller;
	
require_once("./src/model/cinemaModel.php");
require_once("./src/view/cinemaView.php");

class cinemaController {
	private $model;
	private $view;
	
	public function __construct(){
		$this->model = new \model\cinemaModel();
		$this->view = new \view\cinemaView($this->model);
	}
	
	public function showMovies(){
		/* UC 1.1 */
		$movieList = $this->model->getMovieList();
		return $this->view->showMovieList($movieList);
	}
	
	public function showStart(){
		/* UC 4.1 */
		return $this->view->showStart();
	}
	
	
	public function showShowsByDate(){
		/* UC 1.2 */
		$showDate = \view\navView::getShowDate();
		$showList = $this->model->getShowsByDateList($showDate);
		
		return $this->view->showShowList($showList, $showDate);
	}
	
	public function changeShowDate(){
		/* UC 1.2b */
		\view\navView::setShowDate(); // redirects via header->location
	}
	
	
	
	public function showMovieInfo(){
		/* UC 1.3 */
		$MovieId = \view\navView::getMovieId();
		$chosenMovie = $this->model->getMovieById($MovieId);
		$showList = $this->model->getShowsByMovieIdList($MovieId);
		return $this->view->showMovieInfo($chosenMovie, $showList);
	}
	
	public function bookTicket($role){
		
		$showId = \view\navView::getShowId();
		$chosenShow = $this->model->getShowById($showId);
	
		switch($role){
			
			case \model\Role::$customer;
				/* UC 1.4 */
				//if customer -> let book ticket
				return $this->view->showCustomerTicket($chosenShow);
				break;
				
			case \model\Role::$salesPerson;
				/* UC 2.6 */
				// if salesperson -> let book ticket for cashier-ticket
				return $this->view->showSalesTicket($chosenShow);
				break;
				
			case \model\Role::$administrator;
				return $this->view->showAdminTicket($chosenShow);
				break;
	
			default:
				return $this->view->showAnonTicket($chosenShow);
				break;	
		}
		
		
	}
	
	public function ticketIsSet(){
		$showId = $this->view->getTicketShow();
		$amount = $this->view->getTicketAmount();
		
		if($showId && $amount){
			return true;
		} else {
			return false;
		}
	}
	
	public function doReserveTicket($userId){
		
		$showId = $this->view->getTicketShow();
		$amount = $this->view->getTicketAmount();
		
		$result = $this->model->doReserveTicket($showId, $amount, $userId);
		
		if($result){
			return $this->view->showTicketReservedSuccess();
		} else{
			return $this->view->showTicketReservedError();
		}
		
	}
	
}