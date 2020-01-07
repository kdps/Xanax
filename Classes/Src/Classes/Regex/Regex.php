<?php

namespace Xanax/Classes;

use Xanax/Classes/Regex/StringResult as StringResult;
use Xanax/Classes/Regex/ArrayResult as ArrayResult;

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
    $bool = @preg_match($pattern, $subject, $matches);
    
    return StringResult::Result($pattern, $subject, $matches, $bool);
  }
  
  public static function matchAll(string $pattern, string $subject)
  {
    $bool = @preg_match_all($pattern, $subject, $matches);
    
    return ArrayResult::Result($pattern, $subject, $matches, $bool);
  }
  
  public static function Split(string $pattern, $subject, int $limit = -1)
  {
  }
  
  public static function Replace(string $pattern, string $replacement, $subject, int $limit = -1)
  {
  }
}
