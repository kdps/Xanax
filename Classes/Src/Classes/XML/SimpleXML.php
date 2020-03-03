<?php

namespace Xanax/Classes/XML;

class SimpleXML
{
	
	private $data;
	
	public function Parse($text) {
		$this->data = simplexml_load_string($text);
	}
	
	public function fromFile($filePath) {
		$this->data = simplexml_load_file($filePath);
	}
	
	public function isValid() {
		if ($this->data == null || !$this->data) {
			return false;
		}
		
		return true;
	}
	
	public function getChildren() {
		return $this->data->children();
	}
	
}
