<?php

/**
*	Session class, methods to CRUD the Sessions, flash messages
*
*	@version 0.5
*/
class Session {

	/**
	*	Check to see if $name is set in $_SESSION
	*
	*	@param $name -> name to be checked
	*	@return True if it is set, false otherwise
	*/
	public static function exists($name) {
		return (isset($_SESSION[$name])) ? true : false;
	}

	/**
	*	Create a new hash in the $_SESSION with name $name and value $value
	*
	*	@param $name -> name to be created
	*	@param $value -> value to be associated with $name
	*	@return The value
	*/
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	/**
	*	Gets the value associated with the key $name
	*
	*	@param $name -> name to be checked
	*	@return The value in $_SESSION[$name]
	*/
	public static function get($name) {
		return $_SESSION[$name];
	}

	/**
	*	Delete (unset) hash in $_SESSION with name $name, if it exists
	*
	*	@param $name -> $_SESSION name to be deleted
	*/
	public static function delete($name) {
		if (self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

	/**
	*	Flash a message to the user, if it exists, else it creates a hash in 
	*	$_SESSION with name $name and value $message
	*
	*	@param $name -> name where to store the message
	*	@param $message -> message to be stored, to be flashed to the user later
	*	@return The stored message if it exists
	*/
	public static function flash($name, $message = '') {
		if (self::exists($name)) {
			$storedMessage = self::get($name);
			self::delete($name);
			return $storedMessage;
		}
		else {
			self::put($name, $message);
		}
	}

}

?>