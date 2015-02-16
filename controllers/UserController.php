<?php

Class UserController extends Controller {

	public function printUserInfo($id) {
		UserModel::getUserID($id);
	}

}

?>