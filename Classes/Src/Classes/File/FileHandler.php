<?php

declare(strict_types=1);

namespace Xanax\Classes;

use Xanax\Classes\FileObject as FileObject;
use Xanax\Classes\FileSystemHandler as FileSystemHandler;
use Xanax\Classes\DirectoryHandler as DirectoryHandler;
use Xanax\Exception\Stupid\StupidIdeaException as StupidIdeaException;
use Xanax\Exception\FileHandler\FileIsNotExistsException as FileIsNotExistsException;
use Xanax\Exception\FileHandler\TargetIsNotFileException as TargetIsNotFileException;
use Xanax\Exception\FileHandler\InvalidFileHandler as InvalidFileHandler;
use Xanax\Implement\FileHandlerInterface as FileHandlerInterface;
use Xanax\Implement\DirectoryHandlerInterface as DirectoryHandlerInterface;
use Xanax\Validation\FileValidation as FileValidation;
use Xanax\Message\FileHandler\FileHandlerMessage as FileHandlerMessage;

class FileHandler implements FileHandlerInterface
{
	protected $useStatFunction = [
		'stat',
		'lstat',
		'file_exists',
		'is_writable',
		'is_readable',
		'is_executable',
		'is_file',
		'is_dir',
		'is_link',
		'filectime',
		'fileatime',
		'filemtime',
		'fileinode',
		'filegroup',
		'fileowner',
		'filesize',
		'filetype',
		'fileperms'
	];

	private static $lastError;

	private $strictMode = true;

	private $fileSystemHandler;

	private $directoryHandler;

	public function __construct($useStrictMode = true, FileHandlerInterface $fileSystemHandler = null, DirectoryHandlerInterface $directoryHandler = null)
	{
		$this->strictMode = $useStrictMode;

		if ($fileSystemHandler) {
			$this->fileSystemHandler = $fileSystemHandler;
		} else {
			$this->fileSystemHandler = new FileSystemHandler();
		}

		if ($directoryHandler) {
			$this->directoryHandler = $directoryHandler;
		} else {
			$this->directoryHandler = new DirectoryHandler($this);
		}
	}

	/**
	 * Check if two files are identical
	 *
	 * @param string $filePath
	 * @param string $secondPath
	 * @param int    $chunkSize
	 *
	 * @return bool
	 */
	public function isEqual($firstPath, $secondPath, $chunkSize = 500)
	{
		// First check if file are not the same size as the fastest method
		if (filesize($firstPath) !== filesize($secondPath)) {
			return false;
		}

		// Compare the first ${chunkSize} bytes
		// This is fast and binary files will most likely be different
		$fp1            = fopen($firstPath, 'r');
		$fp2            = fopen($secondPath, 'r');
		$chunksAreEqual = fread($fp1, $chunkSize) == fread($fp2, $chunkSize);
		fclose($fp1);
		fclose($fp2);

		if (!$chunksAreEqual) {
			return false;
		}

		// Compare hashes
		// SHA1 calculates a bit faster than MD5
		$firstChecksum  = sha1_file($firstPath);
		$secondChecksum = sha1_file($secondPath);
		if ($firstChecksum != $secondChecksum) {
			return false;
		}

		return true;
	}

