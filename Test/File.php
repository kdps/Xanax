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

use Xanax\Classes\FileHandler;
use Xanax\Classes\FileObject;

$fileHandler = new FileHandler();
$fileHandler->appendFileContent(__DIR__."/file.txt", "test", true);
$content = $fileHandler->readAllContent(__DIR__."/file.txt");
//echo $fileHandler->isEqualByLine(__DIR__."/file.txt", "test") ? "true" : "false";
//echo $content;

echo $fileHandler->isContainFolder("./", __DIR__."/file.txt") ? "true" : "false";