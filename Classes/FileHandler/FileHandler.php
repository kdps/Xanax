<?php

namespace Xanax\Classes;

use Xanax\Interface\FileHandlerInterface;

use Xanax\Exception\Stupid\StupidIdeaException;
use Xanax\Exception\FileHandler\FileIsNotExistsException;

use Xanax\Validation\FileValidation;

use Xanax\Message\FileHandlerMessage;

class FileHandler implements FileHandlerInterface {
	
	public function __construct () {
		
	}
	
	public function getSize ( string $filePath ) :int {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUsePharProtocolMessage() );
		}
		
		$return = filesize( $filePath );
		
		return $return >= 0 ? $return : -1;
	}
	
	public function copy ( string $filePath, string $destinationPath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		$return = copy ( $source, $dest );
		
		return $return;
	}
	
	public function appendFileContent( string $filePath, string $content ) :void {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		$fileHandler = fopen( $filePath, 'a' );
		fwrite($fileHandler, $content);
		fclose($fileHandler);
	}
	
	public function getLastModifiedTime ( string $filePath ) :string {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		$return = fileatime($filePath);
		
		return $return;
	}
	
	public function getType ( string $filePath ) :string {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUsePharProtocolMessage() );
		}
		
		$return = filetype( $filePath );
		
		return $return;
	}
	
	public function getExtention ( string $filePath ) :string {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		$return = pathinfo($filePath, PATHINFO_EXTENSION);
		
		return $return;
	}
	
	public function getContent( string $filePath ) :string {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		$fileHandler = fopen( $filePath, 'r' );
		$fileSize = $this->getSize( $filePath );
		$return = fread( $fileHandler, $fileSize );
		fclose( $fileHandler );
		
		return $return;
	}
	
	public function Download ( string $filePath ) :void {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		$fileHandler = @fopen($filePath, 'rb');
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
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		ob_start();
			
		if (isset( $filePath )) {
			if ( file_exists( $filePath ) ) {
				@include( $filePath );
			} else {
				throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
			}
		}
		
		$return = ob_get_clean();
		
		return $return;
	}
	
	public function isFile ( string $filePath ) :bool {
		if ( Xanax\Validation\FileValidation->isReadable( $filePath ) ) {
			
		}
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUsePharProtocolMessage() );
		}
		
		$return = is_file ( $filePath );
		
		return $return;
	}
	
	public function requireOnce( string $filePath ) :void {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUsePharProtocolMessage() );
		}
		
        require_once $filePath;
	}
	
	public function Move ( string $source, string $destination ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $source ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $source ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $destination ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		$return = rename( $source, $destination );
		
		return $return;
	}
	
	public function isEmpty ( string $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	public function isExists ( string $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->hasSubfolderSyntax( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUseSubDirectorySyntaxMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUsePharProtocolMessage() );
		}
		
		$return = file_exists( $filePath );
		
		return $return;
	}
	
}