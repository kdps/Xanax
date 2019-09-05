<?php

include("./../vendor/autoload.php");

use Xanax\Classes\DirectoryHandler;

$directoryHandler = new DirectoryHandler();
echo "File count in current directory : ".$directoryHandler->getFileCount( "." )."<Br>";
echo "File size in current directory : ".$directoryHandler->getSize( "." )."<Br>";
echo "Root Directory Size : ".($directoryHandler->getFreeSpace() === -1 ? "[disk_free_space() has been disabled for security reasons] Could not determine root size" : $directoryHandler->getFreeSpace())."<Br>";
