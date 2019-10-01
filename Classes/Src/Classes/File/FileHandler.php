<?php

declare(strict_types = 1);

namespace Xanax\Classes;

use Xanax\Classes\Encode as Encode;
use Xanax\Classes\FileObject as FileObject;
use Xanax\Classes\FileSystemHandler as FileSystemHandler;
use Xanax\Classes\DirectoryHandler as DirectoryHandler;
use Xanax\Exception\Stupid\StupidIdeaException as StupidIdeaException;
use Xanax\Exception\FileHandler\FileIsNotExistsException as FileIsNotExistsException;
use Xanax\Exception\FileHandler\TargetIsNotFileException as TargetIsNotFileException;
use Xanax\Exception\FileHandler\InvalidFileHandler as InvalidFileHandler;
use Xanax\Implement\FileSystemInterface as FileSystemInterface;
use Xanax\Implement\FileHandlerInterface as FileHandlerInterface;
use Xanax\Implement\DirectoryHandlerInterface as DirectoryHandlerInterface;
use Xanax\Validation\FileValidation as FileValidation;
use Xanax\Message\FileHandler\FileHandlerMessage as FileHandlerMessage;

class FileHandler implements FileHandlerInterface {
	
	protected $useStatFunction = ["stat", "lstat", "file_exists", "is_writable", "is_readable", "is_executable", "is_file", "is_dir", "is_link", "filectime", "fileatime", "filemtime", "fileinode", "filegroup", "fileowner", "filesize", "filetype", "fileperms"];

	private static $lastError;
	private $strictMode = true;
	private $fileSystemHandler;
	private $directoryHandler;
	
	public function __construct ( $useStrictMode = true, FileHandlerInterface $fileSystemHandler = null, DirectoryHandlerInterface $directoryHandler = null  ) {
		$this->strictMode = $useStrictMode;
		
		if ( $fileSystemHandler ) {
			$this->fileSystemHandler = $fileSystemHandler;
		} else {
			$this->fileSystemHandler = new FileSystemHandler();
		}
		
		if ( $directoryHandler ) {
			$this->directoryHandler = $directoryHandler;
		} else {
			$this->directoryHandler = new DirectoryHandler( $this );
		}
	}
	
	/**
	 * Delete the state of the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function clearStatatusCache ( $filePath ) :void {
		clearstatcache(true, $filePath);
	}
	
	/**
	 * Delete the last directory separator.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	protected function convertToNomalizePath ( $filePath ) {
		return rtrim($filePath, DIRECTORY_SEPARATOR); // Remove last Directory separator
	}
	
	/**
	 * Make sure the file handler is of type resource.
	 *
	 * @param string $fileHandler
	 *
	 * @return bool
	 */
	public function isValidHandler ( $fileHandler ) {
		if ( getType($fileHandler) !== "resource" ) {
			return false;
		}
		
		if ( get_resource_type ( $fileHandler) !== "stream" ) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Gets the current file pointer position.
	 *
	 * @param string $fileHandler
	 *
	 * @return bool
	 */
	public function getPointerLocation ( $fileHandler ) {
		if ( !$this->isValidHandler( $fileHandler ) ) {
			throw new InvalidFileHandler ( FileHandlerMessage::getInvalidFileHandler() );
		}
		
		return ftell( $fileHandler );
	}
	
	public function createCache ( string $filePath, string $destination ) {
		$filePath = $this->convertToNomalizePath( $filePath );
		$destination = $this->convertToNomalizePath($destination);
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			return false;
		}
		
		$cached = fopen($filePath, 'w');
		fwrite($destination, ob_get_contents());
		fclose($destination);
		ob_end_flush();
	}
	
