<?php

declare(strict_types=1);

namespace Xanax\Classes;

class ClientObject
{
	private $SocketHandlerClass;
	private $SocketHandler;

	public function __construct($socketHandler)
	{
		if ($socketHandler insteadof \Xanax\Classes\Socket\Handler) {
			$this->SocketHandlerClass = $socketHandler;
		}
	}

	// Send packet to socket of server
	public function sendPacket($string = '')
	{
		$result = $this->SocketHandlerClass->writeSocket($this->SocketHandler, $string, strlen($string));

		if ($result === 0) {
			return false;
		}

		return true;
	}

	// Close socket
	public function Close()
	{
		$this->SocketHandlerClass->Close();
	}

	// Connect socket
	public function Connect($address, $port, $domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP) :bool
	{
		$this->SocketHandler = $this->SocketHandlerClass->Create($domain, $type, $protocol);

		if (!$this->SocketHandler) {
			return false;
		}

		$result = $this->SocketHandlerClass->Connect($this->SocketHandler, $address, $port);

		if (!$result) {
			return false;
		}

		return true;
	}
}
