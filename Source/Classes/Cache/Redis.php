<?php

declare(strict_types=1);

namespace Xanax\Classes;

class Redis
{
	public function init($host, $port = '6379')
	{
		$this->cache = new Redis();
		$this->cache->connect($host, $port);

		if ($this->cache === FALSE) {
			preg_match('/redis_version:(.*?)\n/', static::$redis->info(), $info);
			if (version_compare(trim($info[1]), '1.2') < 0){
				return false;
			}
		}

		return true;
	}

	public function pushList($key, $value)
	{
		$this->cache->lpush($key, $value);
	}

	public function Delete($key, $value)
	{
		$this->cache->del($key, $value);

		static::$redis->expireat($key, time() + 3600);
	}

	public function Set($key, $value)
	{
		$this->cache->set($key, $value);
	}

	public function get($key)
	{
		$data = '';
		if($this->cache->exists($key)){
			$data = $this->cache->get($key);
		}

		return $data;
	}
}