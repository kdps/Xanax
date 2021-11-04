<?php

declare(strict_types=1);

namespace Xanax\Classes;

class ClientURLLastTransferInformation {
	
	private static $session;

	public function __construct($session) {
		self::$session = $session;
	}

	private function getInformation($key)
	{
		return curl_getinfo(self::$session, $key);
	}

	/**
	 * Get Content-Type
	 *
	 * @return mixed
	 */
	public function getContentType() {
		return $this->getInformation(CURLINFO_CONTENT_TYPE);
	}

	/**
	 * Get size of retrieved headers
	 *
	 * @return mixed
	 */
	public function getHeaderSize() {
		return $this->getInformation(CURLINFO_HEADER_SIZE);
	}

	/**
	 * Get the number of uploaded bytes
	 *
	 * @return mixed
	 */
	public function getUploadedSize() {
		return $this->getInformation(CURLINFO_SIZE_UPLOAD);
	}

	/**
	 * Get the number of downloaded bytes
	 *
	 * @return mixed
	 */
	public function getDownloadedSize() {
		return $this->getInformation(CURLINFO_SIZE_DOWNLOAD);
	}

	/**
	 * Get the number of uploaded bytes
	 *
	 * @return mixed
	 */
	public function getAverageUploadSpeed() {
		return $this->getInformation(CURLINFO_SPEED_UPLOAD);
	}

	/**
	 * Get download speed
	 *
	 * @return mixed
	 */
	public function getAverageDownloadSpeed() {
		return $this->getInformation(CURLINFO_SPEED_DOWNLOAD);
	}

	/**
	 * Get the specified size of the upload
	 *
	 * @return mixed
	 */
	public function getUploadContentLength() {
		return $this->getInformation(CURLINFO_CONTENT_LENGTH_UPLOAD);
	}

	/**
	 * Get content-length of download
	 *
	 * @return mixed
	 */
	public function getDownloadContentLength() {
		return $this->getInformation(CURLINFO_CONTENT_LENGTH_DOWNLOAD);
	}

	public function getSSLVerifyResult() {
		return $this->getInformation(CURLINFO_SSL_VERIFYRESULT);
	}

	public function getHeaderOutput() {
		return $this->getInformation(CURLINFO_HEADER_OUT);
	}

	/**
	 * Get last effective URL
	 *
	 * @return mixed
	 */
	public function getEffectiveURL() {
		return $this->getInformation(CURLINFO_EFFECTIVE_URL);
	}

	/**
	 * Get the remote time of the retrieved document
	 *
	 * @return mixed
	 */
	public function getRemoteTime() {
		return $this->getInformation(CURLINFO_FILETIME);
	}

	public function getStatusCode() {
		return $this->getInformation(CURLINFO_HTTP_CODE);
	}

	/**
	 * Get the time until connect
	 *
	 * @return mixed
	 */
	public function getConnectionTime() {
		return $this->getInformation(CURLINFO_CONNECT_TIME);
	}

	/**
	 * Get the time until the file transfer start
	 *
	 * @return mixed
	 */
	public function getPreTransferTime() {
		return $this->getInformation(CURLINFO_PRETRANSFER_TIME);
	}

	/**
	 * Get the time until the first byte is received
	 *
	 * @return mixed
	 */
	public function getStartTransferTime() {
		return $this->getInformation(CURLINFO_STARTTRANSFER_TIME);
	}

	public function getRedirectTime()
	{
		return $this->getInformation(CURLINFO_REDIRECT_TIME);
	}

	/**
	 * Get the number of redirects
	 *
	 * @return mixed
	 */
	public function getRedirectCount() {
		return $this->getInformation(CURLINFO_REDIRECT_COUNT);
	}

	/**
	 * Get IP address of last connection
	 *
	 * @return mixed
	 */
	public function getLastConnectionIPAddress() {
		return $this->getInformation(CURLINFO_PRIMARY_IP);
	}

	/**
	 * Get the latest destination port number
	 *
	 * @return mixed
	 */
	public function getLastConnectionPortNumber() {
		return $this->getInformation(CURLINFO_PRIMARY_IP);
	}

	/**
	 * Get the name lookup time
	 *
	 * @return mixed
	 */
	public function getLookupNameTime() {
		return $this->getInformation(CURLINFO_NAMELOOKUP_TIME);
	}

	/**
	 * Get the last response code
	 *
	 * @return mixed
	 */
	public function getResponseCode() {
		return $this->getInformation(CURLINFO_RESPONSE_CODE);
	}

	public function getRequestSize() {
		return $this->getInformation(CURLINFO_REQUEST_SIZE);
	}

	public function getPrimaryPort()
	{
		return $this->getInformation(CURLINFO_PRIMARY_PORT);
	}

	public function getPrimaryIP()
	{
		return $this->getInformation(CURLINFO_PRIMARY_IP);
	}

	public function getLocalPort()
	{
		return $this->getInformation(CURLINFO_LOCAL_PORT);
	}

	public function getLocalIP()
	{
		return $this->getInformation(CURLINFO_LOCAL_IP);
	}

	/**
	 * Get total time of previous transfer
	 *
	 * @return mixed
	 */
	public function getTotalTransferTime() {
		return $this->getInformation(CURLINFO_TOTAL_TIME);
	}

	/**
	 * Get number of created connections
	 *
	 * @return mixed
	 */
	public function getCreatedConnectionCount() {
		return $this->getInformation(CURLINFO_NUM_CONNECTS);
	}

	/**
	 * Get the recently received CSeq
	 *
	 * @return mixed
	 */
	public function getRecentReceivedCSeq() {
		return $this->getInformation(CURLINFO_RTSP_CSEQ_RECV);
	}

	/**
	 * Get the next RTSP client CSeq
	 *
	 * @return mixed
	 */
	public function getNextRTSPClientCSeq() {
		return $this->getInformation(CURLINFO_RTSP_CLIENT_CSEQ);
	}

	public function getFTPServerEntryPath() {
		return $this->getInformation(CURLINFO_FTP_ENTRY_PATH);
	}

	/**
	 * Get all known cookies
	 *
	 * @return mixed
	 */
	public function getAllKnownCookies() {
		return $this->getInformation(CURLINFO_COOKIELIST);
	}

	/**
	 * Get the CONNECT response code
	 *
	 * @return mixed
	 */
	public function getConnectCode() {
		return $this->getInformation(CURLINFO_HTTP_CONNECTCODE);
	}

	/**
	 * Get errno number from last connect failure
	 *
	 * @return mixed
	 */
	public function getLastConnectFailureErrorNumber() {
		return $this->getInformation(CURLINFO_OS_ERRNO);
	}
	
}
