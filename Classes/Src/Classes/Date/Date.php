<?php

private $date = '';

class Date
{
  
  public function __construct($date) {
    $this->date = $date;
  }
  
  public function toTime() {
    $this->date = strtotime($date);
  }
  
  public function toString() {
    $this->date = strftime($this->date);
  }
  
  public function getTime() {
    return time();
  }
  
  public function getDayOfWeek() {
    $dayofweek = date('w', $this->date);
    
    return $dayofweek;
  }
  
}
