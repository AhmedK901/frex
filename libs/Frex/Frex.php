<?php

/**
 *	Class: Frex Class
 *	Main class for Frex micro-framework, contains route methods, and nessesary app running methods
**/

Class Frex {

	// private properties and methods
	private $_route_uri = array();
	private $_route_methods = array();
	private $_route_method_arguments = array();
	private $_is_any_set_uri = false;

	private function getGetUri() {
		return isset($_GET['uri']) ? '/'. $_GET['uri'] : '/';
	}

	private function getMethodArgumentsName($url) { // get any provided argument name from route
		
		// separate route uri parameters
		$expectedURIParam = explode('/', $url);

		// create arguments names array
		$argumentsNames = array();

		// check if there is route uri parameters
		if (count($expectedURIParam) > 1) {
				
				for ($i=0; $i<count($expectedURIParam); $i++) {

						// check if there arguments in route uri parameters
						if (preg_match("#^:[A-Za-z]+$#", $expectedURIParam[$i])) {

							// add argument to arguments names array
							$argumentsNames[] = trim($expectedURIParam[$i], ':');
						}
				}

				// return arguments names array
				return $argumentsNames;

		} else {

				return null;

		}
		
	}

	private function getMethodArgumentValue($localURI, $getURI) {

		// create route uri keys
		$uriParamsKeys = array_values(array_diff(explode('/', $localURI), array('')));

		// create route uril values (expected GET arguments values)
		$argumentsNames = array_values(array_diff(explode('/', $getURI), array('')));

		// create GET arguments array
		$getArguments = array();

		for ($i=0; $i<count($uriParamsKeys); $i++) {

				// check if there arguments in route uri parameters
				if (preg_match("#^:[A-Za-z]+$#", $uriParamsKeys[$i])) {

					// add argument to GET arguments array
					$getArguments[trim($uriParamsKeys[$i], ':')] = $argumentsNames[$i];

				}
		}

		// return GET arguments array
		return $getArguments;

	}

	private function checkURIPattern($localURI, $getURI) { // match route and get URIs and return the result

		// pattern variable to be matched for check
		$uriMatchPattern;

		// final URI parameter expression variable
		$expectedURIParam = $this->getMethodArgumentsName($localURI);
		

		if (count($expectedURIParam) != 0) {

			// assign new expected url parameters to local uri
			$newExpectedURIParam = $localURI;

			for ($i = 0; $i < count($expectedURIParam); $i++) {

					// replace current argument alias with expected expression
				$newExpectedURIParam = str_replace(":".$expectedURIParam[$i],"([0-9A-Za-z_\#@.]+)",$newExpectedURIParam);

			}
			
			// final match pattern to be checked
			$uriMatchPattern = "#^$newExpectedURIParam\/?$#";

		} else {

			// final match pattern to be checked
			$uriMatchPattern = "#^$localURI\/?$#";
		}

		// check for final match pattern with current GET URI
		if (preg_match($uriMatchPattern, $getURI)) {

			return true;

		} else {

			return false;

		}

	}

	private function implement_controller_method($implementation_method_pattern, $argument=null) {

		// get controllers files
		$controllers_files = array_diff(scandir('controllers'), array('..', '.'));


		// prepare controller and method names
		$split_call_chunks = explode(':', $implementation_method_pattern);
		$controller_name = $split_call_chunks[0];
		$method_name = $split_call_chunks[1];

		// initial value for checking of passed controllers
		$is_any_controller_pass = false;
		$controller_file_index = 0;

		// check and select controller
		foreach($controllers_files as $index => $controller_file) {

			// increase controller index value
			$controller_file_index++;

			// check for controller if it's exist
			if ($controller_name == substr($controller_file, 0, -4)) {
				
				// there is one controller at least is passed
				if ($is_any_controller_pass == false) {
					$is_any_controller_pass = true;
				}

				// require controller from controllers' directory
				require_once 'controllers/'.$controller_file;

				// implement controller method
				$controller = new $controller_name();
				$controller->$method_name($argument);

			} else {

				// write error message if controller not exist (no controller is passed)
				if ($is_any_controller_pass == false && count($controllers_files) == $controller_file_index) {
					echo 'Controller is not exist';
				}

			}

		}

	}

	// constructor
	public function Frex() {
		$this->load('Controller.php');
	}

	// log mode
	public function log($message) {
		
		print('<br>');
		print('['.$message.']');

	}

	// load specific Frex class
	public function load($classfile, $once=false) {

		if ($once == true) {
			require_once $classfile;
		} else {
			require $classfile;
		}

	}

	// set new route
	public function set($uri, $method=null) {

		// prepare chosen route pattern
		$this->_route_uri[] = '/' . trim($uri, '/');

		// add a method to chosen route
		$this->_route_methods[] = $method;

		// add method's argument to chsoen route
		$this->_route_method_arguments[] = $this->getMethodArgumentValue($this->_route_uri[count($this->_route_uri)-1], $this->getGetUri());

	}

	// run route and implement its method
	public function run() {

		// get and prepare uri param
		$uriGetParam = $this->getGetUri();


		// check if route value is match with with uri GET parameter 
		foreach($this->_route_uri as $key => $value) {	

			if ($this->checkURIPattern($value, $uriGetParam)) {

				// there is one setted uri route at least
				$this->_is_any_set_uri = true;
				
				// check if method is exist
				if ($this->_route_methods[$key] != null) {

					// select type of method return (single function / controller method)
					if (is_callable($this->_route_methods[$key])) {
						
						if (count($this->_route_method_arguments[$key]) != 0) {

							$this->_route_methods[$key]($this->_route_method_arguments[$key]);

						} else {

							$this->_route_methods[$key]();

						}

					} else  {
						
						if (count($this->_route_method_arguments[$key]) != 0) {

							$this->implement_controller_method($this->_route_methods[$key], $this->_route_method_arguments[$key]);

						} else {

							$this->implement_controller_method($this->_route_methods[$key]);

						}

					}

					
				} else {

					// default message if there is no method is implemented with selected route
					$this->log('Match URI! - You can pass controller with this route');

				}
				
			}

		}

		// give not found message if no any uri parameter match setted uri route
		if ($this->_is_any_set_uri == false) {
			$this->log('Not Page Found');
		}

	}

}

?>
