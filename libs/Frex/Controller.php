<?php

/**
 *	Class: Controller Class
 *	Handling controllers in Frex micro-framework and prepare all models to be used for them
**/

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
				require 'models/'.$model;
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


}
?>