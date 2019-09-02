<?php

namespace Xanax\Classes;

use Xanax\Classes\Encode as Encode;
use Xanax\Classes\FileObject as FileObject;
use Xanax\Classes\FileSystemHandler as FileSystemHandler;
use Xanax\Classes\DirectoryHandler as DirectoryHandler;
use Xanax\Exception\Stupid\StupidIdeaException;
use Xanax\Exception\FileHandler\FileIsNotExistsException;
use Xanax\Exception\FileHandler\TargetIsNotFileException;
use Xanax\Implement\FileSystemInterface as FileSystemInterface;
use Xanax\Implement\FileHandlerInterface as FileHandlerInterface;
use Xanax\Implement\DirectoryHandlerInterface as DirectoryHandlerInterface;
use Xanax\Validation\FileValidation as FileValidation;
use Xanax\Message\FileHandler\FileHandlerMessage as FileHandlerMessage;

class FileHandler implements FileHandlerInterface {
	
	private static $lastError;
	private $strictMode = true;
	private $fileSystemHandler;
	private $directoryHandler;
	
	public function __construct ( $useStrictMode = true, FileHandlerInterface $fileSystemHandler = null, FileHandlerInterface $directoryHandler = null  ) {
		$this->strictMode = $useStrictMode;
		$this->fileSystemHandler = $fileSystemHandler;// || new FileSystemHandler();
		$this->directoryHandler = $directoryHandler;// || new DirectoryHandler();
	}
	
	public function isValidHandler ( $fileHandler ) {
		if ( getType($fileHandler) !== "resource" ) {
			return false;
		}
		
		if ( get_resource_type ( $fileHandler) !== "stream" ) {
			return false;
		}
		
		return true;
	}
	
	public function createCache ( string $filePath, string $destination ) {
		$cached = fopen($filePath, 'w');
		fwrite($destination, ob_get_contents());
		fclose($destination);
		ob_end_flush();
	}
	
	/**
	 * Gets whether the file can be read.
	 *
	 * @param string $filePath    : Path of the file to check
	 *
	 * @return bool
	 */
	public function isReadable ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = is_readable ($filePath);
		
