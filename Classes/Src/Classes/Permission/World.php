<?php

namespace Xanax/Classes/Permission;

class World extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
}
