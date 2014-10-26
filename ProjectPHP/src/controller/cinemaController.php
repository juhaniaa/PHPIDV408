<?php

namespace controller;
	
require_once("./src/model/cinemaModel.php");
require_once("./src/view/cinemaView.php");

class cinemaController {
	private $model;
	private $view;
	private $role;
	
	public function __construct($role){
		$this->model = new \model\cinemaModel();
		$this->view = new \view\cinemaView($this->model, $role);
		$this->role = $role;
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
		$userShowDate = \view\navView::getSetShowDate();
		
		$okDate = $this->model->checkDate($userShowDate);
		
		if($okDate){
			\view\navView::setShowDate($userShowDate); // redirects via header->location
		} else {
			return $this->view->errorInvalidInput();
		}	
	}
	
	public function goToStart(){
		/* UC 4.1 */
		\view\navView::goToStart(); // redirects via header->location
	}
	
	public function showMovieInfo(){
		/* UC 1.3 */
		$MovieId = \view\navView::getMovieId();
		$chosenMovie = $this->model->getMovieById($MovieId);

		$showList = $this->model->getShowsByMovieIdList($MovieId, $this->role);
		return $this->view->showMovieInfo($chosenMovie, $showList);
	}
	
	public function showBookTicket(){
		/* UC 1.4 */
		$showId = \view\navView::getShowId();
		$chosenShow = $this->model->getShowById($showId);
		
		// admin does not have to see ticket
		if($this->role !== \model\Role::$administrator){
			return $this->view->showTicket($chosenShow);
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function showAddMovie(){
		/* UC 3.2 */
		if($this->role === \model\Role::$administrator){
			return $this->view->showAddMovie();
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function doAddMovie(){
		/* UC 3.2 */
		if($this->role === \model\Role::$administrator){ // only for admins
			
			$movieTitle = $this->view->getAddMovieTitle();
		
			$movieExists = $this->model->getMovieByTitle($movieTitle);
			
			if($movieExists){
				return $this->view->errorInvalidInput();
			} else{
				$movieDesc = $this->view->getAddMovieDesc();
				
				$result = $this->model->doAddMovie($movieTitle, $movieDesc);
				
				if($result){ // if insert was successful
					return $this->showMovies();
				} else {
					return $this->view->errorInvalidInput();
				}
			}
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function doAddShow(){
		/* UC 3.3 */
		if($this->role === \model\Role::$administrator){ // only for admins
			
			$showDate = $this->view->getAddShowDate();
			$showTime = $this->view->getAddShowTime();
			$showMovieId = $this->view->getAddShowId();
			
			$newShowId = $this->model->doAddShow($showDate, $showTime, $showMovieId);
			
			if($newShowId){ // if insert was successful
				return $this->showMovies();
			} else {
				return $this->view->errorAccess();
			}
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function ticketIsSet(){
		/* @return bool
		 * checks if a ticket is defined */
		$showId = $this->view->getTicketShow();
		$amount = $this->view->getTicketAmount();
		
		if($showId && $amount){
			return true;
		} else {
			return false;
		}
	}
	
	public function doReserveTicket($userId){
		/* UC 1.4 and UC 2.6 */	
		if($this->role === \model\Role::$customer || $this->role === \model\Role::$salesPerson){ // only for customer and salesperson
			$showId = $this->view->getTicketShow();
			$amount = $this->view->getTicketAmount();
			
			$okAmount = $this->model->checkTicketAmount($amount);
			
			if($okAmount){ // if valid amount
			
				$result = $this->model->doReserveTicket($showId, $amount, $userId);
				
				if($result){ // if reservation was successful
					return $this->view->showTicketReservedSuccess();
				} else{
					return $this->view->showTicketReservedError();
				}
			} else{
				return $this->view->errorInvalidInput();
			}
		} else {
			return $this->view->errorAccess();
		}	
	}
}