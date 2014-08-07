<?php

class Input {

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