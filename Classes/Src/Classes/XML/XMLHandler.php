<?php

namespace Xanax/Classes;

class XMLHandler
{
	
	private $data;
	
	public function Parse($text) {
		$this->data = simplexml_load_string($text);
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
