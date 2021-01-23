<?php

declare(strict_types=1);

namespace Xanax\Classes\File;

use Xanax\Classes\File\Handler as FileHandler;
use Xanax\Classes\Directory\Handler as DirectoryHandler;

use Xanax\Implement\FileObjectInterface;
use Xanax\Exception\FileHandler\FileIsNotExistsException;
use Xanax\Exception\FileHandler\TargetIsNotFileException;
use Xanax\Message\FileHandler\FileHandlerMessage;

class FileObject implements FileObjectInterface {
	private $writeHandler;
	private $fileHandler;

	private $readedContent;

	/*
	 * r  : Read only
	 * r+ : Read and write
	 * w  : Write only
	 * w+ : Write and read
	 * a  : Read only
	 * a+ : Read and read
	 * c  : Read and write
	 *
	 * Append syntax : b, t
	 */
	private $modeList = ['r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+', 'e'];

	private $readModeList = ['r', 'r+'];

	private $createIfModeEmpty = ['w', 'w+', 'a', 'c'];

	private $acceptExtension = [];

	// Determines whether file size capacity is compared
	private $confirmFilesize = true;

	// The size of the file last created
	private $writeContentLength;

	// File creation mode
	private $mode;

	// The path of the file to be finally created
	private $filePath;

	// File extension
	private $fileExtension;

	// Class file for managing file
	private $fileHandlerClass;

	// Path of the file to be temporarily saved
	private $temporaryPath;

	// File pointer location
	private $seekOffset;

	// If the length does not match the contents written, it is returned to the original file
	private $recoveryMode = false;

	public function __construct(string $filePath, bool $recoveryMode = false, string $mode = 'w') {
		$this->fileHandlerClass = new FileHandler();
		$this->directoryHandler = new DirectoryHandler($this->fileHandlerClass);

		$this->mode = $mode;
		$this->seekOffset = 0;
		$this->filePath = $filePath;
		$this->fileExtension = $this->fileHandlerClass->getExtension($this->filePath);

		$this->recoveryMode = $recoveryMode;
		if ($this->recoveryMode) {
			$this->setRecoveryFile();
		}
	}

	public function __destruct() {
		$this->removeTemporary();
	}

	public function getAcceptExtension(array $extension) {
		return $acceptExtension;
	}

	public function setAcceptExtension($extension) {
		$acceptExtension = is_array($extension) ? $extension : [$extension];
	}

	private function setRecoveryFile() {
		do {
			$this->temporaryPath = sprintf('%s.%s.%s', $this->filePath, uniqid(rand(), true), $this->fileExtension);
		} while ($this->fileHandlerClass->isFile($this->temporaryPath));

		$isReadOnlyMode = $this->mode === 'a';
		$isFileExists = $this->fileHandlerClass->isExists($this->filePath);
		
		if ($isReadOnlyMode && $isFileExists) {
			$fileContent = file_get_contents($this->filePath, true);
			file_put_contents($this->temporaryPath, $fileContent);
		}
	}

	public function hasWriteContentLength() :bool {
		if ($this->writeContentLength === -1) {
			return false;
		}

		return true;
	}

	public function closeFileHandle() :bool {
		fclose($this->fileHandler);

		if (!$this->recoveryMode) {
			return true;
		}

		if ($this->recoveryMode && !$this->hasWriteContentLength()) {
			return true;
		}

		$filePath = $this->getFilePath();
		$currentFileSize = $this->getCurrentSize();
		$invalidFileSize = $currentFileSize === -1 ? true : false;
		$correctFileSize = ($currentFileSize === (int)$this->writeContentLength);

		$isFileExists = $this->fileHandlerClass->isFile($filePath);
		
		if ($this->recoveryMode && $isFileExists) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		if ($this->recoveryMode && !$invalidFileSize && !$correctFileSize) {
			$this->fileHandlerClass->Delete($filePath);
			return false;
		}

		if ($this->recoveryMode) {
			if ($this->fileHandlerClass->Copy($filePath, $this->filePath)) {
				$this->fileHandlerClass->Delete($filePath);
			}
		}

		return true;
	}

	public function Seek(int $offset) :bool {
		$seek = fseek($this->fileHandler, $offset, SEEK_SET);

		if ($seek === 0) {
			$this->seekOffset = $offset;

			return true;
		}

		return false;
	}

	public function hasMode($readMode = null) :bool {
		if (in_array(($readMode || $this->mode), $this->createIfModeEmpty)) {
			return true;
		}

		return false;
	}

	public function isReadable($readMode = null) :bool {
		if (in_array(($readMode || $this->mode), $this->readModeList)) {
			return true;
		}

		return false;
	}

	public function appendContent($filePath) :void {
		$fileHandler = fopen($filePath, 'r');

		$line = fgets($fileHandler);

		while ($line !== false) {
			fputs($this->fileHandler, $line);
			$line = fgets($fileHandler);
		}

		fclose($fileHandler);
	}

