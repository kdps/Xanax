<?php

namespace Xanax\Exception\FileHandler;

class FileIsNotExistsException extends IOException
{
	public function __construct(string $message = null, int $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
