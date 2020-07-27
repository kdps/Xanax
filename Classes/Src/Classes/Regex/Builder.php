<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class Builder
{

  public function getFileName() {
    return "([^.\/]+)\.?[^.\/]*$";
  }

  public function numberFormat() {
    return "(?<=\d)(?=(\d\d\d)+(?!\d))";
  }

  public function positiveLookbehind($regex) {
    return "(?<=${regex})";
  }
  
  public function negativeLookbehind($regex) {
    return "(?<!${regex})";
  }
  
  public function positiveLookahead($regex) {
    return "(?=${regex})";
  }
  
  public function negativeLookahead($regex) {
    return "(?!${regex})";
  }

}
