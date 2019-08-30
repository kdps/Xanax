<?php

namespace Xanax\Classes;

use Xanax\Exception\Stupid\StupidIdeaException;
use Xanax\Exception\FileHandler\FileIsNotExistsException;
use Xanax\Exception\FileHandler\TargetIsNotFileException;

use Xanax\Validation\FileValidation;

use Xanax\Message\FileHandler\FileHandlerMessage;

class FileHandler implements \Xanax\Implement\FileHandlerInterface {
	
	public function __construct () {
		
	}
	
	public function getSize ( string $filePath ) :int {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = filesize( $filePath );
		
		return $return >= 0 ? $return : -1;
	}
	
	public function copy ( string $filePath, string $destinationPath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = copy ( $source, $dest );
		
		return $return;
	}
	
	public function Write ( $filePath, $content, $mode = 'w' ) {
		$fileHandler = fopen($filePath, 'w');
		if ( $fileHandler == false ) {
			return false;
		}
		
		$fwrite = fwrite($fileHandler, $content);
		if ( $fwrite === false ) {
			return false;
		}
		
		fclose($fileHandler);
	}
	
	public function appendFileContent( string $filePath, string $content, bool $makeNewFile = false ) :bool {
		if ( !$this->isFile( $filePath ) && !$makeNewFile ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( $makeNewFile ) {
			
		}

		$this->Write($filePath, $content, 'a');
		
		return true;
	}
	
	public function getLastModifiedTime ( string $filePath ) :string {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = fileatime($filePath);
		
		return $return;
	}
	
	public function getType ( string $filePath ) :string {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( FileValidation::isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( FileHandlerMessage::getDoNotUsePharProtocolMessage() );
		}
		
		$return = filetype( $filePath );
		
		return $return;
	}
	
	public function getExtention ( string $filePath ) :string {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = pathinfo($filePath, PATHINFO_EXTENSION);
		
		return $return;
	}
	
	public function getContent( string $filePath ) :string {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$fileHandler = fopen( $filePath, 'r' );
		$fileSize = $this->getSize( $filePath );
		$return = fread( $fileHandler, $fileSize );
		fclose( $fileHandler );
		
		return $return;
	}
	
	public function Download ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$fileHandler = @fopen($filePath, 'rb');
		if ($fileHandler === false) {
			return false;
		}
		
		if ($fileHandler) {
			while(!feof($fileHandler)) {
				print(@fread($fileHandler, 1024 * 8));
				ob_flush();
				flush();
			}
		}
		
		fclose($file);
	}
	
	public function getInterpretedContent ( string $filePath ) :string {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		ob_start();
			
		if (isset( $filePath )) {
			if ( file_exists( $filePath ) ) {
				@include( $filePath );
			} else {
				throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
			}
		}
		
		$return = ob_get_clean();
		
		return $return;
	}
	
	public function isFile ( string $filePath ) :bool {
		if ( FileValidation::isReadable( $filePath ) ) {
			
		}
		
		if ( FileValidation::hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( FileHandlerMessage::getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		if ( FileValidation::isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( FileHandlerMessage::getDoNotUsePharProtocolMessage() );
		}
		
		$return = is_file ( $filePath );
		
		return $return;
	}
	
	public function requireOnce( string $filePath ) :void {
		if ( !$this->isFile( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		require_once $filePath;
	}
	
	public function Move ( string $source, string $destination ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $source ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = rename( $source, $destination );
		
		return $return;
	}
	
	public function isEmpty ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	public function isExists ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = file_exists( $filePath );
		
		return $return;
	}
	
}
