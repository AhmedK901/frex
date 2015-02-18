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
		header('Content-type: '. $presentation_type);
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

	// set HTTP header
	public function set_http_header() {

		// nested method
		function authentication() {

		}

		function content_type() {

		}

		function set_origin() {

		}

	}

}

?>