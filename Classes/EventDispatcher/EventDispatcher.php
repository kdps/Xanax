<?php

namespace Xanax\Classes;

class EventDispatcher {

	private $listeners = [];
	
	public function removeListener( string $eventName, callable $listener ) {
		if ( $this->hasListener( $eventName ) ) {
			
		}
	}
	
	public function getListeners ($eventName = '') {
		return isset($eventName) ? $this->listeners[$eventName] : $this->listeners;
	}
	
	public function getListenerCount ($listeners) :int {
		return count ($listeners || $this->getListeners());
	}
	
	public function hasListener ( string $eventName ) {
		if ( $eventName !== null ) {
			$listener = $this->getListeners( $eventName );
			return !empty($listener);
		}
		
		if ( $this->getListenerCount() <= 0 ) {
			return false;
		}
		
		foreach ( $this->getListeners() as $listenerItem ) {
			if ( $listenerItem ) {
				return true;
			}
		}
		
		return false;
	}
	
	public function addListener ( string $eventName, callable $listener ) {
		if ( $this->hasListener( $eventName ) ) {
			return;
		}
		
		$this->listeners[ $eventName ][] = $listener;
	}
	
	public function Emit ( object $event ) {
		$listeners = $this->getListeners( get_class( $event ) ) ?? [];
		
		if ( count($listeners) <= 0 ) {
			return;
		}
		
		foreach ($listeners as $listener) {
			$listener($event);
		}
		
		return $event;
	}
	
}