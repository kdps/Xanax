<?php

declare(strict_types=1);

namespace Xanax\Classes;

class MIME
{
	
	private static $extension = '';
	
	private $mimeTypes = [
	
		/* Text */
	
		'html' => [
			'mimeType' => 'text/html'
		],
		'csv' => [
			'mimeType' => 'text/csv'
		],
		'css' => [
			'mimeType' => 'text/css'
		],
		'text' => [
			'mimeType' => 'text/plain'
		],
		'ics' => [
			'mimeType' => 'text/calendar'
		],
		
		/* Image */
	
		'tif' => [
			'mimeType' => 'image/tiff'
		],
		'tiff' => [
			'mimeType' => 'image/tiff'
		],
		'gif' => [
			'mimeType' => 'image/gif'
		],
		'png' => [
			'mimeType' => 'image/png'
		],
		'svg' => [
			'mimeType' => 'image/svg+xml'
		],
		'ico' => [
			'mimeType' => 'image/x-icon'
		],
		'webp' => [
			'mimeType' => 'image/webp'
		],
		'bmp' => [
			'mimeType' => 'image/x-bmp'
		],
		'djvu' => [
			'mimeType' => 'image/vnd.djvu'
		],
		'ppm' => [
			'mimeType' => 'image/x-portable-pixmap'
		],
		'xcf' => [
			'mimeType' => 'image/x-xcf'
		],
		
		/* Video */
		
		'avi' => [
			'mimeType' => 'video/x-msvideo'
		],
		'mpeg' => [
			'mimeType' => 'video/mpeg'
		],
		'webm' => [
			'mimeType' => 'video/webm'
		],
		'ogg' => [
			'mimeType' => 'video/ogg'
		],
		
	
		/* Audio */
		
		'oga' => [
			'mimeType' => 'audio/ogg'
		],
		'weba' => [
			'mimeType' => 'audio/webm'
		],
		'aac' => [
			'mimeType' => 'audio/aac'
		],
		'wav' => [
			'mimeType' => 'audio/x-wav'
		],
		'mid' => [
			'mimeType' => 'audio/midi'
		],
		'midi' => [
			'mimeType' => 'audio/midi'
		],
		
		/* Compression */
		
		'tar' => [
			'mimeType' => 'application/x-tar'
		],
		'bz2' => [
			'mimeType' => 'application/x-bzip2'
		],
		'bz' => [
			'mimeType' => 'application/x-bzip'
		],
		'zip' => [
			'mimeType' => 'application/zip'
		],
		'arc' => [
			'mimeType' => 'application/octet-stream'
		],
		'rar' => [
			'mimeType' => 'application/x-rar-compressed'
		],
		'7z' => [
			'mimeType' => 'application/x-7z-compressed'
		],
		
		/* Application */
		
		'abw' => [
			'mimeType' => 'application/x-abiword'
		],
		'mpkg' => [
			'mimeType' => 'application/vnd.apple.installer+xml'
		],
		'csh' => [
			'mimeType' => 'application/x-csh'
		],
		'jar' => [
			'mimeType' => 'application/java-archive'
		],
		'pdf' => [
			'mimeType' => 'application/pdf'
		],
		'ttf' => [
			'mimeType' => 'application/x-font-ttf'
		],
		'swf' => [
			'mimeType' => 'application/x-shockwave-flash'
		],
		'odt' => [
			'mimeType' => 'application/vnd.oasis.opendocument.text'
		],
		'excel' => [
			'mimeType' => 'application/vnd.ms-excel'
		],
		'azw' => [
			'mimeType' => 'application/vnd.amazon.ebook'
		],
		'binary' => [
			'mimeType' => 'application/octet-stream'
		],
		'json' => [
			'mimeType' => 'application/json'
		],
		'woff' => [
			'mimeType' => 'application/x-font-woff'
		],
		'xhtml' => [
			'mimeType' => 'application/xhtml+xml'
		],
		'ppt' => [
			'mimeType' => 'application/vnd.ms-powerpoint'
		],
		'xml' => [
			'mimeType' => 'application/xml'
		]
	];
	
	public function __construct($extension = '')
	{
		if ( $extension ) {
			self::$extension = $extension;
		}
	}
	
	public function getFileType()
	{
		return mime_content_type();
	}
	
	public function getType($extension = '')
	{
		$mimeType = '';
		
		if ( isset( $this->mimeTypes[ $extension ] ) ) {
			$mimeType = $this->mimeTypes[ $extension ][ 'mimeType' ];
		}
		
		return $mimeType;
	}
	
}