	/**
	 * Gets whether the file can be read.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isReadable ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = is_readable ($filePath);
		
		return $return;
	}
	
	/**
	 * Interpret the INI file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function parseINI ( $filePath ) {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		return parse_ini_file( $filePath );
	}
	
	/**
	 * Gets the MIME of the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function getMIMEType ( $filePath ) {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		return mime_content_type ( $filePath );
	}
	
	/**
	 * Gets whether the file is locked.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isLocked ( $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			return false;
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
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
	
	public function getLine ( string $fileHandler, int $length) :string {
		if ( !$this->isValidHandler( $fileHandler ) ) {
			throw new InvalidFileHandler ( FileHandlerMessage::getInvalidFileHandler() );
		}
		
		fgets ( $fileHandler, $length );
	}
	
	public function getCharacter ( string $fileHandler, int $length) :string {
		if ( !$this->isValidHandler( $fileHandler ) ) {
			throw new InvalidFileHandler ( FileHandlerMessage::getInvalidFileHandler() );
		}
		
		fgetc ( $fileHandler, $length );
	}
	
	public function getPermissions ( $filePath ) :int {
		return fileperms( $filePath );
	}
	
	public function getOwnser ( $filePath ) :int {
		return fileowner( $filePath );
	}
	
	public function createTemporary () :resource {
		return tmpfile();
	}
	
	public function createUniqueTemporary ( $directory, $prefix ) {
		return $tmpfname = tempnam( $directory, $prefix );
	}
	
	public function setAccessAndModificatinTime ( $filePath, $time, $atime ) {
		touch( $filePath, $time, $atime );
	}
	
	/**
	 * Unlock the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function Unlock ( $fileHandler) {
		if ( !$this->isValidHandler( $fileHandler ) ) {
			throw new InvalidFileHandler ( FileHandlerMessage::getInvalidFileHandler() );
		}
		
		flock($fileHandler, LOCK_UN); // Unlock file handler
	}
	
	/**
	 * Change mode of file
	 *
	 * @param string $filePath
	 * @param int    $mode
	 *
	 * @return bool
	 */
	public function changeMode ( string $filePath, int $mode ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		return chmod( $filePath, $mode ) ? true : false;
	}
	
	/**
	 * Change group of file
	 *
	 * @param string $filePath
	 * @param int    $mode
	 *
	 * @return bool
	 */
	public function changeGroup ( string $filePath, string $group ) :bool {
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		return chgrp( $filePath, $group );
	}
	
	/**
	 * Lock the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function Lock ( $fileHandler, $mode = 'r'  ) {
		if ( !$this->isValidHandler( $fileHandler ) ) {
			throw new InvalidFileHandler ( FileHandlerMessage::getInvalidFileHandler() );
		}
		
		$mode = strtolower($mode);

		switch ( $mode ) {
			case 'r':
				flock($fileHandler, LOCK_SH); // Lock of read mode
				break;
			case 'w':
				flock($fileHandler, LOCK_EX); // Lock of write mode
				break;
		}
	}
	
	/**
	 * Check if the file empty.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isEmpty ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = $this->Size( $filePath ) !== 0;
		
		return $return;
	}
	
	/**
	 * Check if the file exists.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isExists ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$return = file_exists( $filePath );
		
		return $return;
	}
	
	public function isUnknownFile ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( $this->getType ( $filePath ) === "unknown" ) {
			return true;
		}
		
		return false;
	}

	/**
	 * Gets the symbolic link
	 *
	 * @param string $symbolicLink
	 *
	 * @return bool
	 */
	public function getSymbolicLink ( string $symbolicLink ) {
		if ( !$this->isSymbolicLink( $symbolicLink ) ) {
		}
		
		$return = readlink( $symbolicLink );
		
		return $return;
	}

	public function isSymbolicLink ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( is_link( $filePath ) && $this->getType ( $filePath ) === "link" ) {
			return true;
		}
		
