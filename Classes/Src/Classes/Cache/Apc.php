<?php

class Apc
{
	public function Truncate()
	{
		return apc_clear_cache('user');
	}
	
	public function Set($key, $validTime, $buffer)
	{
		return apc_store($key, array($_SERVER['REQUEST_TIME'], $buffer), $validTime);
	}
	
	public function Delete($key)
	{
		return $key and apc_delete($key);
	}
	
	public function Get($key, $limit)
	{
		$cache = apc_fetch($key, $limit);
		if($limit > 0 && $limit > $cache[0])
		{
			$this->Delete($key);
		}
		
		return $cache[1];
	}
}

?>