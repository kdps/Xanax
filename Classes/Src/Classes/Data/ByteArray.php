<?php

class ByteArray
{
  public function toString()
  {
    return call_user_func_array("pack", array_merge(array("C*"), parent::$data)));
  }
  
  public function toByteArray()
  {
    parent::$data = unpack('C*', parent::$data);
  }
  
}
