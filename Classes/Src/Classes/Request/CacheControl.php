<?php


declare(strict_types=1);

namespace Xanax\Classes;

class CacheControl extends Header 
{
	
	public function response($value)
	{
		$parent->responseWithKey('Cache-Control', $value);
	}
	
	public function responseMinFresh($value)
	{
		$key = "min-fresh";
		$data = "$key=$value";
		
		$this->response($data);
	}
	
	public function responseMaxStale($value)
	{
		$key = "max-stale";
		$data = "$key=[=$value]";
		
		$this->response($data);
	}
	
	public function responseMaxAge($value)
	{
		$key = "max-age";
		$data = "$key=$value";
		
		$this->response($data);
	}
	
	public function responseOnlyIfCached()
	{
		$this->response('only-if-cached');
	}
	
	public function responseNoStore()
	{
		$this->response('no-store');
	}
	
	public function responseNoTransform()
	{
		$this->response('no-transform');
	}
	
	public function responseNoCache()
	{
		$this->response('no-cache');
	}
	
}
