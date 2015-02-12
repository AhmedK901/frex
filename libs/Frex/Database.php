<?php

/**
 *	Class: Database Class
 *	Handling MySQL database stuff in Frex micro-framework
**/

Class Database {

	// database setting
	private $db_host;
	private $db_name;
	private $db_user;
	private $db_pass;
	private $db_connect;
	private $expected_query = '';

	// constructor
	public function Database($host, $user, $pass, $dbname) {
		$this->db_host = $host;
		$this->db_name = $dbname;
		$this->db_user = $user;
		$this->db_pass = $pass;

	}

	// connect to database
	public function connect() {

		// include connection on private db_connect variable
		$this->db_connect = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

		// check for connection
		if ($this->db_connect->connect_error) {
			die('Failed to connect to MySQL: ' . $this->db_connect->connect_error);
		}

		$this->db_connect->query("SET NAMES utf8;");
		$this->db_connect->query("SET CHARACTER_SET utf8;");


	}

	// write mysql query
	public function query($query) {
		if (strlen($query) != 0) {
			// make a query
			$this->expected_query = $query;
		}
 	}

 	// validate mysql query
 	public function validate($value) {
 		//$this->expected_query = mysqli_real_escape_string($this->expected_query);
 		return $this->db_connect->real_escape_string($value);
 	}

 	// execute mysql query
 	public function execute() {
 		if (strlen($this->expected_query) != 0) {
 			return $this->db_connect->query($this->expected_query);
 		}

 		return false;
 	}

 	// output query result
 	public function output() {
 		if (strlen($this->expected_query) != 0) {
 			$result = $this->db_connect->query($this->expected_query);
 			return $result;
 		}

 		return false;
 	}

 	// output on query value
 	public function output_value($value_num=null) {
 		if (strlen($this->expected_query) != 0) {
 			$result = $this->db_connect->query($this->expected_query);

 			if ($value_num == null) {
 				return $result->fetch_row()[0];
 			} else {
 				while ($row = $result->fetch_row()) {
	 				return $row[$value_num];
	 			}	
 			}
 			
 		}
 	}

 	// clear last mysql query
 	public function clear() {
 		$this->expected_query = '';
 	}
}
?>