<?php

Class MainController extends Controller {

	public function main() {
		echo 'This is a main page';
	}

	public function about() {
		
		// redirect to main page
		Controller::redirect('/main');
		
	}

}

?>