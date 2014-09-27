<?php

/* 1. Customer
	- UC 1.1 Customer views list of all availble movies
 		+ användaren vill se vilka filmer som finns just nu
	- UC 1.2 Customer views list of all shows ordered by date/time
		+ användaren vill se vad som visas just nu
	- UC 1.3 Customer views specific movie information
	- UC 1.4 Cusomter books tickets
	
2. Salesperson
	- UC 2.1 Salesperson views list of shows
	- UC 2.2 Salesperson views list of bookings to specific show
	- UC 2.3 Salesperson confirms booking
	
3. Administrator
	- UC 3.1 Administrator adds cinema
	- UC 3.2 Administrator adds movie
	- UC 3.3 Administrator adds show*/

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
		return $this->view->showMovieList();
	}
	
	public function showStart(){
		return $this->view->showStart();
	}
	
	public function showShows(){
		/* UC 1.2 */
		return $this->view->showShowList();
	}
	
	public function showMovieInfo(){
		/* UC 1.3 */
		return $this->view->showMovieInfo();
	}
	
}