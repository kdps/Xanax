<?php

class Handler {

	public function setError($errorRaised, $errorMessage, $fileName, $lineNumber, $context, callable $callback) {
		$previous = set_error_handler(function ($errorRaised, $errorMessage, $fileName, $lineNumber, $context) use (&$previous) {
			if ($previous && $callback instanceof callable) {
				$callback($errorRaised, $errorMessage, $fileName, $lineNumber, $context);
			} else {
				return false;
			}
		});
	}
	
	public function clearLastError() : Void {
		error_clear_last();
	}
	
	public function getLastError() : Array {
		return error_get_last();
	}
	
	public function setException(callable $exceptionFunction) {
		set_exception_handler($exceptionFunction);
	}
	
	public function restorePreviousErrorStack() {
		restore_error_handler();
	}
	
	public function restorePreviousExceptionStack() {
		restore_exception_handler();
	}
	
	public function Trigger($errorMessage) {
		trigger_error($errorMessage);
	}
	
}
