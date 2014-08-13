<?php

/**
*	Cookie class, CRUD for Cookies
*
*	@version 0.6
*/
class Cookie {

	/**
	*	Check if a cookie with the name $name exists
	*	
	*	@param $name -> name of the cookie to be checked
	*	@return true if it is set, false otherwise
	*/
	public static function exists($name) {
		return isset($_COOKIE[$name]);
	}

	/**
	*	Get the value stored in a cookie with the name $name
	*	
	*	@param $name -> name of the cookie to be checked
	*	@return value stored in the cookie if it exists
	*/
	public static function get($name) {
		return $_COOKIE[$name];
	}

	/**
	*	Puts the $value in the cookie with name $name, with expiricy $expiry
	*	
	*	@param $name -> name of the cookie to be created
	*	@param $value -> value to be stored
	*	@param $name -> expiricy in seconds
	*	@return true if it creates the cookie, false otherwise
	*/
	public static function put($name, $value, $expiry) {
		return setcookie($name, $value, time() + $expiry, "/");
	}

	/**
	*	Unsets and deletes a cookie
	*	
	*	@param $name -> name of the cookie to be deleted
	*/
	public static function delete($name) {
		self::put($name, "", time() - 1);
	}
}

?>