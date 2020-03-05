<?php

class Exception {

	public function setErrorHandler($errorRaised, $errorMessage, $fileName, $lineNumber, $context, callable $callback) {
		$previous = set_error_handler(function ($errorRaised, $errorMessage, $fileName, $lineNumber, $context) use (&$previous) {
			if ($previous) {
				if ($callback instanceof callable) {
					$callback($errorRaised, $errorMessage, $fileName, $lineNumber, $context);
				}
			} else {
				return false;
			}
		});
	}
	
}
