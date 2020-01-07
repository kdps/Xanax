<?php

namespace Xanax/Classes;

use Xanax/Classes/Regex/StringResult as StringResult;
use Xanax/Classes/Regex/ArrayResult as ArrayResult;
use Xanax/Classes/Regex/Executor as Executor;

class Regex
{
  public static function Filter(string $pattern, string $replacement, $subject)
  {
    
  }
  
  public static function Quote(string $string, string $delimiter = NULL)
  {
  }
  
  public static function Match(string $pattern, string $subject)
  {
    $result = Executor::Match($pattern, $subject, $matches);
    
    return ArrayResult::getSingleton($result);
  }
  
  public static function matchAll(string $pattern, string $subject)
  {
    $result = Executor::matchAll($pattern, $subject, $matches);
    
    return ArrayResult::getSingleton($result);
  }
  
  public static function Split(string $pattern, $subject, int $limit = -1)
  {
  }
  
  public static function Replace(string $pattern, string $replacement, $subject, int $limit = -1)
  {
  }
}
