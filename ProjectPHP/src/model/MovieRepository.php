<?php

namespace model;

require_once('./src/model/Movie.php');
require_once('./src/model/MovieList.php');
require_once('./src/model/Repository.php');

class MovieRepository extends base\Repository{
	private $movies;
	
	private static $key = "uniqueKey";
	private static $title = "title";
	private static $description = "description";
	private static $movieTable = "CinMovies";
	
	public function __construct(){
		$this->dbTable = self::$movieTable;
	}
	
	// add a movie to db
	public function doAddMovie($movieTitle, $movieDesc){
			
		$db = $this->connection();
		
		$sql = "INSERT INTO $this->dbTable (" . self::$title . ", " . self::$description . ") VALUES (?, ?)";
		$params = array($movieTitle, $movieDesc);
		
		$query = $db->prepare($sql);
		$result = $query->execute($params);
		
		if($result){
			return true;
		} else {
			return false;
		}	
	}
	
	// return a movie specified by id
	public function getMovieById($id){
		$db = $this->connection();
		
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " = ?";
		$params = array($id);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		$result = $query->fetch();
		
		if($result){
			$movie = new Movie($result[self::$title], $result[self::$key], $result[self::$description]);
			return $movie;
		} else {
			return null;
		}
	}
	
	
	
	// return a movie specified by title
	public function getMovieByTitle($title){
		$db = $this->connection();
		
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$title . " = ?";
		$params = array($title);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		$result = $query->fetch();
		
		if($result){
			$movie = new Movie($result[self::$title], $result[self::$key], $result[self::$description]);
			return $movie;
		} else {
			return null;
		}
	}
	
	// return list of all movies
	public function getAllMoviesList(){
		
		try{
			$db = $this->connection();
			
			$sql = "SELECT * FROM $this->dbTable";
				
			$query = $db->prepare($sql);
			
			$query->execute();
			
			$result = $query->fetchAll();
			
			$movieList = new MovieList();
			
			
			if($result){
				foreach ($result as $dbMovie) {
	
					$movie = new \model\Movie($dbMovie[self::$title], $dbMovie[self::$key], $dbMovie[self::$description]);

					$movieList->add($movie);
				}
				
				return $movieList;
				
			} else {
				return null;
			}
		} catch(PDOException $e){
			
		}	
	}
}
