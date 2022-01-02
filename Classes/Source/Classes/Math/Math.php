<?php

class Math {
 
  public function softmax($x) {
  }
 
  public function sigmoid($x) {
    return 1 / (1 + exp(-$x));
  }
  
  public function tanh($x) {
    if (function_exists('tanh')) {
      return tanh($x);
    }
    
    return (exp($x) - exp(-$x)) / (exp($x) + exp(-$x));
  }
  
  public function relu($x) {
    
  }
  
  public function gelu($x) {
  }
  
}
