<?php
namespace Xanax\Message\FileHandler;

class FileHandlerMessage {
	
	public static function getTargetIsNotFileMessage () {
		return "Target is not File";
	}
	
	public static function getDoNotUseSubDirectorySyntaxMessage () {
		return "Do not use SubDirectory Syntax stupid, do you have a Intellectual disability?";
	}
	
	public static function getDoNotUsePharProtocolMessage () {
		return "Do not use Phar protocol on this function";
	}
	
	public static function getFileIsNotExistsMessage () {
		return "File is not Exists, use isExists function";
	}
	
}