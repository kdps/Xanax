<?php

private $date = '';

class Date
{
  
  public function __construct($date) {
    $this->date = $date;
  }
  
  public function stringToTime($string, $format) {
    return strtotime($string, $format);
  }
  
  public function getDateArray() {
    return getdate($this->date);
  }
  
  public function parseString($format) {
    return strptime($this->date, $format);
  }
  
  public function timeToString() {
    return strftime($this->date);
  }
  
  public function getTime() {
    return time();
  }
  
  public function getDayOfWeek($date) {
    $dayofweek = date('w', $date);
    
    return $dayofweek;
  }
  
}
