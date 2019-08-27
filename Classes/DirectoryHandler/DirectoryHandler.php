<?php

namespace Xanax\Classes;

use Xanax\Classes\FileHandler;
use Xanax\Exception\Stupid\StupidIdeaException;
use Xanax\Exception\DirectoryeHandler\DirectoryIsNotExistsException;
use Xanax\Validation\DirectoryeHandler;
use Xanax\Message\DirectoryeHandlerMessage;

class DirectoryHandler {

	function isDirectory ( $directoryPath ) {
		$return = is_dir( $directoryPath );
		
		return $return;
	}
	
	function Make ( $directoryPath ) {
		$this->Create( $directoryPath );
	}
	
	function Create ( $directoryPath ) {
		$return = mkdir( $directoryPath );
		
		return $return;
	}
	
	function isEmpty ( $directoryPath ) {
		$iterator = new RecursiveDirectoryIterator( $directoryPath, FilesystemIterator::SKIP_DOTS );
        $return = (iterator_count($iterator) === 0) ? true : false;
		
		return $return;
	}
	
	function Delete ( $directoryPath ) {
		if ( $this->isEmpty( $directoryPath ) || $this->Empty ($directoryPath) ) {
			rmdir ( $directoryPath );
		} else {
			return false;
		}
		
		return true;
	}
	
	function Copy ( $directoryPath, $copyPath ) {
		$directoryIterator = new \RecursiveDirectoryIterator($directoryPath, \RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $item) {
			if ($item->isDir()) {
				$fileSystem->mkdir($copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
			} else {
				Xanax\Classes\FileHandler->Copy($item, $copyPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
			}
		}
	}
	
	function Empty ( $directoryPath ) {
		if ( !$this->isDirectory( $directoryPath ) ) {
			
		}
		
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $directoryPath, RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		foreach($iterator as $fileinfo) {
			if($fileinfo->isDir()) {
				if(delete($fileinfo->getRealPath()) === false) {
					return false;
				}
			} else {
				if(unlink($fileinfo->getRealPath()) === false) {
					return false;
				}
			}
		}
		
		return true;
	}
	
}