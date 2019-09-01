<?php

$PATH = require __DIR__."/_PATH.php";
require $PATH."/Interface/DirectoryHandler/DirectoryHandlerInterface.php";
require $PATH."/Interface/FileHandler/FileHandlerInterface.php";
require $PATH."/Validation/FileValidation.php";
require $PATH."/Validation/PHPValidation.php";
require $PATH."/Message/FileHandler/FileHandlerMessage.php";
require $PATH."/Exception/FileHandler/IOException.php";
require $PATH."/Exception/FileHandler/TargetIsNotFileException.php";
require $PATH."/Exception/FileHandler/FileIsNotExistsException.php";
require $PATH."/Classes/Encode/Encode.php";
require $PATH."/Classes/DirectoryHandler/DirectoryHandler.php";
require $PATH."/Classes/FileHandler/FileObject.php";
require $PATH."/Classes/FileHandler/FileHandler.php";

use Xanax\Classes\FileHandler;
use Xanax\Classes\FileObject;

$fileHandler = new FileHandler();
$fileHandler->appendFileContent(__DIR__."/file.txt", "test", true);
$content = $fileHandler->readAllContent(__DIR__."/file.txt");
echo $fileHandler->isEqualByLine(__DIR__."/file.txt", "test") ? "true" : "false";
echo $content;