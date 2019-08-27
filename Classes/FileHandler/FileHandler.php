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
	
	public function getSize ( $filePath ) :int {
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
	
	public function copy ( $filePath, $destinationPath ) {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		$return = copy ( $source, $dest );
		
		return $return;
	}
	
	public function appendFileContent( $filePath, $content ) :void {
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
	
	public function getLastModifiedTime ( $filePath ) :string {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		$return = fileatime($filePath);
		
		return $return;
	}
	
	public function getType ( $filePath ) :string {
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
	
	public function getExtention ( $filePath ) :string {
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
	
	public function getContent( $filePath ) :string {
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
	
	public function Download ( $filePath ) :void {
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
	
	public function getInterpretedContent ( $filePath ) :string {
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
	
	public function isFile ( $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( Xanax\Validation\FileValidation->isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( Xanax\Message\FileHandlerMessage->getDoNotUsePharProtocolMessage() );
		}
		
		$return = is_file ( $filePath );
		
		return $return;
	}
	
	public function requireOnce( $filePath ) :void {
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
	
	public function Move ( $source, $destination ) :bool {
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
	
	public function isEmpty ( $filePath ) :bool {
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( Xanax\Message\FileHandlerMessage->getFileIsNotExistsMessage() );
		}
		
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	public function isExists ( $filePath ) :bool {
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