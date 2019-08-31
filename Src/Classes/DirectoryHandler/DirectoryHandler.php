<?php

namespace Xanax\Classes;

use Xanax\Implement\DirectoryHandlerInterface;
use Xanax\Implement\FileHandlerInterface;

use Xanax\Classes\FileHandler;

use Xanax\Exception\Stupid\StupidIdeaException;
use Xanax\Exception\DirectoryeHandler\DirectoryIsNotExistsException;

use Xanax\Validation\DirectoryeHandler;

use Xanax\Message\DirectoryeHandlerMessage;

class DirectoryHandler implements DirectoryHandlerInterface {

	private $fileHandler;
	private $directoryDepth;

	public function __construct ( $fileHandler ) {
		if ( $fileHandler instanceof FileHandlerInterface ) {
			$this->fileHandler = $fileHandler;
		} else {
			$this->fileHandler = new DirectoryHandler();
		}
		
		$this->directoryDepth = -1;
	}
	
	public function getFreeSpace ( $prefix = "/" ) {
		$diskFreeSpaces = disk_free_space( $prefix );
		
		return $diskFreeSpaces;
	}
	
	public function hasCurrentWorkingLocation () {
		if ( !$this->getCurrentWorkingLocation() ) {
			return false;
		}
		
		return true;
	}
	
	public function getCurrentWorkingLocation () {
		return getcwd();
	}
	
	public function isDirectory ( string $directoryPath ) {
		$return = is_dir( $directoryPath );
		
		return $return;
	}
	
	public function Make ( string $directoryPath, $permission = 644 ) {
		$this->Create( $directoryPath );
	}
	
	public function Create ( string $directoryPath, $permission = 644 ) {
		$return = mkdir( $directoryPath, $permission );
		
		return $return;
	}
	
	public function getFileCount ( string $directoryPath ) :int {
		$iterator = new \RecursiveDirectoryIterator( $directoryPath, \FilesystemIterator::SKIP_DOTS );
		$return = iterator_count( $iterator );
		
		return $return;
	}
	
	public function isEmpty ( string $directoryPath ) :bool {
        $return = ( $this->getFileCount( $directoryPath ) === 0 ) ? true : false;
		
		return $return;
	}
	
	public function Delete ( string $directoryPath ) {
		if ( $this->isEmpty( $directoryPath ) || $this->Empty ( $directoryPath ) ) {
			
			$iterator = new RecursiveIteratorIterator (
				new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ),
				RecursiveIteratorIterator::CHILD_FIRST
			);
			
			$iterator->setMaxDepth( -1 ); // Absolutely delete folders
			
			foreach( $iterator as $fileInformation ) {
				if ( $fileInformation->isDir() ) {
					if ( delete( $fileInformation->getRealPath() ) === false ) {
						return false;
					}
				}
			}
			
			return true;
		} else {
			return false;
		}
		
		return true;
	}
	
	public function Copy ( string $directoryPath, string $copyPath ) {
		$directoryIterator = new \RecursiveDirectoryIterator( $directoryPath, \RecursiveDirectoryIterator::SKIP_DOTS );
		$iterator = new \RecursiveIteratorIterator( $directoryIterator, \RecursiveIteratorIterator::SELF_FIRST );
		
		foreach ( $iterator as $item ) {
			if ( $item->isDir() ) {
				$this->Create( $copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName() );
			} else {
				$this->fileHandler->Copy( $item, $copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName() );
			}
		}
	}
	
	public function getSize ( string $directoryPath ) {
		if ( !$this->isDirectory( $directoryPath ) ) {
			
		}
		
		$size = 0;
		foreach( new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ) 
				) as $file ) {
			$size += $file->getSize();
		}
		
		return $size;
	}
	
	public function getMaxDepth () {
		return $this->directoryDepth;
	}
	
	public function setMaxDepth ( int $depth ) {
		if ( $this->getMaxDepth() === $this->directoryDepth ) {
			return false;
		}
		
		$this->directoryDepth = intval($depth);
		
		return true;
	}
	
	public function Rename ( string $directoryPath, $string, $replacement ) {
		$iterator = new RecursiveIteratorIterator (
			new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::SELF_FIRST
		);
		
		foreach ( $iterator as $folderPath => $fileInformation ) {
			
			if ( $fileInformation->isDir() ) {
				
				$folderPath = $fileInformation->getPathName();
				$newDirectoryName = preg_replace( $replacement, $string, $folderPath );
			
				if ( $filePath === $newFileName ) {
					continue;
				}
				
				if ( !$this->isDirectory($folderPath) ) {
					return false;
				}
				
				if ( $this->isDirectory($newDirectoryName) ) {
					return false;
				}
				
				rename ( $folderPath, $newDirectoryName );
				
			}
			
		}
		
		return true;
	}
	
	public function RenameInnerFiles ( string $directoryPath, $replacement, $string = null ) {
		$iterator = new RecursiveIteratorIterator (
			new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::SELF_FIRST
		);
		
		foreach ( $iterator as $path => $fileInformation ) {
			
			if ( $fileInformation->isDir() ) {
				
				$rootDirectory = $fileInformation->getPathName();
				
				foreach ( scandir($rootDirectory) as $targetFilename ) {
					$filePath = sprintf( "%s/%s", $rootDirectory, $targetFilename );
					
					$newFileName = $targetFilename;
					
					if ( @preg_match( $replacement, null ) === true ) {
						$newFileName = preg_replace( $replacement, $string, $targetFilename );
					}
					
					$newFileName = sprintf( "%s/%s", $rootDirectory, $newFileName );
					
					if ($filePath === $newFileName) {
						continue;
					}
					
					if ( !$this->fileHandler->isExists($filePath) ) {
						return false;
					}
					
					if ( !$this->fileHandler->isExists($newFileName) ) {
						return false;
					}
					
					rename ($filePath, $newFileName);
				}
				
			}
			
		}
		
		return true;
	}
	
	public function Empty ( string $directoryPath ) {
		if ( !$this->isDirectory( $directoryPath ) ) {
			
		}
		
		$iterator = new RecursiveIteratorIterator (
			new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);
		
		if ( $this->getMaxDepth() !== -1 ) {
			$iterator->setMaxDepth( $this->getMaxDepth() );
		}
		
		foreach( $iterator as $fileInformation ) {
			if ( !$fileInformation->isDir() ) {
				if( unlink( $fileInformation->getRealPath() ) === false ) {
					return false;
				}
			}
		}
		
		return true;
	}
	
}
