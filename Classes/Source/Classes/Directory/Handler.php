<?php

declare(strict_types=1);

namespace Xanax\Classes\Directory;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Xanax\Implement\DirectoryHandlerInterface;
use Xanax\Implement\FileHandlerInterface;
use Xanax\Exception\DirectoryHandler\DirectoryIsNotExistsException as DirectoryIsNotExistsException;
use Xanax\Classes\File\Handler as FileHandler;

use function delete;

class Handler implements DirectoryHandlerInterface 
{
	private $fileHandler;
	private $directoryDepth;

	public function __construct(FileHandlerInterface $fileHandler = null) 
	{
		if ($fileHandler instanceof FileHandlerInterface) 
		{
			$this->fileHandler = $fileHandler;
		} 
		else 
		{
			$this->fileHandler = new FileHandler();
		}

		$this->directoryDepth = -1;
	}

	/**
	 * Get free space of root directory
	 *
	 * @param string $prefix
	 *
	 * @return int
	 */
	public function getFreeSpace($prefix = '/') 
	{
		$diskFreeSpaces = -1;

		if (function_exists('disk_free_space')) 
		{
			$diskFreeSpaces = disk_free_space($prefix);
		}

		return $diskFreeSpaces;
	}

	/**
	 * Get total space of root directory
	 *
	 * @param string $prefix
	 *
	 * @return int
	 */
	public function getTotalSpace($prefix = '/') 
	{
		$diskFreeSpaces = -1;

		if (function_exists('disk_total_space')) 
		{
			$diskFreeSpaces = disk_total_space($prefix);
		}

		return $diskFreeSpaces;
	}

	public function hasCurrentWorkingLocation() 
	{
		return $this->getCurrentWorkingLocation();
	}

	public function getCurrentWorkingLocation() 
	{
		return getcwd();
	}

	/**
	 * Check that path is directory
	 *
	 * @param string $directoryPath
	 *
	 * @return boolean
	 */
	public function isDirectory(string $directoryPath) 
	{
		$return = is_dir($directoryPath);

		return $return;
	}

