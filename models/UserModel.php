<?php

Class UserModel extends Model {

	public function getCurrentUsersData() {

		// connect to database
		$database = new Database();

		// get user data from mysql query
		$userinfo = $database->get_associative_data_from_query("SELECT user_id, user_name, user_email FROM users ORDER BY user_id ASC");

		// close database connection
		$database->close();

		// return user information array
		return $userinfo;
	}

	public function getSpecificUserData($id) {

		// connect to database
		$database = new Database();

		// validate id GET variable
		$id = $database->validate($id);

		// get user data from user id
		$userdata = $database->get_associative_data_from_query("SELECT user_id, user_name, user_email FROM users WHERE user_id = '$id'");

		// close database to controller
		$database->close();

		// return user data to controller
		return $userdata;
	}

	public function getUserName($id) {

		// connect to database
		$database = new Database();

		// validata id GET variable
		$id = $database->validate($id);

		// get username from user id
		$username = $database->get_value_from_query("SELECT user_name FROM users WHERE user_id = '$id'");

		// close database connection
		$database->close();

		// return username to controller
		return $username;

	}
}
?>