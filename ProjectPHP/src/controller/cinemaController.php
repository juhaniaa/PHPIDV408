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
	
}