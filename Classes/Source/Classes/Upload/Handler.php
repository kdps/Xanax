<?php

declare(strict_types=1);

namespace Xanax\Classes\Upload;

use Xanax\Classes\File\Handler as FileHandler;

class Handler 
{
	
	public function Get($name, $key = 'name') 
	{
		if (preg_match('/^([A-Za-z0-9-_]{1,})\[[A-Za-z0-9-_]{1,}\]$/', $name, $match)) 
		{
			return isset($_FILES[$match[1]][$key][$match[2]]) ? $_FILES[$match[1]]['name'][$match[2]] : null;
		} 
		else 
		{
			if ($key === 'name') 
			{
				return isset($_FILES[$name]) ? $_FILES[$name] : null;
			} 
			else 
			{
				return isset($_FILES[$name][$key]) ? $_FILES[$name][$key] : null;
			}
		}
	}

	public function Move($name, $filePath) 
	{
		$temporaryName = $this->getTemporaryName($name);

		$result = move_uploaded_file($temporaryName,  $filePath);
		
		return $result;
	}
	
	public function isUploaded($name, $filePath) 
	{
		$temporaryName = $this->getTemporaryName($name);
		
		return file_exists(sprintf("%s/%s", $filePath, $temporaryName));
	}
	
	public function getErrorMessageFromCode($error) 
	{
		switch ($error) 
		{
			case UPLOAD_ERR_OK:
				$response = 'There is no error, the file uploaded with success.';
				break;
			case UPLOAD_ERR_INI_SIZE:
				$response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
				break;
			case UPLOAD_ERR_PARTIAL:
				$response = 'The uploaded file was only partially uploaded.';
				break;
			case UPLOAD_ERR_NO_FILE:
				$response = 'No file was uploaded.';
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
				break;
			case UPLOAD_ERR_EXTENSION:
				$response = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
				break;
			default:
				$response = 'Unknown upload error';
				break;
		}

		return $response;
	}

	public function hasError($name) 
	{
		if ($this->getFileError($name) !== UPLOAD_ERR_OK) 
		{
			return false;
		}

		return true;
	}

	public function hasItem() 
	{
		return (count($_FILES) > 0);
	}

	public function getTemporaryName($name) 
	{
		return $this->Get($name, 'tmp_name');
	}

	public function getFileType($name) 
	{
		return $this->Get($name, 'type');
	}

	public function getFileName($name) 
	{
		return $this->Get($name, 'name');
	}

	public function getFileSize($name) 
	{
		return $this->Get($name, 'size');
	}

	public function getFileError($name) 
	{
		return $this->Get($name, 'error');
	}

	public function isExists($name = 'tmp_file') 
	{
		if ($this->Get($name) === null) {
			return false;
		}

		return true;
	}
	
}