		return false;
	}
	
	public function isRegularFile ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( $this->getType ( $filePath ) === "file" ) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Make sure the file location exists under a specific folder.
	 *
	 * @param string $basePath
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isContainFolder ( string $basePath, string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$realBasePath = realpath( $basePath );
		$realFilePath = realpath( dirname ($filePath ) );
		
		if ( $realFilePath === false || strncmp($realFilePath, $realBasePath, strlen($realBasePath)) !== 0 ) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Check that the file is correct.
	 *
	 * @param string $filePath
	 * @param array $containDirectory
	 *
	 * @return bool
	 */
	public function isFile ( string $filePath, string $containDirectory = null ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
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
	
	/**
	 * Checks for a match on a line in the file.
	 *
	 * @param string $filePath
	 * @param string $string
	 *
	 * @return bool
	 */
	public function isEqualByLine (  string $filePath, string $string = null ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$fileObject = new FileObject( $filePath, false, "r" );
		$fileObject->startHandle();
		$bool = $fileObject->isEqualByLine( $string );
		$fileObject->closeFileHandle();
		
		return $bool;
	}
	
	/**
	 * Make sure the file is executable on your system.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isExecutable ( $filePath ) {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			return false;
		}
		
		$this->clearStatatusCache( $filePath );
		$return = is_executable ( $filePath );
		
		return $return;
	}
	
	/**
	 * Gets whether the file can be written to.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isWritable ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			return true;
		}
		
		if ( !$this->isFile( $filePath ) ) {
			return true;
		}
		
		$this->clearStatatusCache( $filePath );
		$return = is_writable ( $filePath );
		
		return $return;
	}
	
	/**
	 * Delete the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function Delete ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		unlink($filePath);
		
		return true;
	}
	
	/**
	 * Check the size of the file.
	 *
	 * @param string $filePath
	 *
	 * @return int
	 */
	public function getSize ( string $filePath, bool $humanReadable = false ) :int {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( $humanReadable ) {
			$this->clearStatatusCache( $filePath );
			
			if ( file_exists($file) ) {
				$bytes = filesize($file);
			} else {
				$bytes = $file;
			}
			
			$bytes = 0;
			
			if ($bytes > 0) {
				$sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
				$measure = strlen($bytes >> 10);
				$factor = $bytes < (1024 ** 6) ? ($measure > 1 ? floor((($measure - 1) / 3) + 1) : 1) : floor((strlen($bytes) - 1) / 3);
				$capacity = $bytes / pow(1024, $factor);
				$multiBytesPrefix = ($capacity === intval($capacity) ?: "ytes");
				$bytes = sprintf("%s%s%s", $capacity, $sizes[$factor], $multiBytesPrefix);
			}
			
			return $bytes;
		}
		
		$this->clearStatatusCache( $filePath );
		$return = filesize( $filePath );
		
		return $return >= 0 ? $return : -1;
	}
	
	/**
	 * Copy the file.
	 *
	 * @param string $filePath
	 * @param string $destination
	 *
	 * @return bool
	 */
	public function Copy ( string $filePath, string $destination ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$return = copy ( $filePath, $destination );
		
		return $return;
	}

	/**
	 * Combine the two files.
	 *
	 * @param string $filePath
	 * @param string $mergeFile
	 *
	 * @return bool
	 */
	public function Merge ( string $filePath, string $mergeFile ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$fileObject = new FileObject( $filePath, false, "a" );
		$fileObject->startHandle();
		
		$fileObject->appendContent( $mergeFile );
		
		$fileObject->closeFileHandle();
		
		return true;
	}
	
	public function changeUmask ( $mask ) :int {
		return umask( $mask );
	}
	
	public function getTypeByHeader ( string $filePath ) :string {
		$fsize = filesize($filePath) < 100 ? filesize($filePath) : 100;
		if ($fsize <= 4) {
			return "EMPTY";
		}
		
		$header = $this->Read( $filePath, $fsize );
		
		/* ISO 8859-1 */
		$fileDescription = array_shift(unpack("N", $header));
		
		$mp3FileHeader = array(
			/* ftyp3gp4isom3gp4 */
			"24",
			
			/* !DO (p Hq) */
			"1008813135",
			
			"1298231840",
			
			/* ID3 (TSSE) */
			"1229206276",
			/* ID3 (GEOB, TYER, TALB, TSSE, TXXX, TPE1, TIT2, TCON, PRIV, TRCK) */
			"1229206275",
			/* ID3 (TALB, TIT2, TSS, TT2, FTT2, TPE1) */
			"1229206274", 
			
			"1213486160",
			
			"4294698052",
			"4294697028",
			/* d (dInfo) */
			"4294692964",
			/* D (DInfo) */
			"4294692932",
			
			"4294688864",
			"4294684772",
			/* ` */
			"4294684768",
			/*  */
			"4294684676",
			"4294684672",
			"4294680676",
			/* ` */
			"4294680672",
			/* D */
			"4294680644",
			"4294680640",
			
			"4294677604",
			"4294677572",
			"4294677092",
			
			"4294676676",
			"4294676672",
			/* d (dInfo) */
			"4294676580",
			/* ` */
			"4294676576",
			/* D (DXing) */
			"4294676548",
			/* @ */
			"4294676544",
			"4294676484",
			"4294676480",
			/* p */
			"4294668484",
			/* ` */
			"4294664388",
			"4294660292",
			
			"4294652100",
			"4294611968",
			
			"4294166724",
			
			"4294156388",
			
			"4294148292",
			"4294145108",
			
			"4293101764",
			
			/* ÿû */
			"3284124603",
			
			"287310080",
			
			"218821433",
			"218818698",
			"218777924",
			"218783877",
			/* � (dInfo)*/
			"184548224",
		);
		
		if (  $fileDescription === 1297766144 || $fileDescription === 1297764352 || $fileDescription === 1297794049 || $fileDescription === 1297778688 || $fileDescription === 1297780736 /* MZ */ ) {
			return "EXE";
		} else if ( in_array($fileDescription, $mp3FileHeader)) {
			return "MP3";
		} else if ( $fileDescription === 1297377380 /* MThd */ || $fileDescription === 749685) {
			return "MID";
		} else if ( $fileDescription === 4292411374 || $fileDescription === 4292411360 /* JPG, JFIF */ || $fileDescription === 4292411361 /* Exif JPG */ || $fileDescription === 4292411355 || $fileDescription === 4292411362 || $fileDescription === 4292411372) {
			return "JPG";
		} else if ( $fileDescription === 771752170 ) {
			return "GBA";
		} else if ( $fileDescription === 1332176723 ) {
			return "OGG/OGA/OGV";
		} else if ( $fileDescription === 943870035 ) {
			return "PSD";
		} else if ( $fileDescription === 1313166106 /* NES */ ) {
			return "NES";
		} else if ( $fileDescription === 1229866072 ) {
			return "IDX";
		} else if ( $fileDescription === 1280985424 ) {
			return "LZ";
		} else if ( $fileDescription === 1144008753 ) {
			return "ISO";
		} else if ( $fileDescription === 2037396327 ) {
			return "3GP/3G2";
		} else if ( $fileDescription === 1413760326 ) {
			return "TDEF";
		} else if ( $fileDescription === 1413760326 ) {
			return "TDEF";
		} else if ( $fileDescription === 1716281667 ) {
			return "FLAG";
		} else if ( $fileDescription === 799024 ) {
			return "ZIP";
		} else if ( $fileDescription === 1347093252 /* PK, KPZIP/PPTX */) {
			return "ZIP/PPTX";
		} else if ( $fileDescription === 1178089313 /* GIF8 (GIF87a) */ || $fileDescription === 1195984440 /* GIF8 (GIF89a) */) {
			return "GIF";
		} else if ( $fileDescription === 1297771520 ) {
			return "DLL";
		} else if ( $fileDescription === 1275068416 /* LLNK */) {
			return "LNK";
		} else if ( $fileDescription === 1534799920 || $fileDescription === 1531200838 ) {
			return "URL";
		} else if ( $fileDescription === 2303741511 /* PNG */) {
			return "PNG";
		} else if ( $fileDescription === 1162758471 ) {
			return "MUS";
		} else if ( $fileDescription === 28 /* M4A */ ) { //ftypM4A
			return "M4A";
		} else if ( $fileDescription === 757935405 ) {
			return "CAP";
		} else if ( $fileDescription === 1297303124 ) {
			return "TLB";
		} else if ( $fileDescription === 168100097 ) {
			return "PCX";
		} else if ( $fileDescription === 1681144425 ) {
			return "TORRENTDATA";
		} else if ( $fileDescription === 1680945210 ) {
			return "DAT";
		} else if ( $fileDescription === 1332176723 ) {
			return "OGG";
		} else if ( $fileDescription === 1346655281 ) {
			return "PDF";
		} else if ( $fileDescription === 256 ) {
			return "ICODATA";
		} else if ( $fileDescription === 4294845184 ) {
			return "AIMPPL4";
		} else if ( $fileDescription === 1230263110 ) {
			return "CHM";
		} else if ( $fileDescription === 3503231456 ) {
			return "MSI";
		} else if ( $fileDescription === 1380533830 /* RIFF */ ) {
			return "AVI/WAV/CPR";
		} else if ( $fileDescription === 1346979398 ) {
			return "WAV";
		} else if ( $fileDescription === 1112356435 || $fileDescription === 1112364703 || $fileDescription === 1112364798 || $fileDescription === 1112356374) {
			return "BMP";
		} else if ( $fileDescription === 1481650957 || $fileDescription === 1112344120 || $fileDescription === 1112355844 || $fileDescription === 1112356444 ) {
			return "XP3";
		} else if ( $fileDescription === 807842421 ) {
			return "WMV";
		} else if ( $fileDescription === 1180128006 || $fileDescription === 1180128009 || $fileDescription === 1129796358) {
			return "SWF";
		} else if ( $fileDescription === 440786851 ) {
			return "WEBM";
		} else if ( $fileDescription === 20 || $fileDescription === 32 /* MP4 (ftypisom isomiso2avc1mp41) */ ) {
			return "MP4";
		} else if ( $fileDescription === 626017350 /* PDF*/ ) {
			return "PDF";
		} else if ( $fileDescription === 1382117921 /* Rar! */ ) {
			return "RAR";
		} else if ( $fileDescription === 1162299201 ) {
			return "EGG";
		} else if ( $fileDescription === 1625958656 ) {
			return "ARJ";
		} else if ( $fileDescription === 0 ) {
			return "EMPTY";
		} else if ( $fileDescription === 1681406561 ) {
			return "TORRENT";
		} else if ( $fileDescription === 1531860826 /* NWZ */ ) {
			return "NWC";
		} else if ( $fileDescription === 1179407873 ) {
			return "FLV";
		} else if ( $fileDescription === 557605234 ) {
			return "IPK";
		} else if ( $fileDescription === 1433299316 ) {
			return "UnityFS";
		} else {
			return "UNKNOWN";
		}
	}
	
	/**
	 * Read the file.
	 *
	 * @param string $filePath
	 * @param int    $length
	 * @param int    $mode
	 *
	 * @return bool
	 */
	public function Read ( string $filePath, int $length = -1, string $mode = 'r' ) {
		$filePath = $this->convertToNomalizePath( $filePath );
		
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
		$filePath = $this->convertToNomalizePath( $filePath );
		
		return $this->Read( $filePath, -1 );
	}
	
	/**
	 * Create a file.
	 *
	 * @param string $filePath
	 * @param string $content
	 * @param string $writeMode
	 *
	 * @return bool
	 */
	public function Write ( string $filePath, string $content = null, string $mode = 'w' ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$fileObject = new FileObject( $filePath, true, $mode );
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
	 * @param string $filePath
	 * @param string $content
	 *
	 * @return bool
	 */
	public function appendContent( string $filePath, string $content = null, bool $stream = false, bool $overwrite = true ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$overwrite && $this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ($stream) {
			file_put_contents( $filePath, $content, FILE_APPEND | LOCK_EX );
		} else {
			$this->Write( $filePath, $content, 'a' );
		}
		
		return true;
	}
	
	/**
	 * Bring the last modified time.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getLastModifiedTime ( string $filePath ) :string {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$this->clearStatatusCache( $filePath );
		$return = fileatime($filePath);
		
		return $return;
	}
	
	/**
	 * Get the file type.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getType ( string $filePath ) :string {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( FileValidation::isPharProtocol( $filePath ) ) {
			throw new StupidIdeaException ( FileHandlerMessage::getDoNotUsePharProtocolMessage() );
		}
		
		$this->clearStatatusCache( $filePath );
		$return = filetype( $filePath );
		
		return $return;
	}
	
	/**
	 * Write the contents of the file backwards.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function reverseContent ( string $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$fileLines = file( $filePath );
		$invertedLines = strrev ( array_shift( $fileLines ) );
		
		return $this->Write( $filePath, $invertedLines, 'w' );
	}
	
	public function getBasename ( string $fileName, $extension = null ) :string {
		return basename( $fileName, $extension ).PHP_EOL;
	}
	
	/**
	 * Get the file's extension.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getExtention ( string $filePath ) :string {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		$return = pathinfo($filePath, PATHINFO_EXTENSION);
		
		return $return;
	}
	
	/**
	 * Get the contents of the file.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getContent( string $filePath ) :string {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$fileHandler = fopen( $filePath, 'r' );
		$fileSize = $this->getSize( $filePath );
		$return = fread( $fileHandler, $fileSize );
		fclose( $fileHandler );
		
		return $return;
	}
	
	/**
	 * Download the file.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function Download ( string $filePath, int $bufferSize = 0 ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		$fileHandler = @fopen($filePath, 'rb');
		if ( $fileHandler === false ) {
			return false;
		}
		
		if ( $fileHandler ) {
			while( !feof( $fileHandler ) ) {
				print( @fread( $fileHandler, $bufferSize > 0 ? $bufferSize : (1024 * 8) ) );
				ob_flush();
				flush();
			}
		}
		
		fclose($file);
	}
	
	public function isCorrectInode ( $filePath ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( $this->fileSystemHandler->getCurrentInode() === $this->getInode( $filePath ) ) {
			return true;
		}
		
		return false;
	}
	
	public function getInode ( string $filePath ) {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new TargetIsNotFileException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		return $this->fileSystemHandler->getInodeNumber( $filePath );
	}
	
	/**
	 * Gets the interpreted file content.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getInterpretedContent ( string $filePath ) :string {
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
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
		$filePath = $this->convertToNomalizePath( $filePath );
		
		if ( !$this->isExists( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		if ( !$this->isFile( $filePath ) ) {
			throw new FileIsNotExistsException ( FileHandlerMessage::getFileIsNotExistsMessage() );
		}
		
		require_once $filePath;
	}
	
	/**
	 * Move the file to a specific location.
	 *
	 * @param string $filePath
	 * @param string $destination
	 *
	 * @return string
	 */
	public function Move ( string $source, string $destination ) :bool {
		$filePath = $this->convertToNomalizePath( $filePath );
		$destination = $this->convertToNomalizePath($destination);
		
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

?>