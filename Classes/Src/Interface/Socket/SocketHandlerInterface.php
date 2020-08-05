<?php

interface SocketHandlerInterface {
	
	public function Create($domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP) :resource;

	public function getPeerName($socketHandler) :array;

	public function Close($socketHandler) :void;

	public function Select(array $socketArray, $write = null, $except = null, $timeout = 10);

	public function AcceptConnect($socketHandler);

	public function Listen($socketHandler) :bool;

	public function Bind($socketHandler, $address, $port) :bool;

	public function readPacket($socketHandler, $length, $type = PHP_BINARY_READ) :string;

	public function writeSocket($socketHandler, $buffer, $length = -1) :int;

	public function Connect($socketHandler, $address, $port) :bool;

	public function getLastErrorMessage();
	
}
