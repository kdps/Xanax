<?php

namespace Xanax/Classes/Data;

class Identifier
{
  public function isCountable()
  {
    return (is_countable(parent::$data));
  }
  
  public function isCallable()
  {
    return (is_callable(parent::$data));
  }
  
  public function isResource()
  {
    return (is_resource(parent::$data));
  }
  
  public function isIterable()
  {
    return (is_iterable(parent::$data));
  }
  
  public function isDouble()
  {
    return (is_double(parent::$data));
  }
  
  public function isLong()
  {
    return (is_long(parent::$data));
  }
  
  public function isNull()
  {
    return (is_null(parent::$data));
  }
  
  public function isScalar()
  {
    return (is_scalar(parent::$data));
  }
  
  public function isEmpty()
  {
    return (empty(parent::$data));
  }
  
  public function isFloat()
  {
    return (is_float(parent::$data));
  }
 
  public function toFloat() 
  { 
    return (float)parent::$data; 
  }
  
  public function isInteger()
  {
    return (is_int(parent::$data));
  }
  
  public function toInteger() 
  { 
    return (int)parent::$data; 
  }
  
  public function isObject()
  {
    return (is_object(parent::$data));
  }
  
  public function toObject() 
  { 
    return (object)parent::$data; 
  }
  
  public function isArray()
  {
    return (is_array(parent::$data));
  }
  
  public function toArray() 
  { 
    return (array)parent::$data; 
  }
  
  public function isString()
  {
    return (is_string(parent::$data));
  }
  
  public function toString() 
  { 
    return (string)parent::$data; 
  }
  
  public function isBoolean()
  {
    return (is_bool(parent::$data));
  }
  
  public function toBoolean() 
  { 
    return (bool)parent::$data; 
  }
  
  public function isNumberic()
  {
    return (is_numeric(parent::$data));
  }
  
  public function toInteger($base = 10)
  {
    return (int)(parent::$data);
  }
  
  public function toBase($base = 10)
  {
    return intval(parent::$data, $base);
  }
  
  public function isDate()
  {
    return (strtotime(parent::$data !== false);
  }
  
}
