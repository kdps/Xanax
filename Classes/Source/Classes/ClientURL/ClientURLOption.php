<?php

declare(strict_types=1);

namespace Xanax\Classes;

use Xanax\Implement\ClientURLOptionInterface;

use Xanax\Classes\Format\MultiPurposeInternetMailExtensions as MIME;

use Xanax\Enumeration\HTTPRequestMethod;

class ClientURLOption implements ClientURLOptionInterface {

	private static $session;

	private static $headerArrayData = [];

	public function __construct(\CurlHandle $session) {
		self::$session = $session;
	}

	public function returnContext() {
		return $this;
	}

	public function disableCache(bool $bool) {
		curl_setopt(self::$session, CURLOPT_FRESH_CONNECT, $bool);

		return $this->returnContext();
	}

	/**
	 * Provide the URL to use in the request
	 *
	 * @return void
	 */
	public function setURL(string $url) {
		curl_setopt(self::$session, CURLOPT_URL, $url);

		return $this->returnContext();
	}

	/**
	 * Verify the peer's SSL certificate
	 *
	 * @return void
	 */
	public function setSSLVerifypeer(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_SSL_VERIFYPEER, $bool);

		return $this->returnContext();
	}

	/**
	 * Set maximum time the request is allowed to take
	 *
	 * @return void
	 */
	public function setTimeout(bool $timeout = true) {
		curl_setopt(self::$session, CURLOPT_TIMEOUT, $timeout);

		return $this->returnContext();
	}

	/**
	 * Specify data to POST to server
	 *
	 * @return void
	 */
	public function setPostField($fields) {
		curl_setopt(self::$session, CURLOPT_POSTFIELDS, $fields);

		return $this->returnContext();
	}

	/**
	 * Size of POST data pointed to
	 *
	 * @return void
	 */
	public function setPostFieldSize(int $size = 0) {
		curl_setopt(self::$session, CURLOPT_POSTFIELDSIZE, $size);

		return $this->returnContext();
	}

	/**
	 * Follow HTTP 3xx redirects
	 *
	 * @return void
	 */
	public function setFollowLocationHeader(int $size = 0) {
		curl_setopt(self::$session, CURLOPT_FOLLOWLOCATION, $size);

		return $this->returnContext();
	}

	/**
	 * Enable/Disable use of EPSV
	 *
	 * @return void
	 */
	public function setFTPUseEPSV(int $size = 0) {
		curl_setopt(self::$session, CURLOPT_FTP_USE_EPSV, $size);

		return $this->returnContext();
	}

	public function setFileHandler($filePointer) {
		curl_setopt(self::$session, CURLOPT_FILE, $filePointer);

		return $this->returnContext();
	}

	/**
	 * Enable/Disable Global DNS cache
	 *
	 * @return void
	 */
	public function setDnsUseGlobalCache(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_DNS_USE_GLOBAL_CACHE, $bool);

		return $this->returnContext();
	}

	/**
	 * Set HTTP user-agent header
	 *
	 * @return void
	 */
	public function setUserAgent($userAgent = '') {
		curl_setopt(self::$session, CURLOPT_USERAGENT, $userAgent);

		return $this->returnContext();
	}

	public function setAcceptEncoding($encoding = '') {
		curl_setopt(self::$session, CURLOPT_ENCODING, $encoding);

		return $this->returnContext();
	}

	/**
	 * Set contents of HTTP Cookie header
	 *
	 * @return void
	 */
	public function setCookieHeader($cookieData = '') {
		curl_setopt(self::$session, CURLOPT_COOKIE, $cookieData);

		return $this->returnContext();
	}

	/**
	 * Start a new cookie session
	 *
	 * @return void
	 */
	public function useCookieSession(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_COOKIESESSION, $bool);

		return $this->returnContext();
	}

	/**
	 * Maximum connection cache size
	 *
	 * @return void
	 */
	public function setMaximumConnectionCount(bool $maximumConnection = true) {
		curl_setopt(self::$session, CURLOPT_MAXCONNECTS, $maximumConnection);

		return $this->returnContext();
	}

	/**
	 * Automatically update the referer header
	 *
	 * @return void
	 */
	public function setAutoReferer(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_AUTOREFERER, $bool);

		return $this->returnContext();
	}

	/**
	 * Do the download request without getting the body
	 *
	 * @return void
	 */
	public function setBodyEmpty(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_NOBODY, $bool);

		return $this->returnContext();
	}

	public function setConnectionTimeout(bool $timeout = true, bool $useMilliseconds = false) {
		if ($useMilliseconds) {
			return $this->setConnectionTimeoutMilliseconds($timeout);
		} else {
			curl_setopt(self::$session, CURLOPT_CONNECTTIMEOUT, $timeout);

			return $this->returnContext();
		}
	}

	/**
	 * Timeout for the connect phase
	 *
	 * @return void
	 */
	public function setConnectionTimeoutMilliseconds(bool $timeout = true) {
		curl_setopt(self::$session, CURLOPT_CONNECTTIMEOUT_MS, $timeout);

		return $this->returnContext();
	}

	public function setNobody(bool $bool = true) {
		$this->setBodyEmpty($bool);

		return $this->returnContext();
	}

	public function setBinaryTransfer(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_BINARYTRANSFER, $bool);

		return $this->returnContext();
	}

	public function setMaximumUploadSpeed(int $bytePerSeconds = 1000) {
		$this->setMaximumSendSpeed($bytePerSeconds);

		return $this->returnContext();
	}

	/**
	 * Rate limit data upload speed
	 *
	 * @return void
	 */
	public function setMaximumSendSpeed(int $bytePerSeconds = 1000) {
		curl_setopt(self::$session, CURLOPT_MAX_SEND_SPEED_LARGE, $bytePerSeconds);

		return $this->returnContext();
	}

	public function setMaximumDownloadSpeed(int $bytePerSeconds = 1000) {
		$this->setMaximumReceiveSpeed($bytePerSeconds);

		return $this->returnContext();
	}

	/**
	 * Rate limit data download speed
	 *
	 * @return void
	 */
	public function setMaximumReceiveSpeed(int $bytePerSeconds = 1000) {
		curl_setopt(self::$session, CURLOPT_MAX_RECV_SPEED_LARGE, $bytePerSeconds);

		return $this->returnContext();
	}

	public function setHeader(string $key, string $value, bool $overwrite = false) {
		$headerData = [$key, $value];

		if (!$overwrite) {
			array_push(self::$headerArrayData, $headerData);

			curl_setopt(self::$session, CURLOPT_HTTPHEADER, self::$headerArrayData);
		} else {
			curl_setopt(self::$session, CURLOPT_HTTPHEADER, $headerData);
		}

		return $this->returnContext();
	}

	public function setContentType(string $applicationType) {
		$value = '';

		// https://developer.mozilla.org/ko/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Complete_list_of_MIME_types
		$mime     = new MIME($applicationType);
		$mimeType = $mime->getType();

		return $this->setHeader('Content-Type', $mimeType);
	}

	public function setAcceptContentType($contentType) {
		return $this->setHeader('Accept', $contentType);
	}

	public function setXmlContentType() {
		return $this->setAcceptContentType('xml');
	}

	public function setJsonContentType() {
		return $this->setAcceptContentType('json');
	}

	/**
	 * Set custom HTTP headers
	 *
	 * @return void
	 */
	public function setHeaders($headers = []) {
		curl_setopt(self::$session, CURLOPT_HTTPHEADER, $headers);

		return $this->returnContext();
	}

	/**
	 * Set remote port number to work with
	 *
	 * @return void
	 */
	public function setPort(bool $port = true) {
		curl_setopt(self::$session, CURLOPT_PORT, $port);

		return $this->returnContext();
	}

	/**
	 * Request an HTTP POST Method
	 *
	 * @return void
	 */
	public function setPostMethod(bool $bool = true) {
		curl_setopt(self::$session, CURLOPT_POST, $bool);

		return $this->returnContext();
	}

	/**
	 * Request an HTTP Custom Method
	 *
	 * @return void
	 */
	private function setCustomMethod($method) {
		curl_setopt(self::$session, CURLOPT_CUSTOMREQUEST, $method);

		return $this->returnContext();
	}

	/**
	 * Request an HTTP Options Method
	 *
	 * @return void
	 */
	private function setOptionsMethod() {
		return $this->setCustomMethod(HTTPRequestMethod::OPTIONS);
	}

	/**
	 * Request an HTTP Patch Method
	 *
	 * @return void
	 */
	private function setPatchMethod() {
		return $this->setCustomMethod(HTTPRequestMethod::PATCH);
	}

	/**
	 * Request an HTTP Head Method
	 *
	 * @return void
	 */
	private function setHeadMethod() {
		return $this->setCustomMethod(HTTPRequestMethod::HEAD);
	}

	/**
	 * Request an HTTP Put Method
	 *
	 * @return void
	 */
	private function setPutMethod() {
		return $this->setCustomMethod(HTTPRequestMethod::PUT);
	}

	/**
	 * Request an HTTP Delete Method
	 *
	 * @return void
	 */
	private function setDeleteMethod() {
		return $this->setCustomMethod(HTTPRequestMethod::DELETE);
	}

	/**
	 * Request an HTTP GET Method
	 *
	 * @return void
	 */
	public function setGetMethod(bool $bool = true) {
		$this->setPostMethod(!$bool);

		return$this->returnContext();
	}


	public function setReturnTransfer(bool $hasResponse = true) {
		curl_setopt(self::$session, CURLOPT_RETURNTRANSFER, $hasResponse);

		return $this->returnContext();
	}

	/**
	 * Pass headers to the data stream
	 *
	 * @return void
	 */
	public function setReturnHeader(bool $hasResponse = true) {
		curl_setopt(self::$session, CURLOPT_HEADER, $hasResponse);

		return $this->returnContext();
	}

}
