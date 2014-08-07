<?php
session_start();
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => 'root',
		'db' => 'backend_oop'
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	),
	'remember' => array(
		'cookie_name' => "hash",
		'expiry' => 25200
	),
	'logger' => array(
		'log' => true,
		'directory' => "logs/",
		'file_name' => "events.log"
	),
	'modules' => array(
		'Dashboard' => true,
		'Gallery' => "logs/",
		'Analytics' => "events.log"
	),
);

spl_autoload_register(function ($className) {
	require_once("classes/" . $className . ".php");
});
require_once("functions.php");

if (Cookie::exists(Config::get("remember/cookie_name")) && !Session::exists(Config::get("session/session_name"))) {
	$hash = Cookie::get(Config::get("remember/cookie_name"));
	$hashCheck = DB::getInstance()->get("user_sessions", array("hash", "=", $hash));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}

?>