<?php

/**
*	FileUpload class, methods to help on file uploading
*
*	@version 0.6
*/
class FileUpload {

	// Size of the file, in bytes
	private $_size;

	// Error code, if any
	private $_error;

	// Error message to be presented
	private $_errorMsg;

	// Temporary name
	private $_tmpName;

	// Type of file
	private $_type;

	// Actual name of the file
	private $_name;

	// Uploads Directory, can be changed from project to project
	private $_uploadDir = "uploads";

	/**
	*	FileUpload constructor, if no error was found, populate the attributes
	*	
	*	@return the object itself, for chainning
	*/
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

	/**
	*	Was there an error in the upload?
	*	
	*	@return true if there was an error, false otherwise
	*/
	public function error() {
		return $this->_error != 0 ? true : false;
	}

	/**
	*	Check to see if the there was some file uploaded
	*	
	*	@return true if a file was uploaded, false otherwise
	*/
	public function exists() {
		return !empty($_FILES['file_upload']);
	}

	/**
	*	Helper function, to determine which message to present based on the
	*	error number from the upload
	*	
	*	@param $error_num -> number that comes from $_FILES['file_upload']['error']
	*	@return the error message, based on the error number
	*/
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

	/**
	*	Get error message to be presented
	*	
	*	@return the message stored in the $_errorMsg attribute
	*/
	public function getErrorMsg() {
		return $this->_errorMsg;
	}

	/**
	*	Move file to the directory $dir provided, if none is provided, its moved to $_uploadDir attribute
	*	
	*	@param $dir -> directory where you want the file to be stored
	*	@return the object itself, for chainning
	*/
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