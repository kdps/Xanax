<?php

$PATH = require __DIR__."/_PATH.php";
require $PATH."/Interface/Directory/DirectoryHandlerInterface.php";
require $PATH."/Interface/File/FileSystemInterface.php";
require $PATH."/Interface/File/FileHandlerInterface.php";
require $PATH."/Validation/FileValidation.php";
require $PATH."/Validation/PHPValidation.php";
require $PATH."/Message/File/FileHandlerMessage.php";
require $PATH."/Exception/File/IOException.php";
require $PATH."/Exception/File/TargetIsNotFileException.php";
require $PATH."/Exception/File/FileIsNotExistsException.php";
require $PATH."/Classes/Encode/Encode.php";
require $PATH."/Classes/FileSystem/FileSystemHandler.php";
require $PATH."/Classes/Directory/DirectoryHandler.php";
require $PATH."/Classes/File/FileObject.php";
require $PATH."/Classes/File/FileHandler.php";

require $PATH."/Classes/EventDispatcher/EventInstance.php";
require $PATH."/Classes/EventDispatcher/EventDispatcher.php";

use Xanax\Classes\EventDispatcher;

use Xanax\Classes\FileHandler;
use Xanax\Classes\FileObject;

class FileExample {
	
	function appendContent () {
		$fileHandler = new FileHandler();
		$fileHandler->appendFileContent(__DIR__."/file.txt", "test", true);
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
	
}
$fileExample = new FileExample();
$fileHandler = new FileHandler();

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener("foo.test", array($fileExample, 'appendContent'));
$eventDispatcher->addListener("foo.test", array($fileExample, 'readAllContent'));
$eventDispatcher->addListener("foo.test", array($fileExample, 'isEqualByLine'));
$eventDispatcher->addListener("foo.test", array($fileExample, 'isContainFolder'));
$eventDispatcher->Dispatch("foo.test");