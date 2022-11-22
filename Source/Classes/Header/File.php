<?php


declare(strict_types=1);

namespace Xanax\Classes;

class File extends Header
{

	public function Response($value)
	{
		parent::Response('Content-Type', $value);
	}

	public function responseWithCharset($application, $charSet)
	{
		$charSet = Array("charset" => $charSet);
		parent::responseWithKeyAndArray($application, $charSet);
	}

	public function responseWithOption($application, $charSet) {
		if ($charSet) {
			$this->responseWithCharset($application, $charSet);
		} else {
			$this->Response('application/zip; charset=UTF-8');
		}
	}

	public function fileZip($charSet = 'UTF-8')
	{
		$this->responseWithOption("application/zip", $charSet);
	}

	public function fileXml($charSet = 'UTF-8')
	{
		$this->responseWithOption("text/xml", $charSet);
	}

	public function fileJson($charSet = 'UTF-8')
	{
		$this->responseWithOption("application/json", $charSet);
	}

	public function filePdf($charSet = 'UTF-8')
	{
		$this->responseWithOption("application/pdf", $charSet);
	}

	public function fileGif($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/gif", $charSet);
	}

	public function fileJpeg($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/jpeg", $charSet);
	}

	public function fileJpg($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/jpg", $charSet);
	}

	public function filePng($charSet = 'UTF-8')
	{
		$this->responseWithOption("image/png", $charSet);
	}

	public function fileJavascript($charSet = 'UTF-8')
	{
		$this->responseWithOption("text/javascript", $charSet);
	}
}
