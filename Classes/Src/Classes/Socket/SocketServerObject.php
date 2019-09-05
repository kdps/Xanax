<?php

namespace Xanax\Classes;

use Xanax\Classes\SocketHandler as SocketHandler;

class SocketServerObject {
	
	private $multipleAcceptedSocketCount = 0;
	private $multipleAcceptedSocket;
	private $multipleClientSocket = array();
	private $clientBindHandler;
	private $SocketHandlerClass;
	private $SocketHandler;
	
	public function __construct( $socketHandler ) {
		$this->SocketHandlerClass = $socketHandler;
	}
	
	public function getAcceptedMultipleClient () {
		return $this->multipleAcceptedSocketCount;
	}
	
	public function hasAcceptedMultipleClient () {
		if ( $this->getAcceptedMultipleClient() > 0 ) {
			return true;
		}
		
		return false;
	}
	
	public function selectArrayClient ( $timeout = 10, $write = null, $except = null ) :void {
		$this->multipleAcceptedSocketCount = $this->SocketHandlerClass->Select( $this->multipleAcceptedSocket, $timeout, $write, $except );
	}
	
	public function setArrayClient () {
		$this->multipleAcceptedSocket = array_merge(array( $this->SocketHandler ), $this->multipleClientSocket );
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