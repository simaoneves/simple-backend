<?php

class User {

	private $_db;
	private $_data;
	private $_sessionName;
	private $_cookieName;
	private $_isLoggedIn;
	private $_tableName = "users";

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get("session/session_name");
		$this->_cookieName = Config::get("remember/cookie_name");
		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				}
				else {
					// process logout
				}
			}
		}
		else {
			$this->find($user);

		}
	}

	public function logout() {
		$this->_db->delete("user_sessions", array("user_id", "=", $this->data()->id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
		
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function create() {
		try {
			$salt = Hash::salt(32);
			$fields = array(
				'username' => Input::get("username"),
				'password' => Hash::makePassword(Input::get("password"), $salt),
				'salt' => $salt,
				'name' => Input::get("name"),
				'joined' => date("Y-m-d H:i:s"),
				'group' => 1
			);

			if (!$this->_db->insert($this->_tableName, $fields)) {
				throw new Exception("There was a problem creating your account");
			}
		} catch(Exception $e) {
			die($e->getMessage());
		}
	}

	private function find($username = null) {
		if ($username) {
			$field = (is_numeric($username)) ? 'id' : 'username';
			$data = $this->_db->get($this->_tableName, array($field, '=', $username)); 
			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function hasPermission($key) {
		$group = $this->_db->get("user_permissions", array("id", "=", $this->data()->group));
		if ($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);
			
			if ($permissions[$key] == true) {
				return true;
			}
		}
		return false;
	}

	public function update($fields = array(), $id = null) {

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update($this->_tableName, $id, $fields)) {
			throw new Exception("There was a problem updating!");
		}
	}

	public function login($username = null, $password = null, $remember = false) {
		$user = $this->find($username);
		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		}
		else {
			if ($user) {
				if ($this->data()->password === Hash::makePassword($password, $this->data()->salt)) {

					Session::put($this->_sessionName, $this->data()->id);
					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get("user_sessions", array("user_id", "=", $this->data()->id));
						if (!$hashCheck->count()) {
							$this->_db->insert("user_sessions", array(
								"user_id" => $this->data()->id,
								"hash" => $hash
							));
						}
						else {
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::get("remember/expiry"));
					}

					return true;
				}
			}
		}
		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function data() {
		return $this->_data;
	}

}

?>