<?php

declare(strict_types=1);

namespace Xanax\Classes;

class MultiPurposeInternetMailExtensions
{
	private static $extension = '';

	// http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
	
	private $types = [
		/* Mac */
		'hqx' => [
			'type' => 'application/mac-binhex40'
		],
		'cpt' => [
			'type' => 'application/mac-compactpro'
		],
		'cpt' => [
			'type' => 'application/mac-compactpro'
		],
		
		/* Text */

		'markdown' => [
			'type' => 'text/markdown'
		],
		'rtf' => [
			'type' => 'text/rtf'
		],
		'php' => [
			'type' => 'text/html'
		],
		'htm' => [
			'type' => 'text/html'
		],
		'html' => [
			'type' => 'text/html'
		],
		'csv' => [
			'type' => 'text/csv',
			'array' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel')
		],
		'css' => [
			'type' => 'text/css'
		],
		'log' => [
			'type' => 'text/plain'
		],
		'txt' => [
			'type' => 'text/plain'
		],
		'text' => [
			'type' => 'text/plain'
		],
		'ics' => [
			'type' => 'text/calendar'
		],

		/* Image */

		'pnm' => [
			'type' => 'image/x-portable-anymap'
		],
		'tif' => [
			'type' => 'image/tiff'
		],
		'tiff' => [
			'type' => 'image/tiff'
		],
		'gif' => [
			'type' => 'image/gif'
		],
		'png' => [
			'type' => 'image/png'
		],
		'svg' => [
			'type' => 'image/svg+xml'
		],
		'ico' => [
			'type' => 'image/x-icon'
		],
		'webp' => [
			'type' => 'image/webp'
		],
		'bmp' => [
			'type' => 'image/x-bmp'
		],
		'ico' => [
			'type' => 'image/vnd.microsoft.icon'
		],
		'djvu' => [
			'type' => 'image/vnd.djvu'
		],
		'ppm' => [
			'type' => 'image/x-portable-pixmap'
		],
		'xcf' => [
			'type' => 'image/x-xcf'
		],
		'jpg' => [
			'type' => 'image/jpeg',
			'array' => array('image/jpeg', 'image/pjpeg')
		],
		'jpeg' => [
			'type' => 'image/jpeg',
			'array' => array('image/jpeg', 'image/pjpeg')
		],

		/* Video */

		'f4v' => [
			'type' => 'video/x-f4v'
		],
		'fli' => [
			'type' => 'video/x-fli'
		],
		'm4v' => [
			'type' => 'video/x-m4v'
		],
		'mng' => [
			'type' => 'video/x-mng'
		],
		'smv' => [
			'type' => 'video/x-smv'
		],
		'qt' => [
			'type' => 'video/quicktime'
		],
		'mov' => [
			'type' => 'video/quicktime'
		],
		'flv' => [
			'type' => 'video/x-flv'
		],
		'avi' => [
			'type' => 'video/x-msvideo'
		],
		'mpeg' => [
			'type' => 'video/mpeg'
		],
		'webm' => [
			'type' => 'video/webm'
		],
		'ogg' => [
			'type' => 'video/ogg'
		],

		/* Audio */

		'mp3' => [
			'type' => 'audio/mp3',
			'array' => array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3')
		],
		'oga' => [
			'type' => 'audio/ogg'
		],
		'weba' => [
			'type' => 'audio/webm'
		],
		'aac' => [
			'type' => 'audio/aac'
		],
		'wav' => [
			'type' => 'audio/x-wav'
		],
		'mid' => [
			'type' => 'audio/midi'
		],
		'midi' => [
			'type' => 'audio/midi'
		],

		/* Compression */

		'cab' => [
			'type' => 'application/vnd.ms-cab-compressed'
		],
		'gtar' => [
			'type' => 'application/x-gtar'
		],
		'exe' => [
			'type' => 'application/x-msdownload'
		],
		'msi' => [
			'type' => 'application/x-msdownload'
		],
		'tar' => [
			'type' => 'application/x-tar'
		],
		'tgz' => [
			'type' => 'application/x-tar'
		],
		'bz2' => [
			'type' => 'application/x-bzip2'
		],
		'bz' => [
			'type' => 'application/x-bzip'
		],
		'zip' => [
			'type' => 'application/zip',
			'array' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed')
		],
		'arc' => [
			'type' => 'application/octet-stream'
		],
		'rar' => [
			'type' => 'application/x-rar-compressed'
		],
		'7z' => [
			'type' => 'application/x-7z-compressed'
		],

		/* Document */
		
		'word' => [
			'type' => 'application/msword',
			'array' => array('application/msword', 'application/octet-stream')
		],
		'docx' => [
			'type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
		],
		'dotx' => [
			'type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
		],
		'xlsx' => [
			'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		],
		'pptx' => [
			'type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
		],
		
		/* MS Office */
		
		'doc' => [
			'type' => 'application/msword'
		],
		'rtf' => [
			'type' => 'application/rtf'
		],
		'xls' => [
			'type' => 'application/vnd.ms-excel'
		],
		'ppt' => [
			'type' => 'application/vnd.ms-powerpoint'
		],
		'excel' => [
			'type' => 'application/vnd.ms-excel'
		],
		
		/* Adobe */
		
		'pdf' => [
			'type' => 'application/pdf'
		],
		'psd' => [
			'type' => 'application/x-photoshop',
			'array' => array("image/vnd.adobe.photoshop")
		],
		'ai' => [
			'type' => 'application/postscript'
		],
		'eps' => [
			'type' => 'application/postscript'
		],
		'ps' => [
			'type' => 'application/postscript'
		],
		
		/* Open Office */
		
		'odt' => [
			'type' => 'application/vnd.oasis.opendocument.text'
		],
		'ods' => [
			'type' => 'application/vnd.oasis.opendocument.spreadsheet'
		],
		
		/* Font */
		
		'ttf' => [
			'type' => 'application/x-font-ttf'
		],
		
		/* Application */

		'class' => [
			'type' => 'application/octet-stream'
		],
		'yaml' => [
			'type' => 'application/x-yaml,text/yaml'
		],
		'rss' => [
			'type' => 'application/rss+xml'
		],
		'abw' => [
			'type' => 'application/x-abiword'
		],
		'mpkg' => [
			'type' => 'application/vnd.apple.installer+xml'
		],
		'csh' => [
			'type' => 'application/x-csh'
		],
		'jar' => [
			'type' => 'application/java-archive'
		],
		'swf' => [
			'type' => 'application/x-shockwave-flash'
		],
		'azw' => [
			'type' => 'application/vnd.amazon.ebook'
		],
		'binary' => [
			'type' => 'application/octet-stream'
		],
		'json' => [
			'type' => 'application/json',
			'array' => array('application/json', 'text/json')
		],
		'woff' => [
			'type' => 'application/x-font-woff'
		],
		'xhtml' => [
			'type' => 'application/xhtml+xml'
		],
		'xml' => [
			'type' => 'application/xml'
		]
	];

	public function __construct($extension = '')
	{
		if ($extension) {
			self::$extension = $extension;
		}
	}

	public function getFileContentType($filePath)
	{
		return mime_content_type($filePath);
	}

	public function getType($extension = '')
	{
		$type = '';

		if (!$extension && self::$extension) {
			$extension = self::$extension;
		}
		
		if (isset($this->mimeTypes[$extension])) {
			$type = $this->mimeTypes[$extension]['type'];
		}

		return $type;
	}
}
