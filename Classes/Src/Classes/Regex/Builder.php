<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class Builder
{

  public function getFileName() {
    return "([^.\/]+)\.?[^.\/]*$";
  }

  public function namedCapturingGroup($name, $regex) {
    return "(?P<${name}>${regex})";
  }
  
  public function noneCapturingGroup($regex) {
    return "(?:${regex})";
  }

  public function numberFormat() {
    return "(?<=\d)(?=(\d\d\d)+(?!\d))";
  }

  public function getAnyWordMoreThanOne() {
    return "\w+";
  }

  public function getAnyWordMoreThanOneWithoutBlank() {
    return "\S+";
  }
  
  public function blockTag($name) {
    return "<${name}>.*?<\/${name}>";
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
