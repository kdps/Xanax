<?php

declare(strict_types=1);

namespace Xanax\Classes\FileSystem;

use Xanax\Implement\FileSystemInterface as FileSystemInterface;

class Handler implements FileSystemInterface {
	
	public function __construct() {
	}

	public function getCurrentInode() {
		return getmyinode();
	}

	public function getStatFromIndex($filePath, $index) {
		$stat = $this->getStat($filePath);
		
		if (count($stat) >= $index) {
			return $stat[$index];
		}
		
		return false;
	}
	
	public function getStat($filePath) :array {
		$return = stat($filePath);

		return $return;
	}

	public function getDeviceNumber($filePath) {
		return $this->getStatFromIndex($filePath, 0);
	}

	public function getInodeNumber($filePath) {
		return $this->getStatFromIndex($filePath, 1);
	}

	public function getProtectionNumber($filePath) {
		return $this->getStatFromIndex($filePath, 2);
	}

	public function getLinkNumber($filePath) {
		return $this->getStatFromIndex($filePath, 3);
	}

	public function getOwnerUserID($filePath) {
		return $this->getStatFromIndex($filePath, 4);
	}

	public function getOwnerGroupID($filePath) {
		return $this->getStatFromIndex($filePath, 5);
	}

	public function getDeviceType($filePath) {
		return $this->getStatFromIndex($filePath, 6);
	}

	public function getSizeOfByte($filePath) {
		return $this->getStatFromIndex($filePath, 7);
	}

	public function getLastAccessTime($filePath) {
		return $this->getStatFromIndex($filePath, 8);
	}

	public function getLastModifiedTime($filePath) {
		return $this->getStatFromIndex($filePath, 9);
	}

	public function getLastInodeModifiedTime($filePath) {
		return $this->getStatFromIndex($filePath, 10);
	}

	public function getIOBlockSize($filePath) {
		return $this->getStatFromIndex($filePath, 11);
	}

	public function get512ByteAllocatedBlocks($filePath) {
		return $this->getStatFromIndex($filePath, 12);
	}
	
}
