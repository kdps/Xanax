<?php

namespace Xanax\Classes;

use Xanax\Classes\SocketHandler as SocketHandler;

class SocketSingleServerObject {
	
	private $clientBindHandler;
	private $SocketHandlerClass;
	private $SocketHandler;
	
	public function __construct( $socketHandler ) {
		$this->SocketHandlerClass = $socketHandler;
	}
	
	public function Close () {
		$this->SocketHandlerClass->Close();
	}
	
	public function Connect( $address, $port, $domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP) {
		$this->SocketHandler = $this->SocketHandlerClass->Create( $domain, $type, $protocol );
		
		if ( !$this->SocketHandler ) {
			return false;
		}
		
		$result = $this->SocketHandlerClass->Bind( $this->SocketHandler, $address, $port );
		if ( !$result ) {
			return false;
		}
		
		$result = $this->SocketHandlerClass->Listen( $this->SocketHandler );
		if ( !$result ) {
			return false;
		}
		
		return true;
	}
	
	public function AcceptClient () {
		$bind = $this->SocketHandlerClass->AcceptConnect ( $this->SocketHandler );
		
		if ( $bind ) {
			$this->clientBindHandler = $bind;
			
			return true;
		}
		
		return false;
	}
	
}

?>