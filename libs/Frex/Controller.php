<?php

/**
 *	Class: Controller Class
 *	Handling controllers in Frex micro-framework
**/

Class Controller {

	// private properties and methods
	private $_controllers_files = array();
	private $_controllers_dir;
	private function require_controller ($controller) {
		require 'controllers/'.$controller;
	}

	// constructor
	public function Controller() {
		$this->_controllers_dir = 'controllers';
		$this->_controllers_files = array_diff(scandir($this->_controllers_dir), array('..', '.'));
		//$this->implement('MainController:main');
	}

	// implement method's class
	public function implement($implementation_method_pattern) {

		// prepare controller and method names
		$split_call_chunks = explode(':', $implementation_method_pattern);
		$controller_name = $split_call_chunks[0];
		$method_name = $split_call_chunks[1];

		foreach($this->_controllers_files as $index => $controller_file) {

			// check for controller if it's exist
			if ($controller_name == substr($controller_file, 0, -4)) {
				
				// require controller from controllers' directory
				$this->require_controller($controller_file);

				// implement controller method
				$controller = new $controller_name();
				$controller->$method_name();
				break;

			} else {
				echo 'Controller is not exist';
			}
		}

	}
}
?>