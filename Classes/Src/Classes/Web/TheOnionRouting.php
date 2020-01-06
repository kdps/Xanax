<?php

namespace Xanax/Classes;

use Xanax/Classes/InternetProtocol as InternetProtocol;

class TheOnionRouting
{

  private static $internetProtocolClass;

  public function __constructor()
  {
    self::$internetProtocolClass = new InternetProtocol();
  }
  
  public function isExitNode()
  {
    $reverseIP = self::$internetProtocolClass:toReverseOctet($_SERVER['REMOTE_ADDR']);
    
    $torExitNodeHostName = sprintf("%s.%s.%s.ip-port.exitlist.torproject.org", $reverseIP, $_SERVER['SERVER_PORT'], $reverseIP);
    $hostName = self::$internetProtocolClass:getByHostname($torExitNodeHostName);
    
    return $hostName === '127.0.0.2';
  }
}
