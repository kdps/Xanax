<?php

namespace Xanax\Classes;

use Xanax\Classes\FileHandler;

class FileObject {

	private $writeHandler;
	private $fileHandler;
	
	// Determines whether file size capacity is compared
	private $confirmFilesize = true;
	
	// The size of the file last created
	private $writeContentLength;
	
	// File creation mode
	private $writeMode;
	
	// The path of the file to be finally created
	private $filePath;
	
	// File extension
	private $fileExtension;
	
	// Class file for managing file
	private $fileHandlerClass;
	
	// Path of the file to be temporarily saved
	private $temporaryPath;
	
	// File pointer location
	private $seekOffset;
	
	// If the length does not match the contents written, it is returned to the original file
	private $recoveryMode = false;
	
	public function __construct ( string $filePath, bool $recoveryMode = false, string $writeMode = 'w' ) {
		$this->fileHandlerClass = new FileHandler();
		
		$this->seekOffset = 0;
		$this->filePath = $filePath;
		$this->fileExtension = $this->fileHandlerClass->getExtention( $filePath );
		$this->writeMode = $writeMode;
		
		$this->recoveryMode = $recoveryMode;
		if ( $this->recoveryMode ) {
			do {
				$this->temporaryPath = sprintf( "%s.%s.%s", $filePath, uniqid(rand(), true), $this->fileExtension );
			} while ( $this->fileHandlerClass->isFile( $this->temporaryPath ) );
		}
		
		if ( $this->writeMode === 'a' && $this->fileHandlerClass->isExists( $this->filePath ) ) {
			$fileContent = file_get_contents( $this->filePath, true );
			file_put_contents($this->temporaryPath, $fileContent);
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
		$invalidFileSize = $currentFileSize === -1 ? true : false;
		$correctFileSize = ( $currentFileSize === (int)$this->writeContentLength );
		
		if ( $this->recoveryMode && !$invalidFileSize && !$correctFileSize ) {
			$this->fileHandlerClass->Delete ( $filePath );
			return false;
		}
		
		if ( $this->recoveryMode ) {
			if ( $this->fileHandlerClass->Copy ( $filePath, $this->filePath ) ) {
				$this->fileHandlerClass->Delete ( $filePath );
			}
		}
		
		return true;
	}
	
	public function Seek ( int $offset ) :bool {
		$seek = fseek( $this->fileHandler, $offset, SEEK_SET );
		
		if ( $seek === 0 ) {
			$this->seekOffset = $offset;
			
			return true;
		}
		
		return false;
	}
	
	public function isLocked () :bool {
		return $this->fileHandlerClass->isLocked( $this->filePath );
	}
	
	public function isWritable () :bool {
		return $this->fileHandlerClass->isWritable( $this->filePath );
	}
	
	public function writeContent ( string $content, $isLarge = false ) :bool {
		if ( !$this->isWritable() || $this->isLocked() ) {
			return false;
		}
		
		$this->confirmFilesize = true;
		
		if ( $this->writeMode === 'w' ) {
			$this->writeContentLength = strlen( $content );
		} else if ( $this->writeMode === 'a' ) {
			$this->writeContentLength = $this->fileHandlerClass->getSize( $this->filePath ); 
			$this->writeContentLength += strlen( $content );
		}
		
		if ( $isLarge ) {
			$pieces = str_split($content, 1024 * 4);
			foreach ($pieces as $piece) {
				$this->writeHandler += fwrite( $this->fileHandler, $piece, strlen($piece));
			}
		} else {
			$this->writeHandler = fwrite( $this->fileHandler, $content );
		}
	
		return true;
	}
	
	public function printFileData ( int $mbSize = 8 ) {
		while( !feof( $this->fileHandler ) ) {
			print( @fread( $this->fileHandler, (1024 * $mbSize) ) );
			ob_flush();
			flush();
		}
	}
	
	public function successToWriteContent () :bool {
		if ( !getType($this->writeHandler) === 'integer' ) {
			return false;
		}
		
		if ( $this->writeMode === 'w' && $this->writeHandler !== (int)$this->writeContentLength ) {
			return false;
		}
		
		if ( $this->writeMode === 'a' && $this->fileHandlerClass->getSize( $this->temporaryPath ) !== (int)$this->writeContentLength ) {
			return false;
		}
		
		return true;
	}
	
	public function getFilePath () :string {
		if ( $this->recoveryMode ) {
			$filePath = $this->temporaryPath;
		} else {
			$filePath = $this->filePath;
		}
		
		return $filePath;
	}
	
	public function startHandle () :void {
		$this->fileHandler = fopen( $this->getFilePath(), $this->writeMode );
	}
	
	public function successToStartHandle () :bool {
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