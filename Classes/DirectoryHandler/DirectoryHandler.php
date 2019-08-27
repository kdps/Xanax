<?php

namespace Xanax\Classes;

use Xanax\Interface\DirectoryHandlerInterface;

use Xanax\Classes\FileHandler;

use Xanax\Exception\Stupid\StupidIdeaException;
use Xanax\Exception\DirectoryeHandler\DirectoryIsNotExistsException;

use Xanax\Validation\DirectoryeHandler;

use Xanax\Message\DirectoryeHandlerMessage;

use Xanax\Classes\FilenameHandler;

class DirectoryHandler {

	private $directoryDepth;

	public function __construct () {
		$this->directoryDepth = -1;
	}
	
	public function isDirectory ( string $directoryPath ) {
		$return = is_dir( $directoryPath );
		
		return $return;
	}
	
	public function Make ( string $directoryPath ) {
		$this->Create( $directoryPath );
	}
	
	public function Create ( string $directoryPath ) {
		$return = mkdir( $directoryPath );
		
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
			rmdir ( $directoryPath );
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
				$this->Create($copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
			} else {
				Xanax\Classes\FileHandler->Copy( $item, $copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName() );
			}
		}
	}
	
	public function getSize ( string $directoryPath ) {
		if ( !$this->isDirectory( $directoryPath ) ) {
			
		}
		
		$size = 0;
		foreach( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ) ) as $file ) {
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
		
		$this->directoryDepth = $depth;
		
		return true;
	}
	
	public function Empty ( string $directoryPath ) {
		if ( !$this->isDirectory( $directoryPath ) ) {
			
		}
		
		$iterator = new RecursiveIteratorIterator (
			new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);
		
		if ( $this->directoryDepth !== -1 ) {
			$iterator->setMaxDepth( $this->directoryDepth );
		}
		
		foreach( $iterator as $fileinfo ) {
			if ( $fileinfo->isDir() ) {
				if( delete( $fileinfo->getRealPath() ) === false ) {
					return false;
				}
			} else {
				if( unlink( $fileinfo->getRealPath() ) === false ) {
					return false;
				}
			}
		}
		
		return true;
	}
	
}