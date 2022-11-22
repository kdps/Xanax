<?php


declare(strict_types=1);

namespace Xanax\Classes;

class CacheControl extends Header
{

	public function response($value)
	{
		parent::responseWithKey('Cache-Control', $value);
	}

	public function minFresh($value)
	{
		$key = "min-fresh";
		$data = "$key=$value";

		$this->response($data);
	}

	public function maxStale($value)
	{
		$key = "max-stale";
		$data = "$key=[=$value]";

		$this->response($data);
	}

	public function maxAge($value)
	{
		$key = "max-age";
		$data = "$key=$value";

		$this->response($data);
	}

	public function onlyIfCached()
	{
		$this->response('only-if-cached');
	}

	public function noStore()
	{
		$this->response('no-store');
	}

	public function noTransform()
	{
		$this->response('no-transform');
	}

	public function noCache()
	{
		$this->response('no-cache');
	}

}