	/**
	 * Delete the state of the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function clearStatatusCache($filePath) :void
	{
		clearstatcache(true, $filePath);
	}

	/**
	 * Delete the last directory separator.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	protected function convertToNomalizePath($filePath)
	{
		return rtrim($filePath, DIRECTORY_SEPARATOR); // Remove last Directory separator
	}

	/**
	 * Make sure the file handler is of type resource.
	 *
	 * @param string $fileHandler
	 *
	 * @return bool
	 */
	public function isValidHandler($fileHandler)
	{
		if (getType($fileHandler) !== 'resource') {
			return false;
		}

		if (get_resource_type($fileHandler) !== 'stream') {
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
	public function getPointerLocation($fileHandler)
	{
		if (!$this->isValidHandler($fileHandler)) {
			throw new InvalidFileHandler(FileHandlerMessage::getInvalidFileHandler());
		}

		return ftell($fileHandler);
	}

	/**
	 * Create a cache file
	 *
	 * @param string $filePath
	 * @param string $destination
	 *
	 * @return bool
	 */
	public function createCache(string $filePath, string $destination)
	{
		$filePath    = $this->convertToNomalizePath($filePath);
		$destination = $this->convertToNomalizePath($destination);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
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
	public function isReadable(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$return = is_readable($filePath);

		return $return;
	}

	/**
	 * Interpret the INI file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function parseINI($filePath)
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		return parse_ini_file($filePath);
	}

	/**
	 * Gets the MIME of the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function getMIMEType($filePath)
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		return mime_content_type($filePath);
	}

	/**
	 * Gets whether the file is locked.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isLocked($filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			return false;
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if ($this->strictMode && !$this->isValidHandler($filePath) && !$this->isFile($filePath)) {
			return false;
		}

		if (!$this->isValidHandler($filePath)) {
			$filePath = fopen($filePath, 'r+');
		}

		if (!flock($filePath, LOCK_EX)) {
			return true;
		}

		return false;
	}

	public function getLine(string $fileHandler, int $length) :string
	{
		if (!$this->isValidHandler($fileHandler)) {
			throw new InvalidFileHandler(FileHandlerMessage::getInvalidFileHandler());
		}

		fgets($fileHandler, $length);
	}

	public function getCharacter(string $fileHandler, int $length) :string
	{
		if (!$this->isValidHandler($fileHandler)) {
			throw new InvalidFileHandler(FileHandlerMessage::getInvalidFileHandler());
		}

		fgetc($fileHandler, $length);
	}

	/**
	 * Gets file permissions
	 *
	 * @return resource
	 */
	public function getPermissions($filePath) :int
	{
		return fileperms($filePath);
	}

	/**
	 * Gets file owner
	 *
	 * @return resource
	 */
	public function getOwner($filePath) :int
	{
		return fileowner($filePath);
	}

	/**
	 * Create a temporary file
	 *
	 * @return resource
	 */
	public function createTemporary() :resource
	{
		return tmpfile();
	}

	public function createUniqueTemporary($directory, $prefix)
	{
		return $tmpfname = tempnam($directory, $prefix);
	}

	public function setAccessAndModificatinTime($filePath, $time, $atime)
	{
		touch($filePath, $time, $atime);
	}

	/**
	 * Unlock the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function Unlock($fileHandler)
	{
		if (!$this->isValidHandler($fileHandler)) {
			throw new InvalidFileHandler(FileHandlerMessage::getInvalidFileHandler());
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
	public function changeMode(string $filePath, int $mode) :bool
	{
		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		return chmod($filePath, $mode) ? true : false;
	}

	/**
	 * Change group of file
	 *
	 * @param string $filePath
	 * @param int    $mode
	 *
	 * @return bool
	 */
	public function changeGroup(string $filePath, string $group) :bool
	{
		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		return chgrp($filePath, $group);
	}

	/**
	 * Lock the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function Lock($fileHandler, $mode = 'r')
	{
		if (!$this->isValidHandler($fileHandler)) {
			throw new InvalidFileHandler(FileHandlerMessage::getInvalidFileHandler());
		}

		$mode = strtolower($mode);

		switch ($mode) {
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
	public function isEmpty(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$return = $this->getSize($filePath) !== 0;

		return $return;
	}

	/**
	 * Check if the file exists.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isExists(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$return = file_exists($filePath);

		return $return;
	}

	/**
	 * Check if the file type is unknown.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isUnknownFile(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if ($this->getType($filePath) === 'unknown') {
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
	public function getSymbolicLink(string $symbolicLink)
	{
		if (!$this->isSymbolicLink($symbolicLink)) {
		}

		$return = readlink($symbolicLink);

		return $return;
	}

	public function isSymbolicLink(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (is_link($filePath) && $this->getType($filePath) === 'link') {
			return true;
		}

		return false;
	}

	/**
	 * Check if the file type is regular.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isRegularFile(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if ($this->getType($filePath) === 'file') {
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
	public function isContainFolder(string $basePath, string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$realBasePath = realpath($basePath);
		$realFilePath = realpath(dirname($filePath));

		if ($realFilePath === false || strncmp($realFilePath, $realBasePath, strlen($realBasePath)) !== 0) {
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
	public function isFile(string $filePath, string $containDirectory = null) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (FileValidation::isReadable($filePath)) {
		}

		if (FileValidation::hasSubfolderSyntax($filePath)) {
			if ($targetDirectory === null) {
				throw new StupidIdeaException(FileHandlerMessage::getDoNotUseSubDirectorySyntaxMessage());
			} elseif (!$this->isContainFolder($containDirectory, $filePath)) {
				return false;
			}
		}

		if (FileValidation::isPharProtocol($filePath)) {
			throw new StupidIdeaException(FileHandlerMessage::getDoNotUsePharProtocolMessage());
		}

		$return = is_file($filePath);

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
	public function isEqualByLine(string $filePath, string $string = null) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$fileObject = new FileObject($filePath, false, 'r');
		$fileObject->startHandle();
		$bool = $fileObject->isEqualByLine($string);
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
	public function isExecutable($filePath)
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			return false;
		}

		$this->clearStatatusCache($filePath);
		$return = is_executable($filePath);

		return $return;
	}

	/**
	 * Gets whether the file can be written to.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function isWritable(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			return true;
		}

		if (!$this->isFile($filePath)) {
			return true;
		}

		$this->clearStatatusCache($filePath);
		$return = is_writable($filePath);

		return $return;
	}

	/**
	 * Delete the file.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function Delete(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
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
	public function getSize(string $filePath, bool $humanReadable = false) :int
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$this->clearStatatusCache($filePath);

		if ($humanReadable) {
			if (file_exists($file)) {
				$bytes = (int) filesize($file);
			} else {
				$bytes = is_int($file) ? $file : -1;
			}

			if ($bytes > 0) {
				$sizes            = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
				$measure          = strlen($bytes >> 10);
				$factor           = $bytes < (1024 ** 6) ? ($measure > 1 ? floor((($measure - 1) / 3) + 1) : 1) : floor((strlen($bytes) - 1) / 3);
				$capacity         = $bytes / pow(1024, $factor);
				$multiBytesPrefix = ($capacity === intval($capacity) ?: 'ytes');
				$bytes            = sprintf('%s%s%s', $capacity, $sizes[$factor], $multiBytesPrefix);
			}

			return $bytes;
		}

		$return = filesize($filePath);

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
	public function Copy(string $filePath, string $destination) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$return = copy($filePath, $destination);

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
	public function Merge(string $filePath, string $mergeFile) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$fileObject = new FileObject($filePath, false, 'a');
		$fileObject->startHandle();

		$fileObject->appendContent($mergeFile);

		$fileObject->closeFileHandle();

		return true;
	}

	public function changeUmask($mask) :int
	{
		return umask($mask);
	}

	/**
	 * Get a header type of file by big endian data
	 *
	 * @param string $filePath
	 *
	 * @return void
	 */
	public function getHeaderType(string $filePath) :string
	{
		$size = filesize($filePath);
		$size = $size > 100 ? 100 : $size;

		if ($size <= 4) {
			return false;
		}

		$header = $this->Read($filePath, $size);
		if ($header) {
			$bigEndianUnpack = unpack('N', $header);
		} else {
			return false;
		}

		/* ISO 8859-1 */
		$fileDescription = array_shift($bigEndianUnpack);

		$mp3FileHeader = [
			/* ftyp3gp4isom3gp4 */
			'0x18',

			/* !DO (p Hq) */
			'0x3C21444F',

			'0x4D617220',

			/* ID3 (TSSE) */
			'0x2F271E8',
			/* ID3 (GEOB, TYER, TALB, TSSE, TXXX, TPE1, TIT2, TCON, PRIV, TRCK) */
			'0x49443303',
			/* ID3 (TALB, TIT2, TSS, TT2, FTT2, TPE1) */
			'0x49443302',

			'0x2E4BEAA',

			'0xFFFBE444',
			'0xFFFBE044',
			/* d (dInfo) */
			'0xFFFBD064',
			/* D (DInfo) */
			'0xFFFBD044',

			'0xFFFBC060',
			'0xFFFBB064',
			/* ` */
			'0xFFFBB060',
			/*  */
			'0xFFFBB004',
			'0xFFFBB000',
			'0xFFFBA064',
			/* ` */
			'0xFFFBA060',
			/* D */
			'0xFFFBA044',
			'0xFFFBA040',

			'0xFFFB9464',
			'0xFFFB9444',
			'0xFFFB9264',

			'0xFFFB90C4',
			'0xFFFB90C0',
			/* d (dInfo) */
			'0xFFFB9064',
			/* ` */
			'0xFFFB9060',
			/* D (DXing) */
			'0xFFFB9044',
			/* @ */
			'0xFFFB9040',
			'0xFFFB9004',
			'0xFFFB9000',
			/* p */
			'0xFFFB70C4',
			/* ` */
			'0xFFFB60C4',
			'0xFFFB50C4',

			'0xFFFB30C4',
			'0xFFFA9400',

			'0xFFF3C8C4',

			'0xFFF3A064',

			'0xFFF380C4',
			'0xFFF37454',

			'0xFFE388C4',

			/* ÿû */
			'0xC3BFC3BB',

			'0x11200100',

			'0xD0AF339',
			'0xD0AE88A',
			'0xD0A4944',
			'0xD0A6085',
			/* � (dInfo)*/
			'0xAFFFB80',
		];

		$exeFileHeader = [
			'0x4D5A5700',
			'0x4D5A5000',
			'0x4D5AC401',
			'0x4D5A8800',
			/* MZ */
			'0x4D5A9000'
		];

		$jpgFileHeader = [
			'0xFFD8FFEE',
			/* JPG, JFIF */
			'0xFFD8FFE0',
			/* Exif JPG */
			'0xFFD8FFE1',
			'0xFFD8FFDB',
			/* MZ */
			'0xFFD8FFE2',
			'0xFFD8FFEC'
		];

		$bmpFileHeader = [
			'0x424D3653',
			'0x424D569F',
			'0x424D56FE',
			'0x424D3616',
		];

		$xp3FileHeader = [
			'0x5850330D',
			'0x424D0638',
			'0x424D3404',
			'0x424D365C',
		];

		$swfFileHeader = [
			'0x46575306',
			'0x46575309',
			'0x43575306'
		];

		if (in_array($fileDescription, $exeFileHeader)) {
			return 'EXE';
		} elseif (in_array($fileDescription, $mp3FileHeader)) {
			return 'MP3';
		} elseif ($fileDescription === 0x4D546864 /* MThd */ || $fileDescription === 0xB7075) {
			return 'MID';
		} elseif (in_array($fileDescription, $jpgFileHeader)) {
			return 'JPG';
		} elseif ($fileDescription === 0x2E0000EA) {
			return 'GBA';
		} elseif ($fileDescription === 0x4F676753) {
			return 'OGG/OGA/OGV';
		} elseif ($fileDescription === 0x38425053) {
			return 'PSD';
		} elseif ($fileDescription === 0x4E45531A /* NES */) {
			return 'NES';
		} elseif ($fileDescription === 0x494E4458) {
			return 'IDX';
		} elseif ($fileDescription === 0x4C5A4950) {
			return 'LZ';
		} elseif ($fileDescription === 0x44303031) {
			return 'ISO';
		} elseif ($fileDescription === 0x79703367) {
			return '3GP/3G2';
		} elseif ($fileDescription === 0x54444546) {
			return 'TDEF';
		} elseif ($fileDescription === 0x664C6143) {
			return 'FLAG';
		} elseif ($fileDescription === 0xC3130) {
			return 'ZIP';
		} elseif ($fileDescription === 0x504B0304 /* PK, KPZIP/PPTX */) {
			return 'ZIP/PPTX';
		} elseif ($fileDescription === 0x46383761 /* GIF8 (GIF87a) */ || $fileDescription === 0x47494638 /* GIF8 (GIF89a) */) {
			return 'GIF';
		} elseif ($fileDescription === 0x4D5A6C00) {
			return 'DLL';
		} elseif ($fileDescription === 0x4C000000 /* LLNK */) {
			return 'LNK';
		} elseif ($fileDescription === 0x5B7B3030 || $fileDescription === 0x5B444546) {
			return 'URL';
		} elseif ($fileDescription === 0x89504E47 /* PNG */) {
			return 'PNG';
		} elseif ($fileDescription === 0x454E4947) {
			return 'MUS';
		} elseif ($fileDescription === 0x1C /* M4A */) { //ftypM4A
			return 'M4A';
		} elseif ($fileDescription === 0x2D2D2D2D) {
			return 'CAP';
		} elseif ($fileDescription === 0x4D534654) {
			return 'TLB';
		} elseif ($fileDescription === 0xA050101) {
			return 'PCX';
		} elseif ($fileDescription === 0x64343A69) {
			return 'TORRENTDATA';
		} elseif ($fileDescription === 0x6431303A) {
			return 'DAT';
		} elseif ($fileDescription === 0x4F676753) {
			return 'OGG';
		} elseif ($fileDescription === 0x50445431) {
			return 'PDF';
		} elseif ($fileDescription === 0x100) {
			return 'ICODATA';
		} elseif ($fileDescription === 0xFFFE2300) {
			return 'AIMPPL4';
		} elseif ($fileDescription === 0x49545346) {
			return 'CHM';
		} elseif ($fileDescription === 0xD0CF11E0) {
			return 'MSI';
		} elseif ($fileDescription === 0x52494646 /* RIFF */) {
			return 'AVI/WAV/CPR';
		} elseif ($fileDescription === 0x50494646) {
			return 'WAV';
		} elseif (in_array($fileDescription, $bmpFileHeader)) {
			return 'BMP';
		} elseif (in_array($fileDescription, $xp3FileHeader)) {
			return 'XP3';
		} elseif ($fileDescription === 0x3026B275) {
			return 'WMV';
		} elseif (in_array($fileDescription, $swfFileHeader)) {
			return 'SWF';
		} elseif ($fileDescription === 0x1A45DFA3) {
			return 'WEBM';
		} elseif ($fileDescription === 20 || $fileDescription === 32 /* MP4 (ftypisom isomiso2avc1mp41) */) {
			return 'MP4';
		} elseif ($fileDescription === 0x25504446 /* PDF*/) {
			return 'PDF';
		} elseif ($fileDescription === 0x52617221 /* Rar! */) {
			return 'RAR';
		} elseif ($fileDescription === 0x45474741) {
			return 'EGG';
		} elseif ($fileDescription === 0x60EA2900) {
			return 'ARJ';
		} elseif ($fileDescription === 0) {
			return 'EMPTY';
		} elseif ($fileDescription === 0x64383A61) {
			return 'TORRENT';
		} elseif ($fileDescription === 0x5B4E575A /* NWZ */) {
			return 'NWC';
		} elseif ($fileDescription === 0x464C5601) {
			return 'FLV';
		} elseif ($fileDescription === 0x213C6172) {
			return 'IPK';
		} elseif ($fileDescription === 0x556E6974) {
			return 'UnityFS';
		} elseif ($fileDescription === 0x3C3F7068) {
			return 'PHP';
		} elseif ($fileDescription === 0x3C3F786D) {
			return 'XML';
		} else {
			return false;
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
	public function Read(string $filePath, int $length = -1, string $mode = 'r')
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$fileObject = new FileObject($filePath, false, $mode);
		if (!$fileObject->isEnoughFreeSpace()) {
			$this::$lastError = 'Disk space is not enough';

			return false;
		}

		$fileObject->startHandle();

		if (!$fileObject->successToStartHandle()) {
			return false;
		}

		if (!$fileObject->hasReadedContent()) {
			return false;
		}

		if ($length === -1) {
			$fileObject->readAllContent();
		} else {
			$fileObject->readContent($length);
		}

		$content = $fileObject->getReadedContent();

		$fileObject->closeFileHandle();

		return $content;
	}

	/**
	 * Read the file contents.
	 *
	 * @param string $filePath
	 * @param int    $length
	 * @param int    $mode
	 *
	 * @return bool
	 */
	public function readAllContent(string $filePath, string $writeMode = 'r')
	{
		$filePath = $this->convertToNomalizePath($filePath);

		return $this->Read($filePath, -1);
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
	public function Write(string $filePath, string $content = null, string $mode = 'w') :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$fileObject = new FileObject($filePath, true, $mode);
		$fileObject->startHandle();

		if (!$fileObject->successToStartHandle()) {
			return false;
		}

		$fileObject->writeContent($content);

		if (!$fileObject->successToWriteContent()) {
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
	public function appendContent(string $filePath, string $content = null, bool $stream = false, bool $overwrite = true) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$overwrite && $this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if ($stream === true) {
			file_put_contents($filePath, $content, FILE_APPEND | LOCK_EX);
		} else {
			$this->Write($filePath, $content, 'a');
		}

		return true;
	}

	/**
	 * Bring the last access time.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getLastAccessDate($filePath)
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			return false;
		}

		$this->clearStatatusCache($filePath);
		$return = fileatime($filePath);

		return $return;
	}

	/**
	 * Bring the created time.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getCreatedDate($filePath)
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			return false;
		}

		$this->clearStatatusCache($filePath);
		$return = filectime($filePath);

		return $return;
	}

	/**
	 * Bring the last modified time.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getLastModifiedTime(string $filePath) :string
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$this->clearStatatusCache($filePath);
		$return = filemtime($filePath);

		return $return;
	}

	/**
	 * Get the file type.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getType(string $filePath) :string
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (FileValidation::isPharProtocol($filePath)) {
			throw new StupidIdeaException(FileHandlerMessage::getDoNotUsePharProtocolMessage());
		}

		$this->clearStatatusCache($filePath);
		$return = filetype($filePath);

		return $return;
	}

	/**
	 * Write the contents of the file backwards.
	 *
	 * @param string $filePath
	 *
	 * @return bool
	 */
	public function reverseContent(string $filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		$fileLines     = file($filePath);
		$invertedLines = strrev(array_shift($fileLines));

		return $this->Write($filePath, $invertedLines, 'w');
	}

	public function getBasename(string $fileName, $extension = null) :string
	{
		return basename($fileName, $extension) . PHP_EOL;
	}

	/**
	 * Get the file's extension.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getExtention(string $filePath) :string
	{
		$filePath = $this->convertToNomalizePath($filePath);

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
	public function getContent(string $filePath) :string
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$fileHandler = fopen($filePath, 'r');
		$fileSize    = $this->getSize($filePath);
		$return      = fread($fileHandler, $fileSize);
		fclose($fileHandler);

		return $return;
	}

	/**
	 * Download the file.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function Download(string $filePath, int $bufferSize = 0) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$fileHandler = @fopen($filePath, 'rb');
		if ($fileHandler === false) {
			return false;
		}

		if ($fileHandler) {
			while (!feof($fileHandler)) {
				print(@fread($fileHandler, $bufferSize > 0 ? $bufferSize : (1024 * 8)));
				ob_flush();
				flush();
			}
		}

		fclose($file);
	}

	/**
	 * Check that inode of file is valid
	 *
	 * @param string $filePath
	 *
	 * @return boolean
	 */
	public function isCorrectInode($filePath) :bool
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if ($this->fileSystemHandler->getCurrentInode() === $this->getInode($filePath)) {
			return true;
		}

		return false;
	}

	/**
	 * Get a inode of file
	 *
	 * @param string $filePath
	 *
	 * @return mixed
	 */
	public function getInode(string $filePath)
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		return $this->fileSystemHandler->getInodeNumber($filePath);
	}

	/**
	 * Gets the interpreted file content.
	 *
	 * @param string $filePath
	 *
	 * @return string
	 */
	public function getInterpretedContent(string $filePath) :string
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		ob_start();

		if (isset($filePath)) {
			if (file_exists($filePath)) {
				@include $filePath;
			} else {
				throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
			}
		}

		$return = ob_get_clean();

		return $return;
	}

	/**
	 * Require once a php file 
	 *
	 * @param string $filePath
	 *
	 * @return void
	 */
	public function requireOnce(string $filePath) :void
	{
		$filePath = $this->convertToNomalizePath($filePath);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
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
	public function Move(string $source, string $destination) :bool
	{
		$filePath    = $this->convertToNomalizePath($filePath);
		$destination = $this->convertToNomalizePath($destination);

		if (!$this->isExists($filePath)) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if (!$this->isFile($source)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$return = rename($source, $destination);

		return $return;
	}
}
