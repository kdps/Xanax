<?php

namespace Xanax/Classes/Permission;

class Owner extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
  public function isReadable()
  {
    return (self::$mode & 0x0100);
  }
  
  public function isWritable()
  {
    return (self::$mode & 0x0080);
  }
  
}
