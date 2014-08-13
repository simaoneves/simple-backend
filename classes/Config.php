<?php

/**
*	Config class, gets all the website configurations stored in the init.php file
*
*	@version 0.5
*/
class Config{
	
	/**
	*	Get the value stored in the $GLOBALS variable stored in the $path provided
	*	
	*	@param $path -> names divided by "/" that translate to a value in $GLOBALS
	*	@return false if $path provided is null, true if the value is encountered
	*/
	public static function get($path = null) {
		if ($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			foreach ($path as $bit) {
				if (isset($config[$bit])) {
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}

?>