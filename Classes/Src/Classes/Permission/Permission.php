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

  public function hasSetUidMode()
  {
    return ($this->hasDirectoryMode() && parent::$mode & 0x0800);
  }
  
  public function hasSetGidMode()
  {
    return (parent::$mode & 0x0800);
  }
  
  public function hasReadMode()
  {
    return (parent::$mode & 0x0100);
  }
  
  public function hasWriteMode()
  {
    return (parent::$mode & 0x0020);
  }
  
  public function hasDirectoryMode()
  {
    return (parent::$mode & 0x0040);
  }
  
}
