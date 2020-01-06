<?php

class InternetProtocol
{
  function toReverseOctet($inputip){
    $ipoc = explode(".", $inputip);
    
    return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
  }
}