		return $return;
	}
	
	public function parseINI ( $filePath ) {
		return parse_ini_file( $filePath );
	}
	
	public function getMIMEType ( $filePath ) {
		return mime_content_type ( $filePath );
	}
	
	/**
	 * Gets whether the file is locked.
	 *
	 * @param string $filePath    : Path of the file to check
	 *
	 * @return bool
	 */
	public function isLocked ( $filePath ) :bool {
		if ( $this->strictMode && !$this->isValidHandler( $filePath ) && !$this->isFile( $filePath ) ) {
			return false;
		}
		
		if ( !$this->isValidHandler($filePath) ) {
			$filePath = fopen($filePath, "r+");
		}
		
		if ( !flock($filePath, LOCK_EX) ) {
			return true;
		}
		
		return false;
	}
	
	public function isEmpty ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	public function isExists ( string $filePath ) :bool {
		$return = file_exists( $filePath );
		
		return $return;
	}
	
	public function isUnknownFile ( string $filePath ) :bool {
		if ( $this->getType ( $filePath ) === "unknown" ) {
			return true;
		}
		
		return false;
	}

	public function getSymbolicLink ( string $symbolicLink ) {
		if ( !$this->isSymbolicLink( $symbolicLink ) ) {
		}
		
		$return = readlink( $symbolicLink );
		
		return $return;
	}

	public function isSymbolicLink ( string $filePath ) :bool {
		if ( is_link( $filePath ) && $this->getType ( $filePath ) === "link" ) {
			return true;
		}
		
		return false;
	}
	
	public function isRegularFile ( string $filePath ) :bool {
		if ( $this->getType ( $filePath ) === "file" ) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Make sure the file location exists under a specific folder.
	 *
	 * @param string $basePath : Lowest folder location
	 * @param string $filePath : File path
	 *
	 * @return bool
	 */
	public function isContainFolder ( string $basePath, string $filePath ) :bool {
		$realBasePath = realpath( $basePath );
		$realFilePath = realpath( dirname ($filePath ) );
		
		if ( $realFilePath === false || strncmp($realFilePath, $realBasePath, strlen($realBasePath)) !== 0 ) {
			return false;
		}
		
		return true;
	}
	
	public function isFile ( string $filePath, array $containDirectory = null ) :bool {
		if ( FileValidation::isReadable( $filePath ) ) {
			
		}
		
		if ( FileValidation::hasSubfolderSyntax( $filePath ) ) {
			if ( $targetDirectory === null ) {
				throw new StupidIdeaException ( FileHandlerMessage::getDoNotUseSubDirectorySyntaxMessage() );
			} else if ( !$this->isContainFolder( $containDirectory, $filePath ) ) {
				return false;
			}
		}
		
		if ( FileValidation::isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( FileHandlerMessage::getDoNotUsePharProtocolMessage() );
		}
		
		$return = is_file ( $filePath );
		
		return $return;
	}
	
	public function isEqualByLine (  string $filePath, string $string = null ) :bool {
		$fileObject = new FileObject( $filePath, false, "r" );
		$fileObject->startHandle();
		$bool = $fileObject->isEqualByLine( $string );
		$fileObject->closeFileHandle();
		
		return $bool;
	}
	
	public function isExecutable () {
		if ( !$this->isFile( $filePath ) ) {
			return false;
		}
		
		$return = is_executable ( $filePath );
		
		return $return;
	}
	
	/**
	 * Gets whether the file can be written to.
	 *
	 * @param string $filePath    : Path of the file to check
	 *
	 * @return bool
	 */
	public function isWritable ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			return true;
		}
		
		$return = is_writable ( $filePath );
		
		return $return;
	}
	
	/**
	 * Delete the file.
	 *
	 * @param string $filePath    : Path of the file to delete
	 *
	 * @return bool
	 */
	public function Delete ( string $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		unlink($filePath);
		
		return true;
	}
	
	/**
	 * Check the size of the file.
	 *
	 * @param string $filePath    : Path of the file to get size
	 *
	 * @return int
	 */
	public function getSize ( string $filePath, bool $humanReadable ) :int {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( $humanReadable ) {
			clearstatcache();
			
			if (file_exists($file)) {
				$bytes = filesize($file);
			} else {
				$bytes = $file;
			}
			
			$bytes = 0;
			
			if ($bytes > 0) {
				$sizes = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
				$factor = $bytes > (1024 ** 6) ? floor((strlen($bytes) - 1) / 3) : (strlen($bytes >> 10) > 1 ? ((strlen($bytes >> 10) - 1) / 3) + 1 : 1);
				$capacity = $bytes / pow(1024, $factor);
				return sprintf("%s%s%s", $capacity, $sizes[$factor], ($capacity !== intval($capacity) ? "ytes" : ""));
			}
			
			return $bytes;
		}
		
		$return = filesize( $filePath );
		
		return $return >= 0 ? $return : -1;
	}
	
	/**
	 * Copy the file.
	 *
	 * @param string $filePath    : Path of the file to copy
	 * @param string $destination : Path to which copied files are to be saved
	 *
	 * @return bool
	 */
	public function Copy ( string $filePath, string $destination ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = copy ( $filePath, $destination );
		
		return $return;
	}

	public function Merge ( string $filePath, string $mergeFile ) :bool {
		$fileObject = new FileObject( $filePath, false, "a" );
		$fileObject->startHandle();
		
		$fileObject->appendContent( $mergeFile );
		
		$fileObject->closeFileHandle();
		
		return true;
	}
	
	/**
	 * Read the file.
	 *
	 * @param string $filePath  : Path of the file
	 * @param int    $length    : Read length
	 * @param int    $writeMode : Mode of file handler
	 *
	 * @return bool
	 */
	public function Read ( string $filePath, int $length = -1, string $mode = 'r' ) {
		$fileObject = new FileObject( $filePath, false, $mode );
		if ( !$fileObject->isEnoughFreeSpace() ) {
			$this::$lastError = "Disk space is not enough";
			return false;
		}
		
		$fileObject->startHandle();
		
		if ( !$fileObject->successToStartHandle() ) {
			return false;
		}
		
		if ( !$fileObject->hasReadedContent() ) {
			return "";
		}
		
		if ( $length === -1 ) {
			$fileObject->readAllContent ();
		} else {
			$fileObject->readContent ( $length );
		}
		
		$content = $fileObject->getReadedContent();
		
		$fileObject->closeFileHandle();
		
		return $content;
	}
	
	public function readAllContent ( string $filePath, string $writeMode = 'r' ) {
		return $this->Read( $filePath, -1 );
	}
	
	/**
	 * Create a file.
	 *
	 * @param string $filePath   : Path of the file to create
	 * @param string $content    : File contents
	 * @param string $writeMode  : File creation mode
	 *
	 * @return bool
	 */
	public function Write ( string $filePath, string $content = null, string $writeMode = 'w' ) :bool {
		$fileObject = new FileObject( $filePath, true, $writeMode );
		$fileObject->startHandle();
		
		if ( !$fileObject->successToStartHandle() ) {
			return false;
		}
		
		$fileObject->writeContent( $content );
		
		if ( !$fileObject->successToWriteContent() ) {
			return false;
		}
		
		$fileObject->closeFileHandle();
		
		return true;
	}
	
	/**
	 * Append the contents to the file.
	 *
	 * @param string $filePath    : Path of the file to append contents
	 * @param string $content     : File contents
	 * @param bool   $makeNewFile : If the file does not exist, create a new file.
	 *
	 * @return bool
	 */
	public function appendFileContent( string $filePath, string $content = null, bool $makeNewFile = true ) :bool {
		if ( !$this->isFile( $filePath ) && !$makeNewFile ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) && $makeNewFile ) {
			$this->Write($filePath, "", 'w');
		}

		$this->Write($filePath, $content, 'a');
		
		return true;
	}
	
	/**
	 * Bring the last modified time.
	 *
	 * @param string $filePath    : Path of the file to check
	 *
	 * @return string
	 */
	public function getLastModifiedTime ( string $filePath ) :string {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = fileatime($filePath);
		
		return $return;
	}
	
	/**
	 * Get the file type.
	 *
	 * @param string $filePath    : Path of the file to check
	 *
	 * @return string
	 */
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
	
	/**
	 * Write the contents of the file backwards.
	 *
	 * @param string $filePath    : Path of the file to write
	 *
	 * @return bool
	 */
	public function reverseContent ( string $filePath ) :bool {
		$fileLines = file( $filePath );
		$invertedLines = strrev ( array_shift( $fileLines ) );
		return $this->Write( $filePath, $invertedLines, 'w' );
	}
	
	public function getBasename ( string $fileName, $extension = null ) :string {
		return basename($fileName, $extension).PHP_EOL;
	}
	
	public function getExtention ( string $filePath ) :string {
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
	
	public function isCorrectInode ( $filePath ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( $this->fileSystemHandler->getCurrentInode() === $this->getInode( $filePath ) ) {
			return true;
		}
		
		return false;
	}
	
	public function getInode ( string $filePath ) {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		return $this->fileSystemHandler->getInodeNumber( $filePath );
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
	
}
