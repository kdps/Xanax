<?php

namespace Xanax/Classes/Regex;

use Xanax/Trait/Regex/Error;

class Builder
{

  // http://vs-shop.cloudsite.ir/manual/kr/language.variables.basics.php
  public function validPHPVariableName() {
    return "[a-zA-Z_\x7f-\xff]";
  }
  
  public function Repetition($expression, $repeat) {
    return "\b${expression}{${repeat}}\b";
  }

  public function setComment($content) {
    return "(?#${content})"; 
  }
  
  public function Recursion() {
    return "(?R)";
  }
  
  // Subroutine
  
  public function namedSubroutine($name) {
    return "(?P>${$name})";
  }
  
  public function numbericSubroutine($number) {
    return "(?${$number})";
  }
  
  // Condition
  
  public function Condition($expression, $then, $else) {
    return "(?(?=${expression})${then}|${else})";
  }
  
  public function namedConditionGroupingWhenValid($name, $expression, $condition, $then, $else) {
    return "(?<${name}>${expression})?${condition}(?(${name})${then}|${else})";
  }
  
  public function conditionGrouping($expression, $condition, $then, $else) {
    return "(${expression})?${condition}(?(1)${then}|${else})";
  }
  
  // Mode
  
  public function turnOnFreeSpacingMode() {
    return "(?x)";  
  }
  
  // String
  
  public function unicodeCategory() {
    return "\p{L}"
  }

  public function getAnyWordMoreThanOne() {
    return "\w+";
  }

  public function getAnyWordMoreThanOneWithoutBlank() {
    return "\S+";
  }
  
  // Groupping
  
  public function branchResetGroup($subexpression) {
    return "(?|${subexpression})";
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

  // Expression
  
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
  
  // Block
  
  public function blockTag($name) {
    return "<${name}>.*?<\/${name}>";
  }

  // Et greta
  
  public function getFileName() {
    return "([^.\/]+)\.?[^.\/]*$";
  }
  
  public function numberFormat() {
    return "(?<=\d)(?=(\d\d\d)+(?!\d))";
  }

}
