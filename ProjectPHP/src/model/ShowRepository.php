<?php

namespace model;

require_once("./src/model/Repository.php");
require_once("./src/model/ShowList.php");

class ShowRepository extends base\Repository{
	private $shows;
	
	private static $showDate = "sDate";
	private static $showTime = "sTime";
	private static $showKey = "uniqueShow";
	private static $movieTitle = "title";
	private static $movieDescription = "description";
	private static $movieKey = "uniqueKey";
	private static $movieShowView = "movie_shows";
	
	public function __construct(){
		$this->dbTable = self::$movieShowView;
	}
	
	// return list of all shows on a specific date
	
	// movie_shows view
	
	// get all rows with $showDate
	
	// then return a ShowList object which consists of an array of Shows where every Show contains a Date, Time and Movie object
	public function getShowsByDateList($showDate){
		
		try{
			$db = $this->connection();
			
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$showDate . " = ?";
			$params = array($showDate);
					
			$query = $db->prepare($sql);
			
			$query->execute($params);
			
			$result = $query->fetchAll();
			
			$showList = new ShowList();
			
			if($result){
	
				foreach ($result as $dbShow) {
										
					$movie = new Movie($dbShow[self::$movieTitle], $dbShow[self::$movieKey], $dbShow[self::$movieDescription]);
					
					$sDateTime = new \DateTime($dbShow[self::$showDate] . $dbShow[self::$showTime]);
					
					$show = new Show($movie, $sDateTime, $dbShow[self::$showKey]);

					$showList->addShow($show);
				}
				
				return $showList;
				
			} else {
				return $showList;
			}
		} catch(PDOException $e){
			print "Error!: " . $e->getMessage() . "</br>";
			die();
		}
	}
	
	public function getShowsByMovieIdList($id){
		try{
			$db = $this->connection();
			
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$movieKey . " = ?";
			$params = array($id);
					
			$query = $db->prepare($sql);
			
			$query->execute($params);
			
			$result = $query->fetchAll();
			
			if($result){
				
				$showList = new ShowList();
				
				foreach ($result as $dbShow) {
					
					$movie = new Movie($dbShow[self::$movieTitle], $dbShow[self::$movieKey], $dbShow[self::$movieDescription]);
					
					$sDateTime = new \DateTime($dbShow[self::$showDate] . $dbShow[self::$showTime]);
					
					$show = new Show($movie, $sDateTime, $dbShow[self::$showKey]);

					$showList->addShow($show);
				}
				
				return $showList;
				
			} else {
				return null;
			}
		} catch(PDOException $e){
			print "Error!: " . $e->getMessage() . "</br>";
			die();
		}
	}
	
	public function getShowById($showId){
		$db = $this->connection();
		
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$showKey . " = ?";
		$params = array($showId);
		
		$query = $db->prepare($sql);
		$query->execute($params);
	
		$result = $query->fetch();

		
		if($result){
			$movie = new Movie($result[self::$movieTitle], $result[self::$movieKey], $result[self::$movieDescription]);
			$sDateTime = new \DateTime($result[self::$showDate] . $result[self::$showTime]);
			$show = new Show($movie, $sDateTime, $result[self::$showKey]);
			return $show;
		} else {
			return null;
		}
	}
}
