<?php

namespace Xanax/Classes/Permission;

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
  
}
