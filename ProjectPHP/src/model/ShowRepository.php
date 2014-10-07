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
}
