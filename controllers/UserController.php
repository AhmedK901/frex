<?php

Class UserController extends Controller {

	public function toMainPage() {
		
		// redirect to main page
		Controller::redirect('/main');
	}

	public function listCurrentUsers() {

		echo '## Current Users ##' . '<br>';

		// set user information array
		$userinfo = UserModel::getCurrentUsers();

		
		// list user information
		for ($i = 0; $i < count($userinfo); $i++) {
			echo 'User ID: ' . $userinfo[$i]['user_id'] . '<br>';
			echo 'Username: ' . $userinfo[$i]['user_name'] . '<br>';
			echo 'User Email: ' . $userinfo[$i]['user_email'] . '<br>';
			echo '--------------------------------------' . '<br>';
		}

	}

	public function printUserInfo($id) {
		$username = UserModel::getUserName($id);

		echo 'Username is ' . $username;

	}

}

?>