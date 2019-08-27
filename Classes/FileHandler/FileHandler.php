<?php

namespace Xanax\FileHandler;
use Xanax\Exception\FileHandler\FileIsNotExistsException;

class FileHandler {
	
	function Size( $filePath ) :int {
		if ( $this->isExists($filePath) ) {
			$return = filesize( $filePath ); // WTF ?? filesize / file_exists
		}
		
		return $return >= 0 ? $return : -1;
	}
	
	function getInterpretedContent ( $filePath ) {
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
	
	function isFile( $filePath ) :bool {
		$return = is_file ( $filePath );
		
		return $return;
	}
	
	function Move( $source, $destination ) :bool {
		$return = rename( $source, $destination );
		
		return $return;
	}
	
	function isEmpty($filePath) :bool {
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	function isExists( $filePath ) :bool {
		$return = file_exists( $filePath );
		
		return $return;
	}
	
}
