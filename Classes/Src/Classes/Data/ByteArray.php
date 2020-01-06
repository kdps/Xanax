<?php

class ByteArray
{
  public function toString()
  {
    return implode(array_map("chr", parent::$data));
  }
  
  public function toByteArray()
  {
    parent::$data = unpack('C*', parent::$data);
  }
  
}
