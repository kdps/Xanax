<?php

namespace Xanax\Exception\FileHandler;

use Exception;

class TargetIsNotFileException extends IOException {
	
	public function __construct(string $message = null, int $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
	
}