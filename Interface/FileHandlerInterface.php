<?php

namespace Xanax\Interface;

interface DirectoryHandlerInterface {
	
	public function isDirectory ( $directoryPath );
	
	public function Make ( $directoryPath );
	
	public function Create ( $directoryPath );
	
	public function isEmpty ( $directoryPath );
	
	public function Delete ( $directoryPath );
	
	public function Copy ( $directoryPath, $copyPath );
	
	public function Empty ( $directoryPath );
	
}