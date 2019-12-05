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

	/**
	 * Get last effective URL
	 *
	 * @return mixed
	 */
	public function getEffectiveURL()
	{
		return curl_getinfo(self::$session, CURLINFO_EFFECTIVE_URL);
	}

	/**
	 * Get the remote time of the retrieved document
	 *
	 * @return mixed
	 */
	public function getRemoteTime()
	{
		return curl_getinfo(self::$session, CURLINFO_FILETIME);
	}

	public function getStatusCode()
	{
		return curl_getinfo(self::$session, CURLINFO_HTTP_CODE);
	}

	/**
	 * Get the time until connect
	 *
	 * @return mixed
	 */
	public function getConnectionTime()
	{
		return curl_getinfo(self::$session, CURLINFO_CONNECT_TIME);
	}

	/**
	 * Get the time until the file transfer start
	 *
	 * @return mixed
	 */
	public function getPreTransferTime()
	{
		return curl_getinfo(self::$session, CURLINFO_PRETRANSFER_TIME);
	}

	/**
	 * Get the time until the first byte is received
	 *
	 * @return mixed
	 */
	public function getStartTransferTime()
	{
		return curl_getinfo(self::$session, CURLINFO_STARTTRANSFER_TIME);
	}

	/**
	 * Get the number of redirects
	 *
	 * @return mixed
	 */
	public function getRedirectCount()
	{
		return curl_getinfo(self::$session, CURLINFO_REDIRECT_COUNT);
	}

	/**
	 * Get IP address of last connection
	 *
	 * @return mixed
	 */
	public function getLastConnectionIPAddress()
	{
		return curl_getinfo(self::$session, CURLINFO_PRIMARY_IP);
	}

	/**
	 * Get the latest destination port number
	 *
	 * @return mixed
	 */
	public function getLastConnectionPortNumber()
	{
		return curl_getinfo(self::$session, CURLINFO_PRIMARY_IP);
	}

	/**
	 * Get the name lookup time
	 *
	 * @return mixed
	 */
	public function getLookupNameTime()
	{
		return curl_getinfo(self::$session, CURLINFO_NAMELOOKUP_TIME);
	}

	/**
	 * Get the last response code
	 *
	 * @return mixed
	 */
	public function getResponseCode()
	{
		return curl_getinfo(self::$session, CURLINFO_RESPONSE_CODE);
	}

	/**
	 * Get total time of previous transfer
	 *
	 * @return mixed
	 */
	public function getTotalTransferTime()
	{
		return curl_getinfo(self::$session, CURLINFO_TOTAL_TIME);
	}

	/**
	 * Get number of created connections
	 *
	 * @return mixed
	 */
	public function getCreatedConnectionCount()
	{
		return curl_getinfo(self::$session, CURLINFO_NUM_CONNECTS);
	}

	/**
	 * Get the recently received CSeq
	 *
	 * @return mixed
	 */
	public function getRecentReceivedCSeq()
	{
		return curl_getinfo(self::$session, CURLINFO_RTSP_CSEQ_RECV);
	}

	/**
	 * Get the next RTSP client CSeq
	 *
	 * @return mixed
	 */
	public function getNextRTSPClientCSeq()
	{
		return curl_getinfo(self::$session, CURLINFO_RTSP_CLIENT_CSEQ);
	}

	/**
	 * Get all known cookies
	 *
	 * @return mixed
	 */
	public function getAllKnownCookies()
	{
		return curl_getinfo(self::$session, CURLINFO_COOKIELIST);
	}

	/**
	 * Get the CONNECT response code
	 *
	 * @return mixed
	 */
	public function getConnectCode()
	{
		return curl_getinfo(self::$session, CURLINFO_HTTP_CONNECTCODE);
	}
}
