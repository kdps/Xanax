<?php

declare(strict_types = 1);

class OperationSystem {
	
	public function isCommandLineInterface() {
		return (php_sapi_name() === 'cli');
	}

	public function is4BitOSBitOS () {
		if ( PHP_INT_MAX == 7 ) { // Maximum value of 4-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function is8BitOSBitOS () {
		if ( PHP_INT_MAX == 127 ) { // Maximum value of 8-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function is16BitOS () {
		if ( PHP_INT_MAX == 32767 ) { // Maximum value of 16-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function is32BitOS () {
		if ( PHP_INT_MAX == 2147483647 ) { // Maximum value of 32-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function is64BitOS () {
		if ( PHP_INT_MAX == 9223372036854775807 ) { // Maximum value of 64-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function is128BitOS () {
		if ( PHP_INT_MAX == 170141183460469231731687303715884105728 ) { // Maximum value of 128-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function is256BitOS () {
		if ( PHP_INT_MAX == 57896044618658097711785492504343953926634992332820282019728792003956564819968 ) { // Maximum value of 256-bit sign integer
			return true;
		}
		
		return false;
	}
	
	public function isIIS () {
		return (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false);
	}
	
	public function isWindows () {
		return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
	}
	
}