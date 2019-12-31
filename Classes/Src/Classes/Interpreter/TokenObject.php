<?php

namespace Xanax\Classes;

class TokenObject
{
	private $type;

	private $string;

	public function __construct($type, $string)
	{
		$this->type   = $type;
		$this->string = $string;
	}
}
