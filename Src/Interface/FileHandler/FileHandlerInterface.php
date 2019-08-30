<?php

namespace Xanax\Implement;

interface FileHandlerInterface {
	
	public function getSize ( string $filePath ) : int;
	
	public function copy ( string $filePath, string $destinationPath ) :bool;
	
	public function appendFileContent( string $filePath, string $content ) :bool;
	
	public function getLastModifiedTime ( string $filePath ) :string;
	
	public function getType ( string $filePath ) :string;
	
	public function getExtention ( string $filePath ) :string;
	
	public function getContent( string $filePath ) :string;
	
	public function Download ( string $filePath ) :bool;
	
	public function getInterpretedContent ( string $filePath ) :string;
	
	public function isFile ( string $filePath ) :bool;
	
	public function requireOnce ( string $filePath );
	
	public function Move ( string $source, string $destination ) :bool;
	
	public function isEmpty ( string $filePath ) :bool;
	
	public function isExists ( string $filePath ) :bool;
	
}