	/**
	 * Make directory with permissions
	 *
	 * @param string $directoryPath
	 * @param int    $permission
	 *
	 * @return boolean
	 */
	public function Make(string $directoryPath, int $permission = 644) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		return $this->Create($directoryPath);
	}

	public function Create(string $directoryPath, int $permission = 644) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$return = mkdir($directoryPath, $permission);

		return $return;
	}

	/**
	 * Get file counts of directory
	 *
	 * @param string $directoryPath
	 *
	 * @return int
	 */
	public function getFileCount(string $directoryPath) :int 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$iterator = new \RecursiveDirectoryIterator($directoryPath, \FilesystemIterator::SKIP_DOTS);
		$return   = iterator_count($iterator);

		return $return;
	}

	/**
	 * Check that directory is empty
	 *
	 * @param string $directoryPath
	 *
	 * @return boolean
	 */
	public function isEmpty(string $directoryPath) :bool 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		return ($this->getFileCount($directoryPath) === 0);
	}

	/**
	 * Delete directory
	 *
	 * @param string $directoryPath
	 *
	 * @return boolean
	 */
	public function Delete(string $directoryPath) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		if ($this->isEmpty($directoryPath) || $this->Empty($directoryPath)) 
		{
			$iterator = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
				RecursiveIteratorIterator::CHILD_FIRST
			);

			$iterator->setMaxDepth(-1); // Absolutely delete folders

			foreach ($iterator as $fileInformation) 
			{
				if ($fileInformation->isDir()) 
				{
					if (unlink($fileInformation->getRealPath()) === false) 
					{
						return false;
					}
				}
			}
		} 
		else 
		{
			return false;
		}

		return true;
	}

	/**
	 * Copy directory to specific path
	 *
	 * @param string $directoryPath
	 * @param string $copyPath
	 *
	 * @return void
	 */
	public function Copy(string $directoryPath, string $copyPath) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$directoryIterator = new \RecursiveDirectoryIterator($directoryPath, \RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator          = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::SELF_FIRST);

		foreach ($iterator as $item) 
		{
			if ($item->isDir()) 
			{
				$this->Create($copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
			} 
			else 
			{
				$this->fileHandler->Copy($item, $copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
			}
		}
	}

	/**
	 * Get file size of directory
	 *
	 * @param string $directoryPath
	 *
	 * @return int
	 */
	public function getSize(string $directoryPath) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$size = 0;
		
		$skipDots = new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS);
		
		foreach (new RecursiveIteratorIterator($skipDots) as $file) 
		{
			$size += $file->getSize();
		}

		return $size;
	}

	/**
	 * Get configure max depth of recursive
	 *
	 * @return int
	 */
	public function getMaxDepth() 
	{
		return $this->directoryDepth;
	}

	/**
	 * Set configure max depth of recursive
	 *
	 * @param string $directoryPath
	 *
	 * @return int
	 */
	public function setMaxDepth(int $depth) 
	{
		if ($this->getMaxDepth() === $this->directoryDepth) 
		{
			return false;
		}

		$this->directoryDepth = intval($depth);

		return true;
	}

	/**
	 * Rename directory
	 *
	 * @param string $directoryPath
	 * @param string $replacement
	 *
	 * @return boolean
	 */
	public function Rename(string $directoryPath, string $string, string $replacement) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $folderPath => $fileInformation) 
		{
			if ($fileInformation->isDir()) 
			{
				$folderPath       = $fileInformation->getPathName();
				$newDirectoryName = preg_replace($replacement, $string, $folderPath);

				if ($folderPath === $newDirectoryName) 
				{
					continue;
				}

				if (!$this->isDirectory($folderPath)) 
				{
					return false;
				}

				if ($this->isDirectory($newDirectoryName)) 
				{
					return false;
				}

				rename($folderPath, $newDirectoryName);
			}
		}

		return true;
	}

	/**
	 * Rename inner files
	 *
	 * @param string $directoryPath
	 * @param string $replacement
	 * @param string $string
	 *
	 * @return boolean
	 */
	public function RenameInnerFiles(string $directoryPath, $replacement, $string = null) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $path => $fileInformation) 
		{
			if ($fileInformation->isDir()) 
			{
				$rootDirectory = $fileInformation->getPathName();

				foreach (scandir($rootDirectory) as $targetFilename) 
				{
					$filePath = sprintf('%s/%s', $rootDirectory, $targetFilename);

					$newFileName = $targetFilename;

					if (@preg_match($replacement, null) === true) 
					{
						$newFileName = preg_replace($replacement, $string, $targetFilename);
					}

					$newFileName = sprintf('%s/%s', $rootDirectory, $newFileName);

					if ($filePath === $newFileName) 
					{
						continue;
					}

					if (!$this->fileHandler->isExists($filePath)) 
					{
						return false;
					}

					if (!$this->fileHandler->isExists($newFileName)) 
					{
						return false;
					}

					rename($filePath, $newFileName);
				}
			}
		}

		return true;
	}

	/**
	 * Get file list of directory
	 *
	 * @param string  $directoryPath
	 * @param boolean $sort
	 *
	 * @return array
	 */
	public function getFileList($directoryPath = './', $sort = false) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$fileList = [];

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		if ($this->getMaxDepth() !== -1) 
		{
			$iterator->setMaxDepth($this->getMaxDepth());
		}

		foreach ($iterator as $fileInformation) 
		{
			if ($fileInformation->isFile()) 
			{
				$fileList[] = $fileInformation->getRealPath();
			}
		}

		if ($sort) {
			sort($fileList);
		}

		return $fileList;
	}

	public function Empty(string $directoryPath) 
	{
		if (!$this->isDirectory($directoryPath)) 
		{
			throw new DirectoryIsNotExistsException();
		}

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		if ($this->getMaxDepth() !== -1) 
		{
			$iterator->setMaxDepth($this->getMaxDepth());
		}

		foreach ($iterator as $fileInformation) 
		{
			if (!$fileInformation->isDir()) 
			{
				if (unlink($fileInformation->getRealPath()) === false) 
				{
					return false;
				}
			}
		}

		return true;
	}
	
}
