<?php

class SessionHandler {
	
	public function __construct () {
		if (is_cli()) {
			return;
		}
		
		
	}
	
	public function isStated () {
		if (session_status() == PHP_SESSION_NONE && empty($_SESSION)) {
			return false;
		}
		
		return true;
	}
	
	public function Get ( $parameter ) {
		return $_SESSION[ $parameter ] ? $_SESSION[ $parameter ] : null;
	}
	
}