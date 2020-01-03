<?php

namespace Xanax/Classes/Permission;

class Group extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
  public function hasSetUidMode()
  {
    return ($this->hasDirectoryMode() && self::$mode & 0x0800);
  }
  
  public function hasSetGidMode()
  {
    return (self::$mode & 0x0800);
  }
  
  public function hasReadMode()
  {
    return (self::$mode & 0x0100);
  }
  
  public function hasWriteMode()
  {
    return (self::$mode & 0x0020);
  }
  
  public function hasDirectoryMode()
  {
    return (self::$mode & 0x0040);
  }
  
}
