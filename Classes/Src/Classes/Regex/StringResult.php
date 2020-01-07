<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class StringResult
{
  public function __constructor(array $result)
  {
    $this->result = $result;
  }
  
  public function getSingleton(array $result)
  {
      return new static ($result);
  }
  
  public function Get()
  {
  }
}
