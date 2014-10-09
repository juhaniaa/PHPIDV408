<?php

namespace model;

require_once("./src/model/Repository.php");

class ShowRepository extends base\Repository{
	private $shows;
	
	private static $key = "uniqueKey";
	private static $date = "date";
	private static $time = "time";
	private static $movieKey = "movieKeyFK";
	private static $showTable = "CinShows";
	
	public function __construct(){
		$this->dbTable = self::$showTable;
	}
	
	// return list of all movies
	public function getAllShowsList(){
		
		try{
			$db = $this->connection();
			
			$sql = "SELECT * FROM $this->dbTable";
				
			$query = $db->prepare($sql);
			
			$query->execute();
			
			$result = $query->fetchAll();
			
			$showList = new ShowList();
			
			// should a show only contain info for movie ID or a instance of movie?
			if($result){
				foreach ($result as $dbShow) {
	
					$show = new \model\Show($dbShow[self::$title], $dbShow[self::$key], $dbShow[self::$description]);

					$movieList->add($movie);
				}
				
				return $movieList;
				
			} else {
				return null;
			}
		} catch(PDOException $e){
			print "Error!: " . $e->getMessage() . "</br>";
			die();
		}
		
	}
	
	public function getShowsListByMovieId($id){
		$db = $this->connection();
		
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " = ?";
		$params = array($id);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		$result = $query->fetch();
		
		if($result){
			$movie = new \model\Movie($result[self::$title], $result[self::$key], $result[self::$description]);
			return $movie;
		} else {
			return null;
		}
	}
}
