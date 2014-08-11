<?php

/**
*	Config class, gets all the website configurations stored in the init.php file
*
*	@version 0.4
*/
class Config{
	
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