<?php

class InternetProtocol
{
  public function getByHostname($hostname)
  {
    return getbyhostname($hostname);
  }
  
  public function toReverseOctet($inputip)
  {
    $ipoc = explode(".", $inputip);
    
    return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
  }
}
