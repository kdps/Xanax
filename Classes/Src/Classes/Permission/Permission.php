<?php

declare(strict_types=1);

namespace Xanax\Classes;

class Permission
{
  private static $mode;
  
  public function __constructor($mode)
  {
    self::$mode = $mode;
  }
  
}
