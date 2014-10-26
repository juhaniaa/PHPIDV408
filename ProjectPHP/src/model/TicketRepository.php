<?php

namespace model;

require_once('./src/model/Repository.php');

class TicketRepository extends base\Repository{
	private $movies;
	
	private static $ticketKey = "uniqueTicket";
	private static $showKey = "uniqueShowFK";
	private static $userKey = "uniqueUserFK";
	private static $amount = "amount";
	private static $ticketTable = "CinTickets";
	
	public function __construct(){
		$this->dbTable = self::$ticketTable;
	}
	
	// add ticket to db
	public function doReserveTicket($showId, $amount, $userId){
		
		$db = $this->connection();
		
		$sql = "INSERT INTO $this->dbTable (" . self::$showKey . ", " . self::$userKey . ", " . self::$amount . ") VALUES (?, ?, ?)";
		$params = array($showId, $userId, $amount);
		
		$query = $db->prepare($sql);
		$result = $query->execute($params);
		
		if($result){
			return true;
		} else {
			return false;
		}
	}
}
