<?php

namespace Xanax\Classes;

use Xanax\Classes\FileHandler;

class FileObject {

	private $confirmFilesize = true;
	private $writeContentLength;
	private $mode;
	private $filePath;
	private $fileHandler;
	private $fileExtension;
	private $fileHandlerClass;
	private $temporaryPath;
	private $writeHandler;
	private $recoveryMode = false;
	
	public function __construct ( $filePath, $recoveryMode = false, $mode = 'w' ) {
		$this->fileHandlerClass = new FileHandler();
		
		$this->filePath = $filePath;
		$this->fileExtension = $this->fileHandlerClass->getExtention( $filePath );
		$this->mode = $mode;
		
		$this->recoveryMode = $recoveryMode;
		if ( $this->recoveryMode ) {
			do {
				$this->temporaryPath = sprintf("%s.%s.%s", $filePath, uniqid(rand(), true), $this->fileExtension);
			} while ( $this->fileHandlerClass->isFile($this->temporaryPath) );
		}
	}
	
	public function hasWriteContentLength () {
		if ( $this->writeContentLength === -1 ) {
			return false;
		}
		
		return true;
	}
	
	public function closeFileHandle () {
		fclose( $this->fileHandler );
		
		if ( !$this->recoveryMode ) {
			return true;
		}
		
		if ( $this->recoveryMode && !$this->hasWriteContentLength() ) {
			return true;
		}
		
		$filePath = $this->getFilePath();
		$currentFileSize = $this->fileHandlerClass->getSize( $filePath );
		
		if ( $this->recoveryMode && ( $currentFileSize !== (int)$this->writeContentLength ) ) {
			$this->fileHandlerClass->Delete ( $filePath );
			return false;
		}
		
		if ( $this->recoveryMode ) {
			if ( $this->fileHandlerClass->Copy ( $filePath, $this->filePath ) ) {
				$this->fileHandlerClass->Delete ( $filePath );
			}
			
			return true;
		}
	}
	
	public function writeContent ( $content ) {
		$this->confirmFilesize = true;
		
		if ( $this->mode === 'w' ) {
			$this->writeContentLength = strlen( $content );
		} else if ( $this->mode === 'a' ) {
			$this->writeContentLength = $this->fileHandlerClass->getSize( $this->filePath ); 
			$this->writeContentLength .= strlen( $content );
		}
		
		$this->writeHandler = fwrite( $this->fileHandler, $content );
	}
	
	public function successToWriteContent () {
		if ( !getType($this->writeHandler) === 'integer' ) {
			return false;
		}
		
		if ( $this->writeHandler !== (int)$this->writeContentLength ) {
			return false;
		}
		
		return true;
	}
	
	public function getFilePath () {
		if ( $this->recoveryMode ) {
			$filePath = $this->temporaryPath;
		} else {
			$filePath = $this->filePath;
		}
		
		return $filePath;
	}
	
	public function startHandle () {
		$this->fileHandler = fopen( $this->getFilePath(), $this->mode );
	}
	
	public function successToStartHandle () {
		if ( ($this->fileHandler) === false ) {
			return false;
		}
		
		if ( getType($this->fileHandler) !== "resource" ) {
			return false;
		}
		
		if ( get_resource_type ($this->fileHandler) !== "stream" ) {
			return false;
		}
		
		return true;
	}
	
}