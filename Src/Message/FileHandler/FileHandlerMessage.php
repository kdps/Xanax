<?php
namespace Xanax\Message\FileHandler;

class FileHandlerMessage {
	
	public static function getTargetIsNotFileMessage () {
		return "Target is not File";
	}
	
	public static function getDoNotUseSubDirectorySyntaxMessage () {
		return "Don't use Subdirectory syntax";
	}
	
	public static function getDoNotUsePharProtocolMessage () {
		return "Don't use Phar protocol";
	}
	
	public static function getFileIsNotExistsMessage () {
		return "File doesn't Exist";
	}
	
}