<?php

namespace Xanax\Validation;

class FileValidation {
	
	function isPharProtocol ( $filePath ) {
		if( preg_match('/^phar:\/\/.*/i', $filePath) ) {
			return true;
		}
		
		return false;
	}
	
	function hasSubfolderSyntax ( $filePath ) {
		if( preg_match('/..\/$/i', $filePath) ) {
			return true;
		}
		
		return false;
	}
	
	function hasExtention ( $filePath ) {
		if( preg_match('/^.*\.[A-Za-z0-9]{1,5}$/i', $filePath) ) {
			return true;
		}
		
		return false;
	}
	
}