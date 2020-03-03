<?php

namespace Xanax/Classes/Protocol/PHP;

class PHPProtocol {

	public function getStandardError() {
		return "php://stderr";
	}
	
	public function getStandardOutput() {
		return "php://stdout";
	}
	
	public function getStandardInput() {
		return "php://stdin";
	}
	
	public function getFilter() {
		return "php://filter";
	}
}
