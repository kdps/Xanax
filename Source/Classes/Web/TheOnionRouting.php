<?php

namespace Xanax\Classes\Web;

use Xanax\Classes\Web\InternetProtocol as InternetProtocol;
use Xanax\Classes\HTTP\Request as RequestHandler;

class TheOnionRouting {

	private static $internetProtocolClass;
	private static $requestHandlerClass;

	public function __constructor() {
		self::$internetProtocolClass = new InternetProtocol();
		self::$requestHandlerClass = new RequestHandler();
	}

	public function isExitNode() {
		$ipAddress = self::$requestHandlerClass::getRemoteIP();
		$serverPort = self::$requestHandlerClass::getPort();
		$reverseIP = self::$internetProtocolClass::toReverseOctet($_SERVER['REMOTE_ADDR']);

		$torExitNodeHostName = sprintf("%s.%s.%s.ip-port.exitlist.torproject.org", $reverseIP, $serverPort, $reverseIP);
		$hostName = self::$internetProtocolClass::getByHostname($torExitNodeHostName);

		return $hostName === '127.0.0.2';
	}
}
