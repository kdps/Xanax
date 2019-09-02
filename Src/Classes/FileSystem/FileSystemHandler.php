<?php

namespace Xanax\Classes;

class FileSystemHandler implements FileSystemInterface {
	
	public function __construct () {
	}
	
	public function getCurrentInode () {
		return getmyinode();
	}
	
	public function getStat ( $filePath ) :array {
		$return = stat ( $filePath );
		
		return $return;
	}
	
	public function getDeviceNumber ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[0];
	}
	
	public function getInodeNumber ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[1];
	}
	
	public function getProtectionNumber ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[2];
	}
	
	public function getLinkNumber ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[3];
	}
	
	public function getOwnerUserID ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[4];
	}
	
	public function getOwnerGroupID ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[5];
	}
	
	public function getDeviceType ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[6];
	}
	
	public function getSizeOfByte ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[7];
	}
	
	public function getLastAccessTime ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[8];
	}
	
	public function getLastModifiedTime ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[9];
	}
	
	public function getLastInodeModifiedTime ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[10];
	}
	
	public function getIOBlockSize ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[11];
	}
	
	public function get512ByteAllocatedBlocks ( $filePath ) {
		$stat = $this->getStat( $filePath );
		
		return $stat[12];
	}
	
}
