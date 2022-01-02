<?php

class Math {
 
  public function erf() {
  }
 
  public function derivative() {
  }
 
  public function partial_derivative() {
  }
 
  public function backpropagtion() {
  }
 
  public function cross_entropy() {
  }
 
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
 
  // Scaled Exponential Linear Unit
  public function selu($x) {
    
  }
 
  // Exponential Linear Unit
  public function elu($x) {
    
  }
  
  public function maxout() {
    
  }
 
  // Sigmoid-Weighted Linear Unit
  public function swish($x) {
    
  }
  

  // Rectified Linear Unit
  public function relu($x) {
    
  }
  
 // Gaussian Error Linear Unit
  public function gelu($x) {
  }
  
}
