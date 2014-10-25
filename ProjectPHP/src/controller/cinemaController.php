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
		\view\navView::setShowDate(); // redirects via header->location
	}
	
	public function goToStart(){
		\view\navView::goToStart(); // redirects via header->location
	}
	
	
	
	public function showMovieInfo(){
		/* UC 1.3 */
		$MovieId = \view\navView::getMovieId();
		$chosenMovie = $this->model->getMovieById($MovieId);

		$showList = $this->model->getShowsByMovieIdList($MovieId);
		return $this->view->showMovieInfo($chosenMovie, $showList);
	}
	
	public function showBookTicket(){
		
		$showId = \view\navView::getShowId();
		$chosenShow = $this->model->getShowById($showId);
		
		if($this->role !== \model\Role::$administrator){
			return $this->view->showTicket($chosenShow);
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function showAddMovie(){
		if($this->role === \model\Role::$administrator){
			return $this->view->showAddMovie();
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function doAddMovie(){
		if($this->role === \model\Role::$administrator){
			
			$movieTitle = $this->view->getAddMovieTitle();
			$movieDesc = $this->view->getAddMovieDesc();
			
			$result = $this->model->doAddMovie($movieTitle, $movieDesc);
			return $this->showMovies();
		} else {
			return $this->view->errorAccess();
		}
	}
	
	public function doAddShow(){
		if($this->role === \model\Role::$administrator){
			
			$showDate = $this->view->getAddShowDate();
			$showTime = $this->view->getAddShowTime();
			$showMovieId = $this->view->getAddShowId();
			
			$newShowId = $this->model->doAddShow($showDate, $showTime, $showMovieId);
			
			if($newShowId){
				return $this->showMovies();
			} else {
				return $this->view->errorAccess();
			}
	
		} else {
			return $this->view->errorAccess();
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

			
		
		if($this->role === \model\Role::$customer && $this->role === \model\Role::$salesPerson){
			$showId = $this->view->getTicketShow();
			$amount = $this->view->getTicketAmount();
			
			$result = $this->model->doReserveTicket($showId, $amount, $userId);
			
			if($result){
				return $this->view->showTicketReservedSuccess();
			} else{
				return $this->view->showTicketReservedError();
			}
		} else {
			return $this->view->errorAccess();
		}	
	}
}