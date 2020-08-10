<?php

namespace Xanax/Trait/Json;
trait Error
{

	public function getLastError() {
		return json_last_error();
	}
	
	public function hasError() {
		return $this->getLastError() !== JSON_ERROR_NONE;
	}
	
	public function hasSyntaxError() {
		return $this->getLastError() !== JSON_ERROR_SYNTAX;
	}
	
	public function isMalformed() {
		// TODO
		return $this->getLastError() === JSON_ERROR_STATE_MISMATCH;
	}
	
	public function isInvalid() {
		// TODO
		return $this->getLastError() === JSON_ERROR_STATE_MISMATCH;
	}
	
	public function isStackDepthExceeded() {
		return $this->getLastError() === JSON_ERROR_DEPTH;
	}
	
	// PHP 7
	
	public function isMalformedUTF8() {
		return $this->getLastError() === JSON_ERROR_UTF8;
	}
		
}
