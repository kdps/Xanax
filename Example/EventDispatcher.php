<?php

include("./../vendor/autoload.php");

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