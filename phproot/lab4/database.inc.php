<?php
/*
 * Class Database: interface to the movie database from PHP.
 *
 * You must:
 *
 * 1) Change the function userExists so the SQL query is appropriate for your tables.
 * 2) Write more functions.
 *
 */
class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;

	/**
	 * Constructs a database object for the specified user.
	 */
	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}

	/**
	 * Opens a connection to the database, using the earlier specified user
	 * name and password.
	 *
	 * @return true if the connection succeeded, false if the connection
	 * couldn't be opened or the supplied user name and password were not
	 * recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database",
					$this->userName,  $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error = "Connection error: " . $e->getMessage();
			print $error . "<p>";
			unset($this->conn);
			return false;
		}
		return true;
	}

	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset($this->conn);
	}

	/**
	 * Execute a database query (select).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}

	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		try{
			$stmt = $this->conn->prepare($query);
			$stmt -> execute($param);
			$result = $stmt -> rowCount();
		}catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}


	public function getCookies(){
		$sql = "select cookieName from Cookies";
		$result = $this->executeQuery($sql);
		return $result;
	}


	public function bakeCookies($cookieName,$amount){
		$sqlRecipe = "select ingredient,amount from recipe where cookieName = ?";
		$sqlUpdate = "update RawMaterials set amount = amount - ? where name = ?";
		$sqlInserPallet = "insert into Pallets (timeMade, orderNbr, cookieName, blocked, sent) values(CURDATE(),NULL,?,False,False)";


		$resultCookies = $this->executeQuery($sqlRecipe, array($cookieName));

		foreach($resultCookies as $row){
			$this->executeUpdate($sqlUpdate,array($amount*$row[amount],$row[ingredient]));
		}

		for($i =0; $i < $amount; $i++){
			$this->executeUpdate($sqlInserPallet,array($cookieName));
		}

		return true;

	}

	public function blockPallets($cookieName, $minTime, $maxTime){
		$sqlPallets = "select palletNbr from Pallets where timeMade between ? and ? and cookieName = ? and blocked = false";
		$sqlUpdate = "update Pallets set blocked = true where palletNbr = ?";

		$resultPallets = $this -> executeQuery($sqlPallets, array($minTime, $maxTime, $cookieName));
		$count = 0;
		foreach($resultPallets as $row){
			$count += $this->executeUpdate($sqlUpdate,array($row[palletNbr]));
		}
		return $count;

	}

	public function getBlockedCookies(){
		$sql = "select distinct cookieName from pallets where blocked = true";
		return $this -> executeQuery($sql);
	}

	public function getBlockedPalletsByName($cookieName){
		$sql = "select palletNbr from pallets where cookieName = ? and sent = false and blocked = true";
		return $this -> executeQuery($sql,array($cookieName));
	}

	public function searchByPnbr($palletNbr){
		$sql = "select * from Pallets where palletNbr = ?";
		return $this -> executeQuery($sql,array($palletNbr));
	}


	public function getPalletsByName($cookieName){
		$sql = "select palletNbr from pallets where cookieName = ? and sent = false";
		return $this -> executeQuery($sql,array($cookieName));
	}

	public function getPalletsByInterval($min,$max){
		$sql = "select palletNbr from pallets where timeMade between ? and ?";
		return $this->executeQuery($sql,array($min,$max));
	}


	public function getPerformances($moviename){
		$sql = "select performanceDate from performances where moviename = ?";
		$result = $this->executeQuery($sql, array($moviename));
		return $result;

	}

	

	public function getPerformanceInfo($movieName,$performanceDate){
		$sql = "select * from performances where moviename = ? and performanceDate = ?";
		$result = $this->executeQuery($sql, array($movieName, $performanceDate));
		return $result;
	}

	
	public function bookTicket($userId,$movieName,$performanceDate){

		$sql = "select freeSeats from performances where moviename = ? and performanceDate = ? for update";
		$newReserv = "insert into Reservations(username,performanceDate,movieName) values(?,?,?)";
		$decSeats = "update Performances set freeSeats = freeSeats -1 where movieName = ? and performanceDate = ?";
		$this->conn->beginTransaction();
		$result = $this->executeQuery($sql, array($movieName, $performanceDate));
		
		foreach ($result as $row) {
			if($row[freeSeats]==0){
				$this->conn->rollback();
				return -1;
			}else{
				$this->executeUpdate($decSeats,array($movieName,$performanceDate));
				$this->executeUpdate($newReserv,array($userId,$performanceDate,$movieName));
				$reservNbr = $this->conn->lastInsertId();
				$this->conn->commit();
			}
		}


		return $reservNbr;
	}

	/*
	 * *** Add functions ***
	 */
}
?>
