<?php

namespace Xanax/Classes/Protocol;

class Protocol {

	public const _STANDARD_ERROR_ = "php://stderr";
	
	public const _STANDARD_OUTPUT_ = "php://stdout";
		
	public const _STANDARD_INPUT_ = "php://stdin";
	
	public const _FILTER_ = "php://filter";
	
	public const _TEMPORARY_ = "php://temp";
	
	public const _MEMORY_ = "php://memory";
	
	public const _INPUT_ = "php://input";
	
	public const _OUTPUT_ = "php://output";
	
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
