<?php

class DB {
	private static $_instance = null;
	private $_data;
	private $_results;
	private $_query;
	private $_error = false;
	private $_count = 0;
	private $_pdo;

	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	private function __construct() {
		try {
			$this->_pdo = new PDO("mysql:host=" . Config::get("mysql/host") . ";dbname=" . Config::get("mysql/db"), Config::get("mysql/user"), Config::get("mysql/password"));
		} catch(Exception $e) {
			die($e->getMessage());
		}
	}

	public function query($sql, $params = array()) {
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			if (count($params)) {
				$counter = 1;
				foreach ($params as $param) {
					// bind each $param to the position number $counter
					$this->_query->bindValue($counter, $param);
					$counter++;
				}

				if ($this->_query->execute()) {
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
				}
				else {
					$this->_error = true;
				}
			}
		}
		return $this;
	}

	private function action($action, $table_name, $where = array()) {
		$field = $where[0];
		$operator = $where[1];
		$value = $where[2];

		$sql = "{$action} FROM {$table_name} WHERE {$field} {$operator} ?";

		if (!$this->query($sql, array($value))->error()) {
			return $this;
		}
		return false;
	}	

	public function	get($table_name, $where = array()) {
		return $this->action("SELECT *", $table_name, $where);
	}

	public function	delete($table_name, $where = array()) {
		return $this->action("DELETE", $table_name, $where);	
	}

	public function insert($table_name, $fields = array()) {
		$keys = array_keys($fields);
		$values = "";
		$counter = 1;
		foreach ($fields as $field) {
			$values .= "?";
			if ($counter < count($fields)) {
				$values .= ", ";
			}
			$counter++;
		}

		$sql = "INSERT INTO {$table_name} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
		
		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	public function update($table_name, $id, $fields = array()) {
		$set = "";
		$counter = 1;

		foreach ($fields as $key => $value) {
			$set .= "{$key} = ?";
			if ($counter < count($fields)) {
				$set .= ", ";
			}
			$counter++;
		}

		$sql = "UPDATE {$table_name} SET {$set} WHERE id = {$id}";

		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;

	}

	public function results() {
		return $this->_results;
	}

	public function first() {
		return $this->results()[0];
	}

	public function error() {
		return $this->_error;
	}
	public function count() {
		return $this->_count;
	}
}

?>