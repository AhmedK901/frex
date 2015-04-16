<?php

/**
 *	Class: Presentation Class
 *	Handling presentation in Frex micro-framework
 **/

Class Presentation {

	// change presentation type
	public function presentation_type($presentation_type) {

		/*
		Content-types:	plain-text
		application/json
		application/xml
		text/html
		 */
		header('Content-type: ' . $presentation_type);
	}

	// present data in specific presentation type
	public function present_data($data, $presentation_type) {

		// present in JSON format
		if ($presentation_type == 'application/json') {

			echo json_encode($data);

			// present in Plain/text format
		} else if ($presentation_type == 'plain/text') {

			echo trim(strip_tags($data));

			// present in XML format
		} else if ($presentation_type == 'application/xml') {

			$xml = new SimpleXMLElement('<root/>');
			array_walk_recursive($data, array($xml, 'addChild'));
			print $xml->asXML();

			// present in HTML format
		} else if ($presentation_type == 'text/html') {

			print_r($data);

		}
	}

	// present view to be included HTML file
	public function present_view($view_file, $data = null) {

		// path of views
		$view_dir = 'views/';

		// check if view file is exist
		if (file_exists($view_dir . $view_file)) {

			if ($data == null) {

				include_once $view_dir . $view_file;

			} else {

				// load HTML content in variable
				$htmlfile = file_get_contents($view_dir . $view_file);

				// use all available GET data in HTML content
				foreach ($data as $key => $value) {

					// replace any template variable with available GET data
					$htmlfile = str_replace("{$key}", $value, $htmlfile);

				}

				// reset any template variable prefix and suffix
				$htmlfile = str_replace("{", "", $htmlfile);
				$htmlfile = str_replace("}", "", $htmlfile);

				// output new HTML code
				print($htmlfile);

			}

		} else {
			Frex::log($view_file . ' is not exist.');
		}

	}

	// include php input data in specific format
	public function input_data_as_json() {

		// set input data
		$input_data = file_get_contents('php://input');

		if (strlen($input_data) > 2) {

			// return input data in JSON format
			return json_decode($input_data);

		}

	}

}

?>
