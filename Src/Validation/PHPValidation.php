<?php
namespace Xanax\Validation;

class PHPValidation {
	
	public static function getVersion () {
		return phpversion();
	}
	
	public static function versionGreaterThanCurrent ( $version ) {
		$bool = version_compare( phpversion(), $version, '<' ) ? true : false;
		
		return $bool;
	}
	
	public static function versionCompare ( $version1, $version2 ) {
		$bool = version_compare( $version1, $version2 ) >= 0 ? true : false;
		
		return $bool;
	}
	
}