<?php

namespace Xanax\Classes\Permission;

use Xanax\Classes\Permission;

class Group extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
  public function isReadable()
  {
    return (self::$mode & 0x0020);
  }
  
  public function isWritable()
  {
    return (self::$mode & 0x0010);
  }
  
  public function getExecutableUsers()
  {
    return ((self::$mode & 0x0008) ?
      ((self::$mode & 0x0400) ? 's' : 'x')  :
      ((self::$mode & 0x0400) ? 'S' : '-'));;
  }
}
