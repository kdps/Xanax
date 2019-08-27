<?php

namespace Xanax\FileHandler;
use Xanax\Exception\FileHandler\FileIsNotExistsException;

class FileHandler {
	
	function getSize ( $filePath ) :int {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = filesize( $filePath );
		
		return $return >= 0 ? $return : -1;
	}
	
	function appendFileContent( $filePath, $content ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$fileHandler = fopen( $filePath, 'a' );
		fwrite($fileHandler, $content);
		fclose($fileHandler);
	}
	
	function getLastModifiedTime ( $filePath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = fileatime($filePath);
		
		return $return;
	}
	
	function getType ( $filePath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = filetype( $filePath );
		
		return $return;
	}
	
	function getExtention ( $filePath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = pathinfo($filePath, PATHINFO_EXTENSION);
		
		return $return;
	}
	
	function Download ( $filePath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$fileHandler = @fopen($filePath, 'rb');
		if ($fileHandler) {
			while(!feof($fileHandler)) {
				print(@fread($fileHandler, 1024 * 8));
				ob_flush();
				flush();
			}
		}
		
		fclose($file);
	}
	
	function getInterpretedContent ( $filePath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		ob_start();
			
		if (isset( $filePath )) {
			if ( file_exists( $filePath ) ) {
				@include( $filePath );
			} else {
				throw new FileIsNotExistsException ( "File is not exists" );
			}
		}
		
		$return = ob_get_clean();
		
		return $return;
	}
	
	function isFile ( $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = is_file ( $filePath );
		
		return $return;
	}
	
	function Move ( $source, $destination ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = rename( $source, $destination );
		
		return $return;
	}
	
	function isEmpty ( $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	function isExists ( $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( "File is not exists" );
		}
		
		$return = file_exists( $filePath );
		
		return $return;
	}
	
}
