<?php


declare(strict_types=1);

namespace Xanax\Classes;

class File extends Header 
{
	
	public function Response($value)
	{
		$parent->Response('Content-Type', $value);
	}
	
	public function responseWithCharset($application, $charSet)
	{
		$charSet = Array("charset" => $charSet);
		$parent->responseWithKeyAndArray($application, $charSet);
	}
	
	public function responseWithOption($application, $charSet) {
		if ($charSet) {
			$this->responseWithCharset($application, $charSet);
		} else {
			$this->Response('application/zip; charset=UTF-8');
		}
	}
	
	public static function fileZip($charSet = 'UTF-8')
	{
		$this->responseWithOption("application/zip", $charSet);
	}

	public static function fileXml($charSet = 'UTF-8')
	{
		$this->responseWithOption("text/xml", $charSet);
	}

	public static function fileJson($charSet = 'UTF-8')
	{
		$this->responseWithOption("application/json", $charSet);
	}

	public static function filePdf($charSet = 'UTF-8'
	{
		$this->responseWithOption("application/pdf", $charSet);
	}

	public static function fileGif($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/gif", $charSet);
	}

	public static function fileJpeg($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/jpeg", $charSet);
	}

	public static function fileJpg($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/jpg", $charSet);
	}

	public static function filePng($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/png", $charSet);
	}
				       
	public static function fileJavascript($charSet = 'UTF-8')
	{
		$this->responseWithOption("text/javascript", $charSet);
	}
}
