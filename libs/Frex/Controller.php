<?php

/**
 *	Class: Controller Class
 *	Handling controllers in Frex micro-framework and prepare all models to be used for them
**/

// use presentation methods in controllers
require_once 'Presentation.php';

// model is required as a superclass for all models available on app
require 'Model.php';

Class Controller {

	// private properties and methods
	private $_models_files = array();
	private function require_models() {
		
		// check if there is any model available
		if (count($this->_models_files) > 0) {

			// require all models available
			foreach($this->_models_files as $index => $model) {
				require_once 'models/'.$model;
			} 
		}
		
	}
	private function get_models() {
		$this->_models_files = array_diff(scandir('models'), array('..','.'));
	}

	// constructor
	public function Controller() {

		// get all models
		$this->get_models();

		// re
		$this->require_models();
	}

	// redirect to another location
	public function redirect($location, $in_app_path=true) {
		if ($in_app_path == true) {
			$url = 'http://';
			$url.=$_SERVER['HTTP_HOST'];
			$url.=$_SERVER['PHP_SELF'];
			$url=substr($url, 0, -10);
			$url.=$location;
			header("Location: $url");
			exit(0);
		} else {
			header("Location: $location");
			exit(0);
		}
	}


}
?>
