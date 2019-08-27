<?php

namespace Xanax\Classes;

use Xanax\Classes\PHP;

class FilenameHandler {
	
	//PHP 5.3.0
	public function isReadable ( $filename ) {
		if ( Xanax\Classes\PHP->versionGreaterThanCurrent("5.3.0") ) {
			if ( strlen($filename) >= PHP_MAXPATHLEN ) {
				return false;
			}
		}
		
		return true;
	}
	
}