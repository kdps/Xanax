<?php

namespace Xanax\Classes;

class EventDispatcher {

	private $listeners = [];

	public function Listen(callable $listener) {
		$this->listeners[] = $listener;
	}
	
	public function Dispatch(object $event) {
		foreach ($this->listeners as $listener) {
			$listener($event);
		}
	}
	
}