<?php

Class UserController extends Controller {

	public function toMainPage() {
		
		// redirect to main page
		Controller::redirect('/main');
	}

	public function printUserInfo($id) {
		UserModel::getUserID($id);
	}

}

?>