<?php

/**
 *	Class: Database Class
 *	Handling MySQL database stuff in Frex micro-framework
**/

// include database configuration file
require_once 'database_config.php';

Class Database {

	// database setting
	private $db_host;
	private $db_name;
	private $db_user;
	private $db_pass;
	private $db_connect;
	private $expected_query = '';

	private function connect() {

		// include connection on private db_connect variable
		$this->db_connect = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

		// check for connection
		if ($this->db_connect->connect_error) {

			if (DEBUG_MODE == true) {
				die('Failed to connect to MySQL: ' . $this->db_connect->connect_error);
			} else {
				die('Failed to connect to MySQL.');
			}
			
		}

		$this->db_connect->query("SET NAMES utf8;");
		$this->db_connect->query("SET CHARACTER_SET utf8;");

	}

	private function query($query) {

		if (strlen($query) != 0) {
			// make a query
			$this->expected_query = $query;
		}
 	}


 	private function output() {
 		if (strlen($this->expected_query) != 0) {
 			$result = $this->db_connect->query($this->expected_query);
 			return $result;
 		}

 		return false;
 	}

 	private function output_value($value_num=null) {
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

	// constructor
	public function Database() {

		// set mysql configuration values
		$this->db_host = DB_HOST;
		$this->db_name = DB_NAME;
		$this->db_user = DB_USER;
		$this->db_pass = DB_PASS;

		// make a connection
		$this->connect();
	}

 	// return a value from mysql query (one value)
 	public function get_value_from_query($query) {
 		$this->query($query);
 		return $this->output_value();
 	}

 	// return data from mysql query (not specified number of values)
 	public function get_data_from_query($query) {
 		$this->query($query);
 		return $this->output();
 	}

 	// return asoociative data from mysql query (not specified number of values)
 	public function get_associative_data_from_query($query) {
 		$data = array();
 		$this->query($query);
 		$result = $this->output();
 		while ($row = $result->fetch_assoc()) {
 			$data[] = $row;
 		}
 		return $data;
 	}

 	// validate mysql query
 	public function validate($value) {
 		//$this->expected_query = mysqli_real_escape_string($this->expected_query);
 		return $this->db_connect->real_escape_string($value);
 	}

 	// clear last mysql query
 	public function clear() {
 		$this->expected_query = '';
 	}

 	// close database connection
 	public function close() {
 		$this->clear();
 		$this->db_connect->close();
 	}

}
?>
