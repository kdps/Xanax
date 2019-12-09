<?php

include './../vendor/autoload.php';

use Xanax\Classes\EventDispatcher;

class Listener
{
	public function action()
	{
		echo 'test';
	}
}

$listener = new Listener();

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener('foo.test', [$listener, 'action']);
$eventDispatcher->Dispatch('foo.test');
