<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class Builder
{

  // http://vs-shop.cloudsite.ir/manual/kr/language.variables.basics.php
  public function validPHPVariableName() {
    return "[a-zA-Z_\x7f-\xff]";
  }
  
  public function unicodeCategory() {
    return "\p{L}"
  }
  
  public function branchResetGroup($regex) {
    return "(?|${regex})";
  }
  
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
