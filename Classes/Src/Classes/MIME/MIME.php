<?php

declare(strict_types=1);

namespace Xanax\Classes;

class MIME
{
	
	private static $extension = '';
	
	// https://doc.wikimedia.org/mediawiki-core/master/php/MimeAnalyzer_8php_source.html
	private $mimeTypes = [
		'pdf' => [
				'mimeType' => 'application/pdf'
			]
	];
	
	public function __construct($extension = '')
	{
		if ($extension) {
			self::$extension = $extension;
		}
	}
	
	public function getFileType()
	{
		return mime_content_type();
	}
	
	public function getType($extension = '')
	{
		if (!$extension && !self::$extension) {
			$extension = self::$extension;
		}
		
		$mimeType = '';
		
		// https://developer.mozilla.org/ko/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Complete_list_of_MIME_types
		switch ($extension) {
			case 'aac':
				$mimeType = 'audio/aac';
				break;
			case 'arc':
				$mimeType = 'application/octet-stream';
				break;
			case 'zip':
				$mimeType = 'application/zip';
				break;
			case 'swf':
				$mimeType = 'application/x-shockwave-flash';
				break;
			case 'ttf':
				$mimeType = 'application/x-font-ttf';
				break;
			case 'svg':
				$mimeType = 'image/svg+xml';
				break;
			case 'odt':
				$mimeType = 'application/vnd.oasis.opendocument.text';
				break;
			case 'wav':
				$mimeType = 'audio/x-wav';
				break;
			case 'excel':
				$mimeType = 'application/vnd.ms-excel';
				break;
			case 'rar':
				$mimeType = 'application/x-rar-compressed';
				break;
			case 'azw':
				$mimeType = 'application/vnd.amazon.ebook';
				break;
			case '7z':
				$mimeType = 'application/x-7z-compressed';
				break;
			case 'xml':
				$mimeType = 'application/xml';
				break;
			case 'json':
				$mimeType = 'application/json';
				break;
			case 'binary':
				$mimeType = 'application/octet-stream';
				break;
			case 'png':
				$mimeType = 'image/png';
				break;
			case 'gif':
				$mimeType = 'image/gif';
				break;
			case 'text':
				$mimeType = 'text/plain';
				break;
			case 'pdf':
				$mimeType = 'application/pdf';
				break;
			default:
				$mimeType = $applicationType;
				break;
		}
		
		return $mimeType;
	}
	
}