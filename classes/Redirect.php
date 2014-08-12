<?php

/**
*	Redirect class, provides a way to redirect to links or to errors
*
*	@version 0.4
*/
class Redirect {

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