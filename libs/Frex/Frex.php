<?php

/**
 *	Class: Frex Class
 *	Main class for Frex micro-framework, contains route methods, and nessesary app running methods
**/

Class Frex {

	// private properties and methods
	private $_controller_class;
	private $_route_uri = array();
	private $_route_methods = array();
	private $_is_any_set_uri = false;


	// constructor
	public function Frex() {
		$this->load('Controller.php');
		$this->_controller_class = new Controller();
	}

	// log mode
	public function log($message) {
		
		print('<br>');
		print('['.$message.']');
	}

	// load specific Frex class
	public function load($classfile) {
		require $classfile;
	}

	// set new route
	public function set($uri, $method) {

		// prepare chosen route pattern
		$this->_route_uri[] = '/' . trim($uri, '/');

		// add a method to chosen route
		$this->_route_methods[] = $method;

	}

	// run route and implement its method
	public function run() {

		// get and prepare parameter from uri
		$uriGetParam = isset($_GET['uri']) ? '/'. $_GET['uri'] : '/';

		// check if route value is match with with uri get parameter 
		foreach($this->_route_uri as $key => $value) {	
			if (preg_match("#^$value\/?$#", $uriGetParam)) {

				// there is one setted uri route at least
				$this->_is_any_set_uri = true;
				
				// check if method is exist
				if (array_key_exists($key, $this->_route_methods)) {

					// select type of method return (single function / controller method)
					if (is_callable($this->_route_methods[$key])) {
						$this->_route_methods[$key]();
					} else  {
						$this->_controller_class->implement($this->_route_methods[$key]);
					}

					
				} else {
					$this->log('Match URI!');
				}
				
			}

		}

		// give not found message if no any uri params match setted uri route
		if ($this->_is_any_set_uri == false) {
			$this->log('Not Page Found');
		}

	}

}

?>