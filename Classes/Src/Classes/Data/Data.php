<?php

namespace Xanax/Classes;

use Xanax/Classes/Data/Identifier as Identifier;

class Data
{
  private static $data;
  
  public function __constructor($data)
  {
    self::$data = $data;
  }
  
}
