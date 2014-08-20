<?php

/**
*	URL class, methods that help manipulate the URL and help with routing
*
*	@version 0.6
*/
class URL {

	public static function get() {
		return $_SERVER['REQUEST_URI'];
	}

}

?>