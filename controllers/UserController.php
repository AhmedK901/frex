<?php

Class UserController extends Controller {

	public function listCurrentUsers() {

		// set presentation type to plain-text format (content-type)
		Presentation::presentation_type('plain-text');

		// set users information array
		$users_info = UserModel::getCurrentUsersData();

		// output user information
		for ($i = 0; $i < count($users_info); $i++) {
			echo 'User ID: ' . $users_info[$i]['user_id'] . "\n";
			echo 'Username: ' . $users_info[$i]['user_name'] . "\n";
			echo 'User Email: ' . $users_info[$i]['user_email'] . "\n";

			if ($i != count($users_info) - 1) {
				echo '--------------------------------------' . "\n";	
			}
			
		}

	}

	public function listCurrentUsersInJson() {

		// set presentation type to json format (content-type)
		Presentation::presentation_type('application/json');

		// set users information array
		$users_info = UserModel::getCurrentUsersData();

		// output users information in json format
		Presentation::present_data($users_info, 'application/json');

	}

	public function listUser($data) {

		// get id by passing user id to model
		$user_id = UserModel::getUserInfo($data['id'], 'id');

		// output id
		echo 'ID: ' . $user_id . '<br>';

		// get username by passing user id to model
		$username = UserModel::getUserInfo($data['id'], 'username');

		// output username
		echo 'Username: ' . $username . '<br>';

		// get email by passing user id to model
		$email = UserModel::getUserInfo($data['id'], 'email');

		// output email
		echo 'Email: ' . $email . '<br>';


	}

	public function listUserInfoInJson($data) {

		// set presentation type to json format (content-type)
		Presentation::presentation_type('application/json');
		
		// set user information array
		$user_info = UserModel::getSpecificUserData($data['id']);

		// output user information in json format
		Presentation::present_data($user_info, 'application/json');

	}

}

?>