	public function isEqualByLine(string $string) :bool {
		if (!$this->fileHandlerClass->isExists($this->getFilePath())) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$bool = false;

		while ($isEqual = fgets($this->fileHandler)) {
			if ($isEqual === $string) {
				$bool = true;
			} else {
				$bool = false;
			}
		}

		return $bool;
	}

	public function injectFileIsNotExistsException() :void {
		if ($this->recoveryMode && $this->fileHandlerClass->isFile($this->filePath)) {
			throw new TargetIsNotFileException(FileHandlerMessage::getFileIsNotExistsMessage());
		}
	}

	public function isLocked() :bool {
		$this->injectFileIsNotExistsException();

		return $this->fileHandlerClass->isLocked($this->filePath);
	}

	public function isWritable() :bool {
		$this->injectFileIsNotExistsException();

		return $this->fileHandlerClass->isWritable($this->filePath);
	}

	public function removeTemporary() {
		if ($this->recoveryMode) {
			if ($this->fileHandlerClass->isExists($this->temporaryPath)) {
				$this->fileHandlerClass->Delete($this->temporaryPath);
			}
		}
	}

	public function writeContent(string $content, $isLarge = false, int $bufferSize) :bool {
		if (!$this->isWritable() || $this->isLocked()) {
			$this->removeTemporary();
			return false;
		}

		$this->confirmFilesize = true;

		if ($this->mode === 'w') {
			$this->writeContentLength = strlen($content);
		} elseif ($this->mode === 'a') {
			$this->writeContentLength = $this->fileHandlerClass->getSize($this->filePath);
			$this->writeContentLength += strlen($content);
		}

		if ($isLarge) {
			$pieces = str_split($content, $bufferSize ? $bufferSize : (1024 * 4));
			foreach ($pieces as $piece) {
				$this->writeHandler += fwrite($this->fileHandler, $piece, strlen($piece));
			}
		} else {
			$this->writeHandler = fwrite($this->fileHandler, $content);
		}

		return true;
	}

	public function getCurrentSize() :int {
		$filePath = $this->getFilePath();
		$currentFileSize = $this->fileHandlerClass->getSize($filePath);

		return $currentFileSize;
	}

	public function getReadedContent() :string {
		return (!$this->isReadedContentValid()) ? '' : $this->readedContent;
	}

	public function isReadedContentValid() :bool {
		return !($this->readedContent === false);
	}

	public function hasReadedContent() {
		return $this->getCurrentSize() > 0;
	}

	public function readAllContent() {
		if (!$this->hasReadedContent()) {
		}

		$this->readContent($this->getCurrentSize());
	}

	public function readContent(int $fileSize = 0) :void {
		$this->readedContent = fread($this->fileHandler, $fileSize);
	}

	public function printFileData(int $mbSize = 8) :void {
		while (!feof($this->fileHandler)) {
			print(@fread($this->fileHandler, (1024 * $mbSize)));
			ob_flush();
			flush();
		}
	}

	public function isEnoughFreeSpace() :bool {
		$freeSpace = $this->directoryHandler->getFreeSpace();
		if ($freeSpace === -1) {
			return true;
		}

		$capacity = (int)$this->writeContentLength;

		$isEnough = $capacity < $freeSpace;
		if ($this->mode === 'w' && !$isEnough) {
			return false;
		}

		$sourceFileSize = $this->fileHandlerClass->getSize($this->filePath);
		$bool = ($freeSpace + $sourceFileSize) < $freeSpace;
		if ($this->mode === 'a' && !$bool) {
			return false;
		}

		return true;
	}

	public function successToWriteContent() :bool {
		if (!getType($this->writeHandler) === 'integer') {
			return false;
		}

		$isInvalidSize = ($this->writeHandler !== (int)$this->writeContentLength);

		if ($this->mode === 'w' && $isInvalidSize) {
			return false;
		}

		$isCorrectSize = ($this->fileHandlerClass->getSize($this->temporaryPath) !== (int)$this->writeContentLength);

		if ($this->mode === 'a' && $isCorrectSize) {
			return false;
		}

		return true;
	}

	public function getFilePath() :string {
		if ($this->recoveryMode) {
			$filePath = $this->temporaryPath;
		} else {
			$filePath = $this->filePath;
		}

		return $filePath;
	}

	public function startHandle() :void {
		$fileIsNotExists = (!$this->hasMode() && !$this->fileHandlerClass->isExists($this->getFilePath()));

		if ($fileIsNotExists) {
			throw new FileIsNotExistsException(FileHandlerMessage::getFileIsNotExistsMessage());
		}

		$this->fileHandler = fopen($this->getFilePath(), $this->mode);
	}

	public function successToStartHandle() :bool {
		if (($this->fileHandler) === false) {
			return false;
		}

		if (getType($this->fileHandler) !== 'resource') {
			return false;
		}

		if (get_resource_type($this->fileHandler) !== 'stream') {
			return false;
		}

		return true;
	}
	
}
