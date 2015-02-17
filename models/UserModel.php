<?php

Class UserModel extends Model {

	public function getCurrentUsers() {

		// connect to database
		$database = new Database();

		// get user data from mysql query
		$data = $database->get_data_from_query("SELECT user_id, user_name, user_email FROM users ORDER BY user_id ASC");
		$userinfo = array();
		
		// push user information to array
		while ($row = $data->fetch_assoc()) {
			$userinfo[] = $row;
		}

		// close database connection
		$database->close();

		// return user information array
		return $userinfo;
	}

	public function getUserName($id) {

		// connect to database
		$database = new Database();

		// get username from user id
		$username = $database->get_value_from_query("SELECT user_name FROM users WHERE user_id = '$id'");

		// close database connection
		$database->close();

		// return username to controller
		return $username;

	}
}
?>