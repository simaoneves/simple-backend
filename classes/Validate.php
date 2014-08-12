<?php

/**
*	Validate class, provides a way to validate forms with simple rules
*
*	@version 0.4
*/
class Validate {
	private $_errors = array();
	private $_passed = false;
	private $_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		foreach ($items as $field_name => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = $source[$field_name];
				
				
				if ($rule === "required" && empty($value)) {
					$this->addError("{$field_name} is required!");
				} else {
					switch ($rule) {
						case "min":
							if (strlen($value) < $rule_value) {
								$this->addError("{$field_name} must have at least {$rule_value} characters!");
							}
							break;
						case "max":
							if (strlen($value) > $rule_value) {
								$this->addError("{$field_name} must have {$rule_value} characters maximum!");
							}
							break;
						case "matches":
							if ($value != $source[$rule_value]) {
								$this->addError("{$rule_value} and {$field_name} must be equal");
							}
							break;
						case "unique":
							$value = htmlentities($value);
							$field_name = htmlentities($field_name);
							$this->_db->get($rule_value, array($field_name, "=", $value));
							if ($this->_db->count()) {
								$this->addError("{$field_name} already in use");
							}
							break;
					}
				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}

?>