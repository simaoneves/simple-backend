<?php

class Hash {

	public static function makePassword($string, $salt = "") {
		return hash('sha256', $string . $salt);
	}

	public static function salt($length) {
		return mcrypt_create_iv($length);
	}

	public static function unique() {
		return self::makePassword(uniqid());
	}

}

?>