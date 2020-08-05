<?php

declare(strict_types=1);

class OperationSystem {
	
	public function isCommandLineInterface() {
		return (php_sapi_name() === 'cli');
	}

	public function getBuiltOperationSystemString() {
		return PHP_OS;
	}
	
	public function getIntergerSize() {
		return PHP_INT_SIZE;
	}
	
	public function getMaximumIntergerSize() {
		return PHP_INT_MAX;
	}
	
	public function is4BitOSBitOS() {
		if (PHP_INT_MAX == 0x7) { // Maximum value of 4-bit sign integer
			return true;
		}

		return false;
	}

	public function is8BitOSBitOS() {
		if (PHP_INT_MAX == 0x7F) { // Maximum value of 8-bit sign integer
			return true;
		}

		return false;
	}

	public function is16BitOS() {
		if ($this->getIntergerSize() == 2 || $this->getMaximumIntergerSize() == 0x7FFF) { // Maximum value of 16-bit sign integer
			return true;
		}

		return false;
	}

	public function is32BitOS() {
		if ($this->getIntergerSize() == 4 || $this->getMaximumIntergerSize() == 0x7FFFFFFF) { // Maximum value of 32-bit sign integer
			return true;
		}

		return false;
	}

	public function is64BitOS() {
		if ($this->getIntergerSize() == 8 || $this->getMaximumIntergerSize() == 0x7FFFFFFFFFFFFFFF) { // Maximum value of 64-bit sign integer
			return true;
		}

		return false;
	}

	public function is128BitOS() {
		if ($this->getMaximumIntergerSize() == 0x80000000000000000000000000000000) { // Maximum value of 128-bit sign integer
			return true;
		}

		return false;
	}

	public function is256BitOS() {
		if ($this->getMaximumIntergerSize() == 0x8000000000000000000000000000000000000000000000000000000000000000) { // Maximum value of 256-bit sign integer
			return true;
		}

		return false;
	}

	public function isIIS() {
		return (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false);
	}

	public function getShortOperationSystemString() {
		return strtoupper(substr($this->getBuiltOperationSystemString(), 0, 3));
	}
	
	public function isWindows() {
		return ($this->getShortOperationSystemString() === 'WIN');
	}
	
}
