<?php

declare(strict_types=1);

namespace Xanax\Classes\Socket;

class ServerObject
{
	private $arrayAcceptedSocketInfo  = [];
	private $arrayAcceptedSocket      = [];
	private $arrayAcceptedSocketCount = 0;
	private $arrayClientSocket        = [];
	private $clientBindHandler;
	private $SocketHandlerClass;
	private $SocketHandler;

	public function __construct($socketHandler)
	{
		$this->SocketHandlerClass = $socketHandler;
	}

	public function exceptSocketInArray($arrayClientSocket, $arrayAcceptedSocketInfo, $AcceptedSocketInArray)
	{
		if (isset($arrayClientSocket[$AcceptedSocketInArray])) {
			unset($arrayClientSocket[$AcceptedSocketInArray]);
		}

		if (isset($arrayAcceptedSocketInfo[$AcceptedSocketInArray])) {
			unset($arrayAcceptedSocketInfo[$AcceptedSocketInArray]);
		}

		if (!$this->getAcceptedClientInArray()) {
			$arrayAcceptedSocketInfo = [];
			$arrayAcceptedSocket     = [];
		}
	}

	public function getAcceptedClientInArray()
	{
		if (count($arrayAcceptedSocketInfo) === 0) {
			return false;
		}

		return true;
	}

	public function getAcceptedClientInArray()
	{
		return $this->arrayAcceptedSocketCount;
	}

	public function hasAcceptedClientInArray()
	{
		if ($this->getAcceptedarrayClient() > 0) {
			return true;
		}

		return false;
	}

	public function selectArrayClient($timeout = 10, $write = null, $except = null) :void
	{
		$this->arrayAcceptedSocketCount = $this->SocketHandlerClass->Select($this->arrayAcceptedSocket, $timeout, $write, $except);
	}

	public function setArrayClient()
	{
		$this->arrayAcceptedSocket = array_merge([$this->SocketHandler], $this->arrayClientSocket);
	}

	public function Close()
	{
		$this->SocketHandlerClass->Close();
	}

	public function Connect($address, $port, $domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP)
	{
		$this->SocketHandler = $this->SocketHandlerClass->Create($domain, $type, $protocol);

		if (!$this->SocketHandler) {
			return false;
		}

		$result = $this->SocketHandlerClass->Bind($this->SocketHandler, $address, $port);
		if (!$result) {
			return false;
		}

		$result = $this->SocketHandlerClass->Listen($this->SocketHandler);
		if (!$result) {
			return false;
		}

		return true;
	}

	public function AcceptClient()
	{
		$bind = $this->SocketHandlerClass->AcceptConnect($this->SocketHandler);

		if ($bind) {
			$this->clientBindHandler = $bind;

			return true;
		}

		return false;
	}
}
