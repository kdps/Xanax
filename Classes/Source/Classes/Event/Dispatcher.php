<?php

declare(strict_types=1);

namespace Xanax\Classes\Event;

use Xanax\Implement\EventDispatcherInterface;

class Dispatcher implements EventDispatcherInterface
{
	private $listeners = [];

	public function Dispatch($event, string $eventName = null)
	{
		if (\is_object($event)) {
			$eventName = $eventName ?? \get_class($event);
		}

		if (!$eventName) {
			$eventName = $event;
			$event     = new EventInstance();
		}

		$listeners = $this->getListeners($eventName);

		if ($listeners) {
			$this->callListeners($listeners, $eventName, $event);
		}
	}

	protected function callListeners(iterable $listeners, string $eventName, object $event)
	{
		foreach ($listeners as $listener) {
			$listener($event, $eventName, $this);
		}
	}

	public function Dispose()
	{
	}

	public function addSubscriber()
	{
	}

	public function removeSubscriber()
	{
	}

	public function removeListener(string $eventName, callable $listener)
	{
		if (!$this->hasListener($eventName)) {
			return false;
		}
	}

	public function getListeners($eventName = '')
	{
		return isset($eventName) ? $this->listeners[$eventName] : $this->listeners;
	}

	public function getListenerCount($listeners) :int
	{
		return count($listeners || $this->getListeners());
	}

	public function hasListener(string $eventName) :bool
	{
		if ($eventName !== null) {
			$listener = $this->getListeners($eventName);

			return !empty($listener);
		}

		if ($this->getListenerCount() <= 0) {
			return false;
		}

		foreach ($this->getListeners() as $listenerItem) {
			if ($listenerItem) {
				return true;
			}
		}

		return false;
	}

	public function addListener(string $eventName, callable $listener) :void
	{
		$this->listeners[$eventName][] = $listener;
	}

	public function Emit(object $event) :object
	{
		$listeners = $this->getListeners(get_class($event)) ?? [];

		if (count($listeners) <= 0) {
			//return false;
		}

		foreach ($listeners as $listener) {
			$listener($event);
		}

		return $event;
	}
}
