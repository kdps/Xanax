<?php

$PATH = require __DIR__."/_PATH.php";
require $PATH."/Classes/EventDispatcher/EventDispatcher.php";
require $PATH."/Classes/EventDispatcher/EventInstance.php";
use Xanax\Classes\EventDispatcher;

class Listener {
    public function action() {
		echo "test";
    }
}

$eventDispatcher = new EventDispatcher();
$listener = new Listener();
$eventDispatcher->addListener("foo.test", array($listener, 'action'));
$eventDispatcher->Dispatch('foo.test');