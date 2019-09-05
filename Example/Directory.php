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

use Xanax\Classes\DirectoryHandler;

$directoryHandler = new DirectoryHandler();
echo "File count in current directory : ".$directoryHandler->getFileCount( "." )."<Br>";
echo "File size in current directory : ".$directoryHandler->getSize( "." )."<Br>";
echo "Root Directory Size : ".($directoryHandler->getFreeSpace() === -1 ? "[disk_free_space() has been disabled for security reasons] Could not determine root size" : $directoryHandler->getFreeSpace())."<Br>";
