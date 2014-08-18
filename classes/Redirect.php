<?php

/**
*	Redirect class, provides a way to redirect to links or to errors
*
*	@version 0.5
*/
class Redirect {

	/**
	*	Redirects the user to the provided page $location, if $location is numeric
	*	it sends an header with that HTTP Status code
	*
	*	@param $location -> path to where redirect user, can be numeric, in that case,
	*	it corresponds to an HTTP Status code
	*
	*/
	public static function redirectTo($location) {
		if ($location) {
			if (is_numeric($location)) {
				switch($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include("404.php");
						exit();
						break;
				}
			}
			else {
				header("Location: " . $location);
				exit;
			}
		}
	}

}

?>