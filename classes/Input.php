<?php

/**
*	Input class, helper methods to provide support for inputs and forms data handling
*
*	@version 0.5
*/
class Input {

	/**
	*	Get $_POST[$fieldName] or $_GET[$fieldName], if they are set
	*
	*	@param $fieldName -> the key in the POST or GET request hash
	*	@return The value in the $_POST[$fieldName] or $_GET[$fieldName], empty string if those are empty
	*/
	public static function get($fieldName){
		if (isset($_POST[$fieldName])) {
			return $_POST[$fieldName];
		}
		else if (isset($_GET[$fieldName])) {
			return $_GET[$fieldName];
		}
		else {
			return "";
		}
	}
}

?>