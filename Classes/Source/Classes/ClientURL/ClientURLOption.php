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

	private function setOption($key, $value)
	{
		curl_setopt(self::$session, $key, $value);
	}

	public function disableCache(bool $bool) {
		$this->setOption(CURLOPT_FRESH_CONNECT, $bool);

		return $this->returnContext();
	}

	/**
	 * Provide the URL to use in the request
	 *
	 * @return void
	 */
	public function setURL(string $url) {
		$this->setOption(CURLOPT_URL, $url);

		return $this->returnContext();
	}

	public function setForbidenReuse(bool $bool = true) {
		$this->setOption(CURLOPT_FORBID_REUSE, $bool);

		return $this->returnContext();
	}

	/**
	 * Ready to Upload
	 *
	 * @return void
	 */
	public function setUploadReady(bool $bool = true) {
		$this->setOption(CURLOPT_UPLOAD, $bool);

		return $this->returnContext();
	}

	/**
	 * Verify the peer's SSL certificate
	 *
	 * @return void
	 */
	public function setSSLVerifypeer(bool $bool = true) {
		$this->setOption(CURLOPT_SSL_VERIFYPEER, $bool);

		return $this->returnContext();
	}

	/**
	 * Set maximum time the request is allowed to take
	 *
	 * @return void
	 */
	public function setTimeout(bool $timeout = true) {
		$this->setOption(CURLOPT_TIMEOUT, $timeout);

		return $this->returnContext();
	}

	public function setCRLF(bool $timeout = true) {
		$this->setOption(CURLOPT_CRLF, $timeout);

		return $this->returnContext();
	}

	/**
	 * Specify data to POST to server
	 *
	 * @return void
	 */
	public function setPostField($fields) {
		$this->setOption(CURLOPT_POSTFIELDS, $fields);

		return $this->returnContext();
	}

	/**
	 * Size of POST data pointed to
	 *
	 * @return void
	 */
	public function setPostFieldSize(int $size = 0) {
		$this->setOption(\CURLOPT_POSTFIELDSIZE, $size);

		return $this->returnContext();
	}

	/**
	 * Follow HTTP 3xx redirects
	 *
	 * @return void
	 */
	public function setFollowLocationHeader(int $size = 0) {
		$this->setOption(CURLOPT_FOLLOWLOCATION, $size);

		return $this->returnContext();
	}

	/**
	 * Enable/Disable use of EPSV
	 *
	 * @return void
	 */
	public function setFTPUseEPSV(int $size = 0) {
		$this->setOption(CURLOPT_FTP_USE_EPSV, $size);

		return $this->returnContext();
	}

	public function setInterface($interface) {
		$this->setOption(CURLOPT_INTERFACE, $interface);

		return $this->returnContext();
	}

	public function setRange($range) {
		$this->setOption(CURLOPT_RANGE, $range);

		return $this->returnContext();
	}

	public function setProxyAuthentication($authentication) {
		$this->setOption(CURLOPT_PROXYAUTH, $authentication);

		return $this->returnContext();
	}

	public function setProxy($proxy) {
		$this->setOption(CURLOPT_PROXY, $proxy);

		return $this->returnContext();
	}

	public function setProxyUserPassword($password) {
		$this->setOption(CURLOPT_PROXYUSERPWD, $password);

		return $this->returnContext();
	}

	public function setProxyPort($port) {
		$this->setOption(CURLOPT_PROXYPORT, $port);

		return $this->returnContext();
	}

	public function setCookieFile($file) {
		$this->setOption(CURLOPT_COOKIEFILE, $file);

		return $this->returnContext();
	}

	public function setCookieJar($jar) {
		$this->setOption(CURLOPT_COOKIEJAR, $jar);

		return $this->returnContext();
	}

	public function setProxyType($type) {
		$this->setOption(CURLOPT_PROXYTYPE, $type);

		return $this->returnContext();
	}

	public function setFileHandler($filePointer) {
		$this->setOption(CURLOPT_FILE, $filePointer);

		return $this->returnContext();
	}

	public function setProxyTunnel(bool $bool = true) {
		$this->setOption(CURLOPT_HTTPPROXYTUNNEL, $bool);

		return $this->returnContext();
	}

	/**
	 * Verbose
	 *
	 * @return void
	 */
	public function setVerbose(bool $bool = true) {
		$this->setOption(CURLOPT_VERBOSE, $bool);

		return $this->returnContext();
	}

	/**
	 * Enable/Disable Global DNS cache
	 *
	 * @return void
	 */
	public function setDnsUseGlobalCache(bool $bool = true) {
		$this->setOption(CURLOPT_DNS_USE_GLOBAL_CACHE, $bool);

		return $this->returnContext();
	}

	/**
	 * Set HTTP user-agent header
	 *
	 * @return void
	 */
	public function setUserAgent($userAgent = '') {
		$this->setOption(CURLOPT_USERAGENT, $userAgent);

		return $this->returnContext();
	}

	public function setAcceptEncoding($encoding = '') {
		$this->setOption(CURLOPT_ENCODING, $encoding);

		return $this->returnContext();
	}

	/**
	 * Set contents of HTTP Cookie header
	 *
	 * @return void
	 */
	public function setCookieHeader($cookieData = '') {
		$this->setOption(CURLOPT_COOKIE, $cookieData);

		return $this->returnContext();
	}

	/**
	 * Start a new cookie session
	 *
	 * @return void
	 */
	public function useCookieSession(bool $bool = true) {
		$this->setOption(CURLOPT_COOKIESESSION, $bool);

		return $this->returnContext();
	}

	/**
	 * Maximum connection cache size
	 *
	 * @return void
	 */
	public function setMaximumConnectionCount(bool $maximumConnection = true) {
		$this->setOption(CURLOPT_MAXCONNECTS, $maximumConnection);

		return $this->returnContext();
	}

	/**
	 * Automatically update the referer header
	 *
	 * @return void
	 */
	public function setAutoReferer(bool $bool = true) {
		$this->setOption(CURLOPT_AUTOREFERER, $bool);

		return $this->returnContext();
	}

	/**
	 * Do the download request without getting the body
	 *
	 * @return void
	 */
	public function setBodyEmpty(bool $bool = true) {
		$this->setOption(CURLOPT_NOBODY, $bool);

		return $this->returnContext();
	}

	public function setConnectionTimeout(bool $timeout = true, bool $useMilliseconds = false) {
		if ($useMilliseconds) {
			return $this->setConnectionTimeoutMilliseconds($timeout);
		} else {
			$this->setOption(CURLOPT_CONNECTTIMEOUT, $timeout);

			return $this->returnContext();
		}
	}

	/**
	 * Timeout for the connect phase
	 *
	 * @return void
	 */
	public function setConnectionTimeoutMilliseconds(bool $timeout = true) {
		$this->setOption(CURLOPT_CONNECTTIMEOUT_MS, $timeout);

		return $this->returnContext();
	}

	public function setNobody(bool $bool = true) {
		$this->setBodyEmpty($bool);

		return $this->returnContext();
	}

	public function setTransferText(bool $bool = true) {
		$this->setOption(CURLOPT_TRANSFERTEXT, $bool);

		return $this->returnContext();
	}

	public function setBinaryTransfer(bool $bool = true) {
		$this->setOption(CURLOPT_BINARYTRANSFER, $bool);

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
		$this->setOption(CURLOPT_MAX_SEND_SPEED_LARGE, $bytePerSeconds);

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
		$this->setOption(CURLOPT_MAX_RECV_SPEED_LARGE, $bytePerSeconds);

		return $this->returnContext();
	}

	public function setHeader(string $key, string $value, bool $overwrite = false) {
		$headerData = [$key, $value];

		if (!$overwrite) {
			array_push(self::$headerArrayData, $headerData);

			$this->setOption(CURLOPT_HTTPHEADER, self::$headerArrayData);
		} else {
			$this->setOption(CURLOPT_HTTPHEADER, $headerData);
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

	public function setCharset($charset) {
		return $this->setHeader('Charset', $charset);
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
		$this->setOption(CURLOPT_HTTPHEADER, $headers);

		return $this->returnContext();
	}

	/**
	 * Set remote port number to work with
	 *
	 * @return void
	 */
	public function setPort(bool $port = true) {
		$this->setOption(CURLOPT_PORT, $port);

		return $this->returnContext();
	}

	/**
	 * Request an HTTP POST Method
	 *
	 * @return void
	 */
	public function setPostMethod(bool $bool = true) {
		$this->setOption(CURLOPT_POST, $bool);

		return $this->returnContext();
	}

	private function setAnySafeAuthentication() {
		return $this->setAuthentication(CURLAUTH_ANYSAFE);
	}

	private function setAnyAuthentication() {
		return $this->setAuthentication(CURLAUTH_ANY);
	}

	private function setNTLMAuthentication() {
		return $this->setAuthentication(CURLAUTH_NTLM);
	}

	private function setGSSNegotiateAuthentication() {
		return $this->setAuthentication(CURLAUTH_GSSNEGOTIATE);
	}

	private function setDigestAuthentication() {
		return $this->setAuthentication(CURLAUTH_DIGEST);
	}

	private function setAuthentication($authentication) {
		$this->setOption(CURLOPT_HTTPAUTH, $authentication);

		return $this->returnContext();
	}

	private function setCustomMethod($method) {
		$this->setOption(CURLOPT_CUSTOMREQUEST, $method);

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
		$this->setOption(CURLOPT_RETURNTRANSFER, $hasResponse);

		return $this->returnContext();
	}

	/**
	 * Pass headers to the data stream
	 *
	 * @return void
	 */
	public function setReturnHeader(bool $hasResponse = true) {
		$this->setOption(CURLOPT_HEADER, $hasResponse);

		return $this->returnContext();
	}

}
