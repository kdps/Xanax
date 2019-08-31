<?php

namespace Xanax\Implement;

interface FileHandlerInterface {
	
	public function isValidHandler ( $fileHandler );
	
	public function isReadable ( $filePath ) :bool;
	
	public function isLocked ( $filePath ) :bool;
	
	public function isRegularFile ( string $filePath ) :bool;
	
	public function isSymbolicLink ( string $filePath ) :bool;
	
	public function isUnknownFile ( string $filePath ) :bool;
	
	public function isEqual (  string $filePath, string $string = null ) :bool;
	
	public function isWritable ( string $filePath ) :bool;
	
	public function Delete ( string $filePath ) :bool;
	
	public function getSize ( string $filePath ) : int;
	
	public function copy ( string $filePath, string $destinationPath ) :bool;
	
	public function appendFileContent( string $filePath, string $content = null, bool $makeNewFile = true ) :bool;
	
	public function Write ( string $filePath, string $content = null, string $writeMode = 'w' ) :bool;
	
	public function Read ( string $filePath, int $length = -1, string $writeMode = 'r' );
	
	public function readAllContent ( string $filePath, string $writeMode = 'r' );
	
	public function getLastModifiedTime ( string $filePath ) :string;
	
	public function getType ( string $filePath ) :string;
	
	public function getExtention ( string $filePath ) :string;
	
	public function getBasename ( $fileName, $extension = null ) :string;
	
	public function reverseContent ( string $filePath ) :bool;
	
	public function getContent( string $filePath ) :string;
	
	public function Download ( string $filePath ) :bool;
	
	public function getInterpretedContent ( string $filePath ) :string;
	
	public function isFile ( string $filePath ) :bool;
	
	public function requireOnce ( string $filePath );
	
	public function Move ( string $source, string $destination ) :bool;
	
	public function isEmpty ( string $filePath ) :bool;
	
	public function isExists ( string $filePath ) :bool;
	
}