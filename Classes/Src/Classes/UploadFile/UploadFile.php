<?php

namespace Xanax\Classes;

class UploadFile {
	
	public function Get ( $name, $key = 'name' ) {
		if (preg_match('/^([A-Za-z0-9-_]{1,})\[[A-Za-z0-9-_]{1,}\]$/', $name, $match)) {
			return isset($_FILES[$match[1]][$key][$match[2]]) ? $_FILES[$match[1]]['name'][$match[2]] : null;
		} else {
			if ( $key === 'name' ) {
				return isset($_FILES[$name]) ? $_FILES[$name] : null;
			} else {
				return isset($_FILES[$name][$key]) ? $_FILES[$name][$key] : null;
			}
		}
	}
	
	public function hasError ( $name ) {
		if ($this->getFileError( $name ) !== UPLOAD_ERR_OK) {
			return false;
		}
		
		return true;
	}
	
	public function hasItem() {
		return (count($_FILES) > 0);
	}
	
	public function getTemporaryName ( $name ) {
		return $this->Get($name, 'tmp_name');
	}
	
	public function getFileType ( $name ) {
		return $this->Get($name, 'type');
	}
	
	public function getFileName ( $name ) {
		return $this->Get($name, 'name');
	}
	
	public function getFileSize ( $name ) {
		return $this->Get($name, 'size');
	}
	
	public function getFileError ( $name ) {
		return $this->Get($name, 'error');
	}
	
	public function isExists ( $name ) {
		if ( $this->Get($name) === null ) {
			return false;
		}
		
		return true;
	}
	
}