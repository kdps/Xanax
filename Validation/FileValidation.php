<?php

namespace Xanax\Validation;

class FileValidation {
	
	public function isReadable ( $filename ) {
		if ( Xanax\Classes\PHP->versionGreaterThanCurrent("5.3.0") ) {
			if ( strlen($filename) >= PHP_MAXPATHLEN ) {
				return false;
			}
		}
		
		return true;
	}
	
	public function isNotReadable ( $filename ) {
		return ! $this->isReadable ( $filename );
	}
	
	function isHTTPProtocol ( $filePath ) {
		$regexr = '/^(http||https):\/\//i';
		
		if( preg_match( $regexr, $filePath ) ) {
			return true;
		}
		
		return false;
	}
	
	function isNotHTTPProtocol ( $filePath ) {
		return ! $this->isHTTPProtocol ( $filePath );
	}
	
	function isPharProtocol ( $filePath ) {
		$regexr = '/^phar:\/\/.*/i';
		
		if( preg_match( $regexr, $filePath ) ) {
			return true;
		}
		
		return false;
	}
	
	function isNotPharProtocol ( $filePath ) {
		return ! $this->isPharProtocol ( $filePath );
	}
	
	function hasSubfolderSyntax ( $filePath ) {
		$regexr = '/..\/$/i';
		
		if( preg_match( $regexr, $filePath ) ) {
			return true;
		}
		
		return false;
	}
	
	function hasNotSubfolderSyntax ( $filePath ) {
		return ! $this->hasSubfolderSyntax ( $filePath );
	}
	
	function hasExtention ( $filePath ) {
		$regexr = '/^.*\.[A-Za-z0-9]{1,5}$/i';
		
		if( preg_match( $regexr, $filePath ) ) {
			return true;
		}
		
		return false;
	}
	
	function hasNotExtention ( $filePath ) {
		return ! $this->hasExtention ( $filePath );
	}
	
}