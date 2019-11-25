<?php

include './../vendor/autoload.php';

use Xanax\Classes\EventDispatcher;
use Xanax\Classes\DirectoryHandler;
use Xanax\Classes\FileHandler;

class FileExample
{
    public function appendContent()
    {
        $fileHandler = new FileHandler();
        $fileHandler->appendContent(__DIR__ . '/file.txt', 'test', true);
    }

    public function readAllContent()
    {
        $fileHandler = new FileHandler();
        echo $fileHandler->readAllContent(__DIR__ . '/file.txt');
        echo '<br>';
    }

    public function isEqualByLine()
    {
        $fileHandler = new FileHandler();
        echo $fileHandler->isEqualByLine(__DIR__ . '/file.txt', 'test') ? 'isEquals' : 'isNotEquals';
        echo '<br>';
    }

    public function isContainFolder()
    {
        $fileHandler = new FileHandler();
        echo $fileHandler->isContainFolder('./', __DIR__ . '/file.txt') ? 'isEquals' : 'isNotEquals';
        echo '<br>';
    }

    public function getTypeByHeader()
    {
        $fileHandler = new FileHandler();
        $directoryHandler = new DirectoryHandler();
        $fileList = $directoryHandler->getFileList();
        foreach ($fileList as $file) {
            echo $fileHandler->getTypeByHeader($file) . '<br>';
        }
    }
}

$fileExample = new FileExample();
$fileHandler = new FileHandler();

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener('foo.test', [$fileExample, 'appendContent']);
$eventDispatcher->addListener('foo.test', [$fileExample, 'readAllContent']);
$eventDispatcher->addListener('foo.test', [$fileExample, 'isEqualByLine']);
$eventDispatcher->addListener('foo.test', [$fileExample, 'isContainFolder']);
$eventDispatcher->addListener('foo.test2', [$fileExample, 'getTypeByHeader']);
$eventDispatcher->Dispatch('foo.test2');
