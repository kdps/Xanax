<?php

namespace Xanax\Implement;

interface FileSystemInterface {
	
	public function getCurrentInode ();
	
	public function getStat ( $filePath ) :array;
	
	public function getDeviceNumber ( $filePath );
	
	public function getInodeNumber ( $filePath );
	
	public function getProtectionNumber ( $filePath );
	
	public function getLinkNumber ( $filePath );
	
	public function getOwnerUserID ( $filePath );
	
	public function getOwnerGroupID ( $filePath );
	
	public function getDeviceType ( $filePath );
	
	public function getSizeOfByte ( $filePath );
	
	public function getLastAccessTime ( $filePath );
	
	public function getLastModifiedTime ( $filePath );
	
	public function getLastInodeModifiedTime ( $filePath );
	
	public function getIOBlockSize ( $filePath );
	
	public function get512ByteAllocatedBlocks ( $filePath );
	
}