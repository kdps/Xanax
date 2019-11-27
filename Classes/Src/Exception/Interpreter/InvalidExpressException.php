<?php

namespace Xanax\Exception\Interpreter;

class InvalidExpressException extends \RuntimeException
{
	public function __construct(string $message, int $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
