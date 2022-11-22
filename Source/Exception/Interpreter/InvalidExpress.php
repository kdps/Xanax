<?php

namespace Xanax\Exception\Interpreter;

class InvalidExpress extends InvalidExpressException {
	
	public function __construct(string $message = null, int $code = 0, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	
}
