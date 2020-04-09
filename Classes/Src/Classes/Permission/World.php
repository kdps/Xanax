<?php

namespace Xanax/Classes/Permission;

class World extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
  public function isReadable()
  {
    return (self::$mode & 0x0004);
  }
  
  public function isWritable()
  {
    return (self::$mode & 0x0002);
  }
  
  public function getExecutableUsers()
  {
    return ((self::$mode & 0x0001) ?
      ((self::$mode & 0x0200) ? 't' : 'x')  :
      ((self::$mode & 0x0200) ? 'T' : '-'));;
  }
}
