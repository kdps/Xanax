<?php

namespace Xanax\Classes\Regex;

class Executor
{
  public static function Match(string $pattern, string $subject)
  {
    $bool = @preg_match($pattern, $subject, $matches);
    
    return ['Boolean' => $bool, 'Pattern' => $pattern, 'Subject' => $subject, 'Matches' => $matches];
  }
  
  public static function matchAll(string $pattern, string $subject)
  {
    $bool = @preg_match_all($pattern, $subject, $matches);
    
    return ['Boolean' => $bool, 'Pattern' => $pattern, 'Subject' => $subject, 'Matches' => $matches];
  }
}
