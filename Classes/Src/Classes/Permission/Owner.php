<?php

namespace Xanax/Classes/Permission;

class Owner extends Permission
{

  private static $mode;

  public function __constructor()
  {
    self::$mode = parent::getMode();
  }
  
}
