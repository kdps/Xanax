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
	
	public function getTemporary() {
		return "php://temp";
	}
	
	public function getMemory() {
		return "php://memory";
	}
	
	public function getInput() {
		return "php://input";
	}
	
	public function getOutput() {
		return "php://output";
	}
	
}
