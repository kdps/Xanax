<?php

namespace Xanax\Implement;

interface FileObjectInterface {
	
	public function getAcceptExtension(array $extension);

	public function setAcceptExtension(array $extension);

	public function hasWriteContentLength();

	public function closeFileHandle();

	public function Seek(int $offset) :bool;

	public function hasMode($readMode = null);

	public function isReadable($readMode = null);

	public function appendContent($filePath);

	public function isEqualByLine(string $string);

	public function isLocked() :bool;

	public function isWritable() :bool;

	public function removeTemporary();

	public function writeContent(string $content, $isLarge = false, int $bufferSize) :bool;

	public function getCurrentSize() :int;

	public function getReadedContent() :string;

	public function isReadedContentValid() :bool;

	public function hasReadedContent();

	public function readAllContent();

	public function readContent(int $fileSize = 0);

	public function printFileData(int $mbSize = 8);

	public function isEnoughFreeSpace() :bool;

	public function successToWriteContent() :bool;

	public function getFilePath() :string;

	public function startHandle();

	public function successToStartHandle() :bool;
	
}
