<?php

namespace Xanax\Classes\Regex;

use Xanax\Traits\Regex\Error;

class StringResult
{
  public function __constructor(array $result)
  {
    $this->boolean = $result['Boolean'];
    $this->pattern = $result['Pattern'];
    $this->subject = $result['Subject'];
    $this->matches = $result['Matches'];
  }
  
  public function getSingleton(array $result)
  {
      return new static ($result);
  }
  
  public function Get()
  {
    
  }
}
