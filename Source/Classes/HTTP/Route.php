<?php

declare(strict_types=1);

namespace Xanax\Classes\HTTP;

use Xanax\Enumeration\HTTPRequestMethod as HTTPRequestMethod;

class Request 
{
  private $routes = array();
  
  private function Unset()
  {
  }
  
  private function Set(HTTPRequestMethod $method, $pattern, $callback)
  {
    $this->routes[$method][] = array(
      'pattern' => $pattern,
      'callback' => $callback,
    );
  }
  
  public function Trigger()
  {
  }
  
  public function On(HTTPRequestMethod $method, $pattern, $callback)
  {
    $this->Set($method, $pattern, $callback);
  }
  
  public function onGet($pattern, $callback) 
  {
    $this->Set(HTTPRequestMethod::GET, $pattern, $callback);
  }
  
  public function onPost($pattern, $callback) 
  {
    $this->Set(HTTPRequestMethod::POST, $pattern, $callback);
  }
  
  public function onDelete($pattern, $callback) 
  {
    $this->Set(HTTPRequestMethod::DELETE, $pattern, $callback);
  }
  
  public function onPut($pattern, $callback) 
  {
    $this->Set(HTTPRequestMethod::PUT, $pattern, $callback);
  }
  
  public function onOptions($pattern, $callback) 
  {
    $this->Set(HTTPRequestMethod::OPTIONS, $pattern, $callback);
  }
  
  public function onPatch($pattern, $callback) 
  {
    $this->Set(HTTPRequestMethod::PATCH, $pattern, $callback);
  }
  
  public function Run()
  {
  }
  
}
