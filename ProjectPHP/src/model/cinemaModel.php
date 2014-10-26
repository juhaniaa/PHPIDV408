<?php

namespace model;

require_once("Movie.php");
require_once("Show.php");
require_once("MovieRepository.php");
require_once("ShowRepository.php");
require_once("TicketRepository.php");

class cinemaModel{
	
	private $movies = array();
	private $shows = array();
	private $movieRepository;
	private $showRepository;
	private $ticketRepository;
	
	public function __construct(){
		$this->movieRepository = new MovieRepository();
		$this->showRepository = new ShowRepository();
		$this->ticketRepository = new TicketRepository();
	}
	
	public function getMovieList(){
		return $this->movieRepository->getAllMoviesList();
	}
	
	public function getMovieById($id){
		return $this->movieRepository->getMovieById($id);
	}
	
	public function getShowsByDateList($showDate){
		return $this->showRepository->getShowsByDateList($showDate);
	}
	
	public function getShowsByMovieIdList($movieId, $role){
		return $this->showRepository->getShowsByMovieIdList($movieId, $role);
	}
	
	public function getShowById($showId){
		return $this->showRepository->getShowById($showId);
	}
	
	public function doReserveTicket($showId, $amount, $userId){
		return $this->ticketRepository->doReserveTicket($showId, $amount, $userId);
	}
	
	public function doAddMovie($title, $description){
		return $this->movieRepository->doAddMovie($title, $description);
	}
	
	public function doAddShow($showDate, $showTime, $showMovieId){
		return $this->showRepository->doAddShow($showDate, $showTime, $showMovieId);
	}
	
	public function getMovieByTitle($title){
		return $this->movieRepository->getMovieByTitle($title);
	}
	
	public function checkDate($date){
		$d = \DateTime::createFromFormat('Y-m-d', $date);
    	$result = $d && $d->format('Y-m-d') == $date;
		return $result;
	}
	
	public function checkTicketAmount($amount){
		$result = is_numeric($amount);
		return $result;
	}
}
