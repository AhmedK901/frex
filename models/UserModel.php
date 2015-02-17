<?php

Class UserModel extends Model {

	public function getUserID($id) {

		// connect to database
		$database = new Database();

		// get user if
		$id = $database->get_query_value("SELECT user_id FROM users WHERE user_id = '$id'");

		// output user id
		echo 'User ID: ' . $id;

		// close database connection
		$database->close();
	}
}
?>