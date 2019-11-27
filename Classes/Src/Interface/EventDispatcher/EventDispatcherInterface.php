<?php

namespace Xanax\Implement;

interface EventDispatcherInterface
{
	public function Dispatch($event, string $eventName = null);

	public function removeListener(string $eventName, callable $listener);

	public function getListeners($eventName = '');

	public function getListenerCount($listeners) :int;

	public function hasListener(string $eventName) :bool;

	public function addListener(string $eventName, callable $listener) :void;

	public function Emit(object $event) :object;
}
