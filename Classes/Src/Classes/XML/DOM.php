<?php

namespace Xanax/Classes/XML;

class DOM
{
  
  private $dom;
  
	public function __constructor() {
    $this->dom = new DOMDocument;
	}
	
  public function Parse($xmlString) {
    $this->dom->loadXML($xmlString);
  }
  
  public function isValid() {
    if (!$this->dom) {
      return false;
    }
    
    return true;
  }
  
}
