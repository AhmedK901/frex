<?php

Class UserModel extends Model {

	public function getCurrentUsersData() {

		// connect to database
		$database = new Database();

		// get user data from mysql query
		$userinfo = $database->query_assoc("SELECT user_id, user_name, user_email FROM users ORDER BY user_id ASC");

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
		$userdata = $database->query_assoc("SELECT user_id, user_name, user_email FROM users WHERE user_id = '$id'");

		// close database to controller
		$database->close();

		// return user data to controller
		return $userdata;
	}

	public function getUserInfo($id, $type) {

		// connect to database
		$database = new Database();

		// validata id GET variable
		$id = $database->validate($id);

		// get information from user id
		$info_type = $database->query_assoc("SELECT user_id, user_name, user_email FROM users WHERE user_id = '$id'");

		// close database connection
		$database->close();

		// return information type value to controller
		if ($type == 'username') {
			return $info_type[0]['user_name'];
		} else if ($type == 'email') {
			return $info_type[0]['user_email'];
		} else if ($type == 'id') {
			return $info_type[0]['user_id'];
		}
		

	}
}
?>
