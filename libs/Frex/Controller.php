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
	}

	// implement method's class
	public function implement($implementation_method_pattern, $argument=null) {

		// prepare controller and method names
		$split_call_chunks = explode(':', $implementation_method_pattern);
		$controller_name = $split_call_chunks[0];
		$method_name = $split_call_chunks[1];

		// initial value for checking of passed controllers
		$is_any_controller_pass = false;
		$controller_file_index = 0;

		foreach($this->_controllers_files as $index => $controller_file) {

			// increase controller index value
			$controller_file_index++;

			// check for controller if it's exist
			if ($controller_name == substr($controller_file, 0, -4)) {
				
				// there is one controller at least is passed
				if ($is_any_controller_pass == false) {
					$is_any_controller_pass = true;
				}

				// require controller from controllers' directory
				$this->require_controller($controller_file);

				// implement controller method
				$controller = new $controller_name();
				$controller->$method_name($argument);

			} else {

				// write error message if controller not exist (no controller is passed)
				if ($is_any_controller_pass == false && count($this->_controllers_files) == $controller_file_index) {
					echo 'Controller is not exist';
				}

			}

		}

	}
}
?>