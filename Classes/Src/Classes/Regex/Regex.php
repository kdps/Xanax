<?php

namespace Xanax/Classes;

class Regex
{

  public function hasError()
  {
    return PREG_NO_ERROR === preg_last_error();
  }
}
