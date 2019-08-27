<?php

namespace Xanax\Interface;

interface FileHandlerInterface {
	
	public function getSize ( $filePath );
	
	public function copy ( $filePath, $destinationPath );
	
	public function appendFileContent( $filePath, $content );
	
	public function getLastModifiedTime ( $filePath );
	
	public function getType ( $filePath );
	
	public function getExtention ( $filePath );
	
	public function getContent( $filePath );
	
	public function Download ( $filePath );
	
	public function getInterpretedContent ( $filePath );
	
	public function isFile ( $filePath );
	
	public function requireOnce( $filePath );
	
	public function Move ( $source, $destination );
	
	public function isEmpty ( $filePath );
	
	public function isExists ( $filePath );
	
}