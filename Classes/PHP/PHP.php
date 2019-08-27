<?php
namespace Xanax\Classes;

class PHP {
	
	public function getVersion () {
		return phpversion();
	}
	
	public function versionGreaterThanCurrent ( $version ) {
		$bool = version_compare( $this->getVersion(), $version, '<' ) ? true : false;
		
		return $bool;
	}
	
	public function versionCompare ( $version1, $version2 ) {
		$bool = version_compare( $version1, $version2 ) >= 0 ? true : false;
		
		return $bool;
	}
	
}