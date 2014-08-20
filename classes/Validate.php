<?php

/**
*	Validate class, provides a way to validate forms with simple rules
*
*	@version 0.5
*/
class Validate {

	// Detected errors
	private $_errors = array();

	// Stores the info if the validation was successfull or not
	private $_passed = false;

	// DB instance
	private $_db = null;

	/**
	*	Constructor, gets DB instance
	*
	*/
	public function __construct() {
		$this->_db = DB::getInstance();
	}

	/**
	*	Check to see if the fields in $source (GET or POST) are validated with 
	*	the rules provided in the $items
	*	If all is ok, changes the $_passed to true, adds errors to $_errors otherwise
	*
	*	@param $source -> where the values are stored (GET or POST)
	*	@param $items -> where the rules of validation are stored
	*	@return The object itself
	*/
	public function check($source, $items = array()) {

		// for each fieldname in the form
		foreach ($items as $field_name => $rules) {

			// for each rule in the rules
			foreach ($rules as $rule => $rule_value) {
				$value = $source[$field_name];
				
				// must be required
				if ($rule === "required" && empty($value)) {
					$this->addError("{$field_name} is required!");
				} else {
					switch ($rule) {

						// must be at least $rule_value characters
						case "min":
							if (strlen($value) < $rule_value) {
								$this->addError("{$field_name} must have at least {$rule_value} characters!");
							}
							break;

						// must be at maximum $rule_value characters	
						case "max":
							if (strlen($value) > $rule_value) {
								$this->addError("{$field_name} must have {$rule_value} characters maximum!");
							}
							break;

						// must match another fieldname (useful for password checking)
						case "matches":
							if ($value != $source[$rule_value]) {
								$this->addError("{$rule_value} and {$field_name} must be equal");
							}
							break;

						// $field_name must be unique in the DB, on the table $rule_value
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
		// if there were no errors, evaluate to true
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	/**
	*	Add error to the array
	*
	*	@param $errorMessage -> message to be stored
	*/
	private function addError($errorMessage) {
		$this->_errors[] = $errorMessage;
	}

	/**
	*	Gets all the errors
	*
	*	@return The errors array
	*/
	public function errors() {
		return $this->_errors;
	}

	/**
	*	Was the validation successfull?
	*
	*	@return True if it was successfull, false otherwise
	*/
	public function passed() {
		return $this->_passed;
	}
}

?>