<?php

/**
*	Token class, provides methods to generate CSRF tokens and a way to validate them
*
*	@version 0.4
*/
class Token {

	public static function generate() {
		return Session::put(Config::get("session/token_name"), md5(uniqid(mt_rand(), true)));
	}

	public static function check($token) {
		$tokenName = Config::get("session/token_name");
		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		return false;
	}

}

?>