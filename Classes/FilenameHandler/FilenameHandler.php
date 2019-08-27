<?php

namespace Xanax\Classes;

class FilenameHandler {
	
	public function isReadable ( $filename ) {
		if ( strlen($filename) >= PHP_MAXPATHLEN ) {
			return false;
		}
		
		return true;
	}
	
}