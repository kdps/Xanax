<?php

declare(strict_types = 1);

namespace Xanax\Classes;

use Xanax\Classes\SocketHandler as SocketHandler;

class SocketClientObject {
	
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
		
		return true;
	}
	
	public function Close () {
		$this->SocketHandlerClass->Close();
	}
	
	public function Connect( $address, $port, $domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP) :bool {
		$this->SocketHandler = $this->SocketHandlerClass->Create( $domain, $type, $protocol );
		
		if ( !$this->SocketHandler ) {
			return false;
		}
		
		$result = $this->SocketHandlerClass->Connect( $this->SocketHandler, $address, $port );
		if ( !$result ) {
			return false;
		}
		
		return true;
	}

}