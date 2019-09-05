<?php

include("./../vendor/autoload.php");

use Xanax\Classes\EventDispatcher;

use Xanax\Classes\DirectoryHandler;
use Xanax\Classes\FileHandler;
use Xanax\Classes\FileObject;

class FileExample {
	
	function appendContent () {
		$fileHandler = new FileHandler();
		$fileHandler->appendContent(__DIR__."/file.txt", "test", true);
	}

	function readAllContent () {
		$fileHandler = new FileHandler();
		echo $fileHandler->readAllContent(__DIR__."/file.txt");
		echo "<br>";
	}

	function isEqualByLine () {
		$fileHandler = new FileHandler();
		echo $fileHandler->isEqualByLine(__DIR__."/file.txt", "test") ? "isEquals" : "isNotEquals";
		echo "<br>";
	}

	function isContainFolder() {
		$fileHandler = new FileHandler();
		echo $fileHandler->isContainFolder("./", __DIR__."/file.txt") ? "isEquals" : "isNotEquals";
		echo "<br>";
	}
	
	function getTypeByHeader() {
		$fileHandler = new FileHandler();
		$directoryHandler = new DirectoryHandler();
		
		$iterator = new RecursiveIteratorIterator (
			new RecursiveDirectoryIterator( "./mp3", RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);
		
		$iterator->setMaxDepth( 10 );
		
		foreach( $iterator as $fileInformation ) {
			if ( !$fileInformation->isDir() ) {
				
				echo $fileHandler->getTypeByHeader($fileInformation->getRealPath())."<br>";
			}
		}
		
		
		echo "<br>";
	}
	
}

$fileExample = new FileExample();
$fileHandler = new FileHandler();

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener("foo.test", array($fileExample, 'appendContent'));
$eventDispatcher->addListener("foo.test", array($fileExample, 'readAllContent'));
$eventDispatcher->addListener("foo.test", array($fileExample, 'isEqualByLine'));
$eventDispatcher->addListener("foo.test", array($fileExample, 'isContainFolder'));
$eventDispatcher->addListener("foo.test2", array($fileExample, 'getTypeByHeader'));
$eventDispatcher->Dispatch("foo.test2");