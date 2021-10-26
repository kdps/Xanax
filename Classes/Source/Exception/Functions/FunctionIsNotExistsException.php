<?php

namespace Xanax\Exception\Functions;

class FunctionIsNotExistsException extends FunctionIsNotExistsException
{
	public function __construct(string $message = null, int $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
