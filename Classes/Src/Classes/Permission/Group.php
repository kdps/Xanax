<?php

namespace Xanax/Classes/Permission;

class Group extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
}
