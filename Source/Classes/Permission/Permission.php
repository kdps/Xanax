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

  public function getMode()
  {
    return self::$mode;
  }

  public function isFirstInFirstOutPipe()
  {
    return (self::$mode & 0x0100);
  }
  
  public function isSpecialCharacters()
  {
    return (self::$mode & 0x0020);
  }
  
  public function isDirectory()
  {
    return (self::$mode & 0x0040);
  }
  
  public function isBlockSpecial()
  {
    return (self::$mode & 0x6000);
  }
  
  public function isRegular()
  {
    return (self::$mode & 0x0800);
  }
  
  public function isSymbolicLink()
  {
    return (self::$mode & 0xA000);
  }
  
  public function isSocket()
  {
    return (self::$mode & 0xC000);
  }
  
}
