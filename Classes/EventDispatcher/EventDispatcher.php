<?php

namespace Xanax\Classes;

class EventDispatcher {

	private $listeners = [];

	public function Listen( string $event, callable $listener ) {
		$this->listeners[ $event ][] = $listener;
	}
	
	public function Emit( object $event ) {
		$listeners = $this->listeners[ get_class( $event ) ] ?? [];
		
		foreach ($listeners as $listener) {
			$listener($event);
		}
		
		return $event;
	}
	
}