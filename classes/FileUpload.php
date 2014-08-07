<?php

class FileUpload {

	private $_size;
	private $_error;
	private $_errorMsg;
	private $_tmpName;
	private $_type;
	private $_name;
	private $_uploadDir = "uploads";

	public function __construct() {

		$this->_error = $_FILES['file_upload']['error'];

		// if there was not an error
		if ($this->_error == 0) {

			$this->_size = $_FILES['file_upload']['size'];
			$this->_type = $_FILES['file_upload']['type'];
			$this->_name = $_FILES['file_upload']['name'];
			$this->_tmpName = $_FILES['file_upload']['tmp_name'];
		}
		else {
			$this->_errorMsg = $this->errorMsg($this->_error);
		}
		return $this;
	}

	public function error() {
		return $this->_error != 0 ? true : false;
	}

	public function exists() {
		return !empty($_FILES['file_upload']);
	}

	private function errorMsg($error_num) {
		switch ($error_num) {
			case 1:
				$message = "Larger than upload_max_filesize (.ini)";
				break;
			case 2:
				$message = "Larger than MAX_FILE_SIZE";
				break;
			case 3:
				$message = "Partial upload";
				break;
			case 4:
				$message = "No file";
				break;
			case 6:
				$message = "No temporary directory";
				break;
			case 7:
				$message = "Can't write to disk!";
				break;
			case 8:
				$message = "File upload stopped by extension";
				break;
			//custom error
			case 99:
				$message = "There was a problem moving the file";
				break;
			default:
				$message = "Something went wrong, but no error was identified!";
				break;
		}
		return $message;
	}

	public function getErrorMsg() {
		return $this->_errorMsg;
	}

	public function moveTo($dir = "") {
		$upload_dir = !empty($dir) ? $dir : $this->_uploadDir;
		$target_file = basename($this->_name);

		// TODO
		// rename and escape
		// if !file_exists()

		// if there were no errors
		if (!$this->error()) {

			// if it moves successfully
			if (move_uploaded_file($this->_tmpName, $upload_dir . "/" . $target_file)) {
				return true;
			}
			else {
				$this->_errorMsg = $this->ErrorMsg(99);
				return false;
			}
		}
		return false;
	}
}

?>