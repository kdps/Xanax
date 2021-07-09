<?php

declare(strict_types=1);

namespace Xanax\Classes;

class Memcache
{
	protected $type;
	protected $cache;

	public function __construct()
	{
		if ($this->isMemcachedClassExists()) {
			$this->cache = new Memcached;
			$this->type = "memcached";
		} else if ($this->isMemcacheClassExists()) {
			$this->cache = new Memcache;
			$this->type = "memcache";
		}
	}

	public function isMemcacheClassExists()
	{
		return class_exists('Memcache');
	}

	public function isMemcachedClassExists()
	{
		return class_exists('Memcached');
	}

	public function addServer($host, $port)
	{
		$this->cache->addServer($host, $port);
	}

	public function Truncate()
	{
		return $this->cache->flush();
	}

	public function Set($key, $validTime, $buffer){
		if ($this->type == "memcached") {
			return $this->set($key, array(time(), $buffer), $validTime);
		} else if($this->type == "memcache") {
			return $this->set($key, array(time(), $buffer), \MEMCACHE_COMPRESSED, $validTime);
		}
	}

	public function Delete($key){
		return $this->cache->delete($key);
	}

	public function Get($key, $limit){
		$cache = $this->cache->get($key);
		if($limit > 0 && $limit > $cache[0]){
			$this->Delete($key);
		}

		return $cache[1];
	}
}