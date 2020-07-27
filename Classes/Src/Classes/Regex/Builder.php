<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class Builder
{

  // http://vs-shop.cloudsite.ir/manual/kr/language.variables.basics.php
  public function validPHPVariableName() {
    return "[a-zA-Z_\x7f-\xff]";
  }
  
  public function turnOnFreeSpacingMode() {
    return "(?x)";  
  }
  
  public function numbericSubroutine() {
    return "(?1)";
  }
  
  public function Recursion() {
    return "(?R)";
  }
  
  public function setComment($content) {
    return "(?#${content})"; 
  }
  
  public function unicodeCategory() {
    return "\p{L}"
  }
  
  public function branchResetGroup($subexpression) {
    return "(?|${subexpression})";
  }
  
  public function getFileName() {
    return "([^.\/]+)\.?[^.\/]*$";
  }
  
  public function atomicGroup($name, $subexpression) {
    return "(?>${subexpression})";
  }
  
  public function namedCapturingGroup($name, $subexpression) {
    return "(?P<${name}>${subexpression})";
  }
  
  public function noneCapturingGroup($subexpression) {
    return "(?:${subexpression})";
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

  public function positiveLookbehind($subexpression) {
    return "(?<=${subexpression})";
  }
  
  public function negativeLookbehind($subexpression) {
    return "(?<!${subexpression})";
  }
  
  public function positiveLookahead($subexpression) {
    return "(?=${subexpression})";
  }
  
  public function negativeLookahead($subexpression) {
    return "(?!${subexpression})";
  }

}
