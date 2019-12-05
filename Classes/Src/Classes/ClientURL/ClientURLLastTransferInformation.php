<?php

declare(strict_types=1);

namespace Xanax\Classes;

class ClientURLLastTransferInformation
{
	private static $session;

	public function __construct($session = '')
	{
		self::$session = $session;
	}

	/**
	 * Get Content-Type
	 *
	 * @return mixed
	 */
	public function getContentType()
	{
		return curl_getinfo(self::$session, CURLINFO_CONTENT_TYPE);
	}

	/**
	 * Get size of retrieved headers
	 *
	 * @return mixed
	 */
	public function getHeaderSize()
	{
		return curl_getinfo(self::$session, CURLINFO_HEADER_SIZE);
	}

	/**
	 * Get the number of uploaded bytes
	 *
	 * @return mixed
	 */
	public function getUploadedSize()
	{
		return curl_getinfo(self::$session, CURLINFO_SIZE_UPLOAD);
	}

	/**
	 * Get the number of downloaded bytes
	 *
	 * @return mixed
	 */
	public function getDownloadedSize()
	{
		return curl_getinfo(self::$session, CURLINFO_SIZE_DOWNLOAD);
	}

	/**
	 * Get the number of uploaded bytes
	 *
	 * @return mixed
	 */
	public function getAverageUploadSpeed()
	{
		return curl_getinfo(self::$session, CURLINFO_SPEED_UPLOAD);
	}

	/**
	 * Get download speed
	 *
	 * @return mixed
	 */
	public function getAverageDownloadSpeed()
	{
		return curl_getinfo(self::$session, CURLINFO_SPEED_DOWNLOAD);
	}

	/**
	 * Get the specified size of the upload
	 *
	 * @return mixed
	 */
	public function getUploadContentLength()
	{
		return curl_getinfo(self::$session, CURLINFO_CONTENT_LENGTH_UPLOAD);
	}

	/**
	 * Get content-length of download
	 *
	 * @return mixed
	 */
	public function getDownloadContentLength()
	{
		return curl_getinfo(self::$session, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
	}

	public function getHeaderOutput()
	{
		return curl_getinfo(self::$session, CURLINFO_HEADER_OUT);
	}

	public function getStatusCode()
	{
		return curl_getinfo(self::$session, CURLINFO_HTTP_CODE);
	}
}
