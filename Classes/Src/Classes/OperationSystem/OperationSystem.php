<?php

declare(strict_types=1);

class OperationSystem
{
	public function isCommandLineInterface()
	{
		return (php_sapi_name() === 'cli');
	}

	public function is4BitOSBitOS()
	{
		if (PHP_INT_MAX == 0x7) { // Maximum value of 4-bit sign integer
			return true;
		}

		return false;
	}

	public function is8BitOSBitOS()
	{
		if (PHP_INT_MAX == 0x7F) { // Maximum value of 8-bit sign integer
			return true;
		}

		return false;
	}

	public function is16BitOS()
	{
		if (PHP_INT_MAX == 0x7FFF) { // Maximum value of 16-bit sign integer
			return true;
		}

		return false;
	}

	public function is32BitOS()
	{
		if (PHP_INT_MAX == 0x7FFFFFFF) { // Maximum value of 32-bit sign integer
			return true;
		}

		return false;
	}

	public function is64BitOS()
	{
		if (PHP_INT_MAX == 0x7FFFFFFFFFFFFFFF) { // Maximum value of 64-bit sign integer
			return true;
		}

		return false;
	}

	public function is128BitOS()
	{
		if (PHP_INT_MAX == 0x80000000000000000000000000000000) { // Maximum value of 128-bit sign integer
			return true;
		}

		return false;
	}

	public function is256BitOS()
	{
		if (PHP_INT_MAX == 0x8000000000000000000000000000000000000000000000000000000000000000) { // Maximum value of 256-bit sign integer
			return true;
		}

		return false;
	}

	public function isIIS()
	{
		return (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false);
	}

	public function isWindows()
	{
		return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
	}
}
