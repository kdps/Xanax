<?php

declare(strict_types=1);

namespace Xanax\Classes;

use Xanax\Classes\Permission\Group as Group;
use Xanax\Classes\Permission\Owner as Owner;
use Xanax\Classes\Permission\World as World;

class Permission
{
  private static $mode;
  
  public function __constructor($mode)
  {
    self::$mode = $mode;
  }

}
