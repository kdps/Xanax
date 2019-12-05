<?php

declare(strict_types=1);

namespace Xanax\Classes;

use Xanax\Implement\ClientURLInterface;

class ClientURLOption interface ClientURLOptionInterface
{
	private static $session;

	private static $headerArrayData = [];

	public function __construct($session = '')
	{
		self::$session = $session;
	}

	/**
	 * Provide the URL to use in the request
	 *
	 * @return void
	 */
	public function setURL(string $url) :void
	{
		curl_setopt(self::$session, CURLOPT_URL, $url);
	}

	/**
	 * Verify the peer's SSL certificate
	 *
	 * @return void
	 */
	public function setSSLVerifypeer(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_SSL_VERIFYPEER, $bool);
	}

	/**
	 * Set maximum time the request is allowed to take
	 *
	 * @return void
	 */
	public function setTimeout(bool $timeout = true) :void
	{
		curl_setopt(self::$session, CURLOPT_TIMEOUT, $timeout);
	}

	/**
	 * Specify data to POST to server
	 *
	 * @return void
	 */
	public function setPostField(int $fields = 0) :void
	{
		curl_setopt(self::$session, CURLOPT_POSTFIELDS, $fields);
	}

	/**
	 * Size of POST data pointed to
	 *
	 * @return void
	 */
	public function setPostFieldSize(int $size = 0) :void
	{
		curl_setopt(self::$session, CURLOPT_POSTFIELDSIZE, $size);
	}

	/**
	 * Follow HTTP 3xx redirects
	 *
	 * @return void
	 */
	public function setFollowLocationHeader(int $size = 0) :void
	{
		curl_setopt(self::$session, CURLOPT_FOLLOWLOCATION, $size);
	}

	/**
	 * Enable/Disable use of EPSV
	 *
	 * @return void
	 */
	public function setFTPUseEPSV(int $size = 0) :void
	{
		curl_setopt(self::$session, CURLOPT_FTP_USE_EPSV, $size);
	}

	public function setFileHandler($filePointer) :void
	{
		curl_setopt(self::$session, CURLOPT_FILE, $filePointer);
	}

	/**
	 * Enable/Disable Global DNS cache
	 *
	 * @return void
	 */
	public function setDnsUseGlobalCache(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_DNS_USE_GLOBAL_CACHE, $bool);
	}

	/**
	 * Set HTTP user-agent header
	 *
	 * @return void
	 */
	public function setUserAgent($userAgent = '') :void
	{
		curl_setopt(self::$session, CURLOPT_USERAGENT, $userAgent);
	}

	public function setAcceptEncoding($encoding = '') :void
	{
		curl_setopt(self::$session, CURLOPT_ENCODING, $encoding);
	}

	/**
	 * Set contents of HTTP Cookie header
	 *
	 * @return void
	 */
	public function setCookieHeader($cookieData = '') :void
	{
		curl_setopt(self::$session, CURLOPT_COOKIE, $cookieData);
	}

	/**
	 * Start a new cookie session
	 *
	 * @return void
	 */
	public function useCookieSession(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_COOKIESESSION, $bool);
	}

	/**
	 * Maximum connection cache size
	 *
	 * @return void
	 */
	public function setMaximumConnectionCount(bool $maximumConnection = true) :void
	{
		curl_setopt(self::$session, CURLOPT_MAXCONNECTS, $maximumConnection);
	}

	/**
	 * Automatically update the referer header
	 *
	 * @return void
	 */
	public function setAutoReferer(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_AUTOREFERER, $bool);
	}

	/**
	 * Do the download request without getting the body
	 *
	 * @return void
	 */
	public function setEmptyBody(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_NOBODY, $bool);
	}

	public function setConnectionTimeout(bool $timeout = true, bool $useMilliseconds = false) :void
	{
		if ($useMilliseconds) {
			$this->setConnectionTimeoutMilliseconds($timeout);
		} else {
			curl_setopt(self::$session, CURLOPT_CONNECTTIMEOUT, $timeout);
		}
	}

	/**
	 * Timeout for the connect phase
	 *
	 * @return void
	 */
	public function setConnectionTimeoutMilliseconds(bool $timeout = true) :void
	{
		curl_setopt(self::$session, CURLOPT_CONNECTTIMEOUT_MS, $timeout);
	}

	public function setNobody(bool $bool = true) :void
	{
		$this->setEmptyBody($bool);
	}

	public function setBinaryTransfer(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_BINARYTRANSFER, $bool);
	}

	public function setMaximumUploadSpeed(int $bytePerSeconds = 1000) :void
	{
		$this->setMaximumSendSpeed($bytePerSeconds);
	}

	/**
	 * Rate limit data upload speed
	 *
	 * @return void
	 */
	public function setMaximumSendSpeed(int $bytePerSeconds = 1000) :void
	{
		curl_setopt(self::$session, CURLOPT_MAX_SEND_SPEED_LARGE, $bytePerSeconds);
	}

	public function setMaximumDownloadSpeed(int $bytePerSeconds = 1000) :void
	{
		$this->setMaximumReceiveSpeed($bytePerSeconds);
	}

	/**
	 * Rate limit data download speed
	 *
	 * @return void
	 */
	public function setMaximumReceiveSpeed(int $bytePerSeconds = 1000) :void
	{
		curl_setopt(self::$session, CURLOPT_MAX_RECV_SPEED_LARGE, $bytePerSeconds);
	}

	public function setHeader(string $key, string $value, bool $overwrite = false) :void
	{
		$headerData = [$key, $value];

		if (!$overwrite) {
			array_push(self::$headerArrayData, $headerData);

			curl_setopt(self::$session, CURLOPT_HTTPHEADER, self::$headerArrayData);
		} else {
			curl_setopt(self::$session, CURLOPT_HTTPHEADER, $headerData);
		}
	}

	public function setAcceptContentType(string $applicationType) :void
	{
		$key = '';

		switch ($applicationType) {
			case 'xml':
				$key = 'application/xml';
				break;
			case 'json':
				$key = 'application/json';
				break;
			default:
				$key = $applicationType;
				break;
		}

		$this->setHeader(sprintf('Accept: %s', $key), sprintf('Content-Type: %s', $key));
	}

	public function setAcceptXmlContentType() :void
	{
		$this->setAcceptContentType('xml');
	}

	public function setAcceptJsonContentType() :void
	{
		$this->setAcceptContentType('json');
	}

	/**
	 * Set custom HTTP headers
	 *
	 * @return void
	 */
	public function setHeaders($headers = []) :void
	{
		curl_setopt(self::$session, CURLOPT_HTTPHEADER, $headers);
	}

	/**
	 * Set remote port number to work with
	 *
	 * @return void
	 */
	public function setPort(bool $port = true) :void
	{
		curl_setopt(self::$session, CURLOPT_PORT, $port);
	}

	/**
	 * Request an HTTP POST
	 *
	 * @return void
	 */
	public function setPostMethod(bool $bool = true) :void
	{
		curl_setopt(self::$session, CURLOPT_POST, $bool);
	}

	public function setReturnTransfer(bool $hasResponse = true) :void
	{
		curl_setopt(self::$session, CURLOPT_RETURNTRANSFER, $hasResponse);
	}

	/**
	 * Pass headers to the data stream
	 *
	 * @return void
	 */
	public function setReturnHeader(bool $hasResponse = true) :void
	{
		curl_setopt(self::$session, CURLOPT_HEADER, $hasResponse);
	}
}
