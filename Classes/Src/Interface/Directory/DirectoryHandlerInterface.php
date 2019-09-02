<?php

namespace Xanax\Implement;

interface DirectoryHandlerInterface {
	
	public function getFreeSpace ( $prefix = "/" );
	
	public function RenameInnerFiles ( string $directoryPath, $replacement, $string = null );
	
	public function hasCurrentWorkingLocation ();
	
	public function getCurrentWorkingLocation ();
	
	public function isDirectory ( string $directoryPath );
	
	public function Make ( string $directoryPath );
	
	public function Create ( string $directoryPath );
	
	public function getFileCount ( string $directoryPath );
	
	public function isEmpty ( string $directoryPath );
	
	public function Delete ( string $directoryPath );
	
	public function Copy ( string $directoryPath, string $copyPath );
	
	public function getMaxDepth ();
	
	public function setMaxDepth ( int $depth );
	
	public function Empty ( string $directoryPath );
	
	public function getSize ( string $directoryPath );
	
}