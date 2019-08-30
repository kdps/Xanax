<?php

$PATH = require __DIR__."/_PATH.php";
require $PATH."/Interface/FileHandler/FileHandlerInterface.php";
require $PATH."/Validation/FileValidation.php";
require $PATH."/Validation/PHPValidation.php";
require $PATH."/Message/FileHandler/FileHandlerMessage.php";
require $PATH."/Exception/FileHandler/IOException.php";
require $PATH."/Exception/FileHandler/TargetIsNotFileException.php";
require $PATH."/Exception/FileHandler/FileIsNotExistsException.php";
require $PATH."/Classes/FileHandler/FileHandler.php";

use Xanax\Classes\FileHandler;

$fileHandler = new FileHandler();
$fileHandler->appendFileContent(__DIR__."/file.txt", "test");