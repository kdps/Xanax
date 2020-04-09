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

  public function isFirstInFirstOutPipe()
  {
    return (parent::$mode & 0x0100);
  }
  
  public function isSpecialCharacters()
  {
    return (parent::$mode & 0x0020);
  }
  
  public function isDirectory()
  {
    return (parent::$mode & 0x0040);
  }
  
  public function isBlockSpecial()
  {
    return (parent::$mode & 0x6000);
  }
  
  public function isRegular()
  {
    return (parent::$mode & 0x0800);
  }
  
  public function isSymbolicLink()
  {
    return (parent::$mode & 0xA000);
  }
  
  public function isSocket()
  {
    return (parent::$mode & 0xC000);
  }
  
}
