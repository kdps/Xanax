<?php

namespace Xanax\Classes;

class SocketHandler {
	
	/*
	 *
	 * Domain = [AF_INET, AF_INET6, AF_UNIX]
	 * Type = [SOCK_STREAM, SOCK_DGRAM, SOCK_SEQPACKET, SOCK_RAW, SOCK_RDM]
	 * Protocol = [SOL_TCP, SOL_UDP]
	 *
	 */
	public function Create ( $domain = AF_INET, $type = SOCK_STREAM, $protocol = SOL_TCP) :resource {
		return socket_create( $domain, $type, $protocol );
	}
	
	public function getPeerName ( $socketHandler, $address, $port ) {
		socket_getpeername ( $socketHandler, $address, $port );
	}
	
	public function Close ( $socketHandler ) :void {
		socket_close ( $socketHandler );
	}
	
	public function Listen ( $socketHandler ) :bool {
		socket_listen ( $socketHandler );
	}
	
	public function Bind ( $socketHandler, $address, $port ) :bool {
		socket_bind ( $socketHandler, $address, $port );
	}
	
	public function readPacket ( $socketHandler, $length, $type = PHP_BINARY_READ ) :string {
		socket_read( $socketHandler, $length, $type );
	}
	
	public function writeSocket ( $socketHandler, $buffer, $length ) :int {
		return socket_write( $socketHandler, $buffer, $length );
	}
	
	public function Connect ( $socketHandler, $address, $port ) :bool {
		return socket_connect( $socketHandler, $address, $port );
	}
	
	public function getLastErrorMessage () {
		return socket_strerror(socket_last_error());
	}
	
}