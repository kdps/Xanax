<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class ArrayResult
{
  public function __constructor(array $result)
  {
    $this->result = $result;
  }
  
  public function Result(array $result)
  {
      return new static ($result);
  }
}
