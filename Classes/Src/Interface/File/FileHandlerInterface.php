<?php

namespace Xanax\Implement;

interface FileHandlerInterface {
	
	public function isFile(string $filePath, string $containDirectory = null) :bool;

	public function isEmpty(string $filePath) :bool;

	public function isExists(string $filePath) :bool;

	public function isContainFolder(string $basePath, string $filePath) :bool;

	public function isCorrectInode($filePath) :bool;

	public function isValidHandler($fileHandler);

	public function isReadable(string $filePath) :bool;

	public function isLocked($filePath) :bool;

	public function isRegularFile(string $filePath) :bool;

	public function isSymbolicLink(string $filePath) :bool;

	public function isUnknownFile(string $filePath) :bool;

	public function isEqualByLine(string $filePath, string $string = null) :bool;

	public function isWritable(string $filePath) :bool;

	public function getSize(string $filePath, bool $humanReadable) :int;

	public function getInode(string $filePath);

	public function getLastModifiedTime(string $filePath) :string;

	public function getCreatedDate($filePath);

	public function getLastAccessDate($filePath);

	public function getType(string $filePath) :string;

	public function getExtension(string $filePath) :string;

	public function getBasename(string $fileName, $extension = null) :string;

	public function getContent(string $filePath) :string;

	public function getHeaderType(string $filePath);

	public function getInterpretedContent(string $filePath) :string;

	public function Merge(string $filePath, string $mergeFile) :bool;

	public function Delete(string $filePath) :bool;

	public function copy(string $filePath, string $destinationPath) :bool;

	public function appendContent(string $filePath, string $content = null, bool $overwrite = true) :bool;

	public function Write(string $filePath, string $content = null, string $writeMode = 'w') :bool;

	public function Read(string $filePath, int $length = -1, string $writeMode = 'r');

	public function readAllContent(string $filePath, string $writeMode = 'r');

	public function reverseContent(string $filePath) :bool;

	public function Download(string $filePath) :bool;

	public function requireOnce(string $filePath);

	public function Move(string $source, string $destination) :bool;
	
}
