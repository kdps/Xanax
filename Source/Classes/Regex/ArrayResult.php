<?php

namespace Xanax\Classes\Regex;

use Xanax\Traits\Regex\RegexError;

class ArrayResult
{
  public function __constructor(array $result)
  {
    $this->boolean = $result['Boolean'] ?? false;
    $this->pattern = $result['Pattern'] ?? "";
    $this->subject = $result['Subject'] ?? "";
    $this->matches = $result['Matches'] ?? "";
  }
  
  public function getSingleton(array $result)
  {
      return new static ($result);
  }
  
  public function hasResult()
  {
    return $this->boolean;
  }
  
  public function getPattern()
  {
    return $this->pattern;
  }
  
  public function getSubject()
  {
    return $this->subject;
  }
  
  public function getMatches()
  {
    return $this->matches;
  }
  
  public function getByIndex(int $index = 0)
  {
    $matches = $this->getMatches();
    
    return $matches[$index] ?? "";
  }
  
  public function getResults()
  {
    return $this->getMatches();
  }
  
}
