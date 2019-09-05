<?php

namespace Xanax\Classes;

use Xanax\Classes\SocketHandler as SocketHandler;

class SocketClientObject {
	
	private $connectedStatus = false;
	private $SocketHandlerClass;
	private $SocketHandler;
	
	public function __construct( $socketHandler ) {
		$this->SocketHandlerClass = $socketHandler;
	}
	
	public function sendPacket ( $string ) {
		$result = $this->SocketHandlerClass->writeSocket( $this->SocketHandler, $string, strlen($string) );
		if ( $result === 0 ) {
			return false;
		}
		
		
	}
	
	public function Connect( $domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP, $address, $port) {
		$this->SocketHandler = $this->SocketHandlerClass->Create( $domain, $type, $protocol );
		
		if ( !$this->SocketHandler ) {
			$this->connectedStatus = false;
		}
		
		$result = $this->SocketHandlerClass->Connect( $this->SocketHandler, $address, $port );
		if ( !$result ) {
			$this->connectedStatus = false;
		}
	}

	public function isConnected () :bool {
		return $this->connectedStatus;
	}
}