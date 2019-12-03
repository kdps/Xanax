<?php

declare(strict_types=1);

namespace Xanax\Classes;

class ClientURLOption
{
	
	private static $session;
	
	private static $headerArrayData = array();
	
	public function __construct( $session = '' )
	{
		self::$session = $session;
	}
	
	public function setURL($url)
	{
		curl_setopt(self::$session, CURLOPT_URL, $url);
	}
	
	public function setSSLVerifypeer( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_SSL_VERIFYPEER, $bool);
	}
	
	public function setTimeout( $timeout = true )
	{
		curl_setopt (self::$session, CURLOPT_TIMEOUT, $timeout);
	}
	
	public function setPostField( $fields = 0 )
	{
		curl_setopt (self::$session, CURLOPT_POSTFIELDS, $fields);
	}
	
	public function setPostFieldSize( $size = 0 )
	{
		curl_setopt (self::$session, CURLOPT_POSTFIELDSIZE, $size);
	}

	public function setFollowLocationHeader( $size = 0 )
	{
		curl_setopt (self::$session, CURLOPT_FOLLOWLOCATION, $size);
	}

	public function setFTPUseEPSV( $size = 0 )
	{
		curl_setopt (self::$session, CURLOPT_FTP_USE_EPSV, $size);
	}

	public function setDnsUseGlobalCache( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_DNS_USE_GLOBAL_CACHE, $bool);
	}

	public function setUserAgent( $userAgent = '' )
	{
		curl_setopt (self::$session, CURLOPT_USERAGENT, $userAgent);
	}
	
	public function setAcceptEncoding( $encoding = '' )
	{
		curl_setopt (self::$session, CURLOPT_ENCODING, $encoding);
	}

	public function setCookieHeader( $cookieData = '' )
	{
		curl_setopt (self::$session, CURLOPT_COOKIE, $cookieData);
	}

	public function useCookieSession( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_COOKIESESSION, $bool);
	}

	public function setMaximumConnectionCount( $maximumConnection = true )
	{
		curl_setopt (self::$session, CURLOPT_MAXCONNECTS, $maximumConnection);
	}

	public function setAutoReferer( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_AUTOREFERER, $bool);
	}

	public function setEmptyBody( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_NOBODY, $bool);
	}

	public function setConnectionTimeout( $timeout = true, $useMilliseconds = false)
	{
		if ($useMilliseconds) {
			$this->setConnectionTimeoutMilliseconds($timeout);
		} else {
			curl_setopt (self::$session, CURLOPT_CONNECTTIMEOUT, $timeout);
		}
	}

	public function setConnectionTimeoutMilliseconds( $timeout = true )
	{
		curl_setopt (self::$session, CURLOPT_CONNECTTIMEOUT_MS, $timeout);
	}

	public function setNobody( $bool = true )
	{
		$this->setEmptyBody($bool);
	}

	public function setBinaryTransfer( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_BINARYTRANSFER, $bool);
	}

	public function setMaximumUploadSpeed( $bytePerSeconds = 1000 )
	{
		$this->setMaximumSendSpeed($bytePerSeconds);
	}
	
	public function setMaximumSendSpeed( $bytePerSeconds = 1000 )
	{
		curl_setopt (self::$session, CURLOPT_MAX_SEND_SPEED_LARGE , $bytePerSeconds);
	}
	
	public function setMaximumDownloadSpeed( $bytePerSeconds = 1000 )
	{
		$this->setMaximumReceiveSpeed($bytePerSeconds);
	}
	
	public function setMaximumReceiveSpeed( $bytePerSeconds = 1000 )
	{
		curl_setopt (self::$session, CURLOPT_MAX_RECV_SPEED_LARGE, $bytePerSeconds);
	}
	
	public function setHeader( $key, $value, $overwrite = false )
	{
		$headerData = array($key, $value);
			
		if (!$overwrite) {
			array_push(self::$headerArrayData, $headerData);
			
			curl_setopt (self::$session, CURLOPT_HTTPHEADER, self::$headerArrayData);
		} else {
			curl_setopt (self::$session, CURLOPT_HTTPHEADER, $headerData);
		}
		
	}
	
	public function setAcceptContentType($applicationType)
	{
		$key = "";
		
		switch($applicationType) {
			case "xml":
				$key = 'application/xml';
				break;
			case "json":
				$key = 'application/json';
				break;
			default:
				$key = $applicationType;
				break;
		}
		
		$this->setHeader(sprintf('Accept: %s', $key), sprintf('Content-Type: %s', $key));
	}
	
	public function setAcceptXmlContentType()
	{
		$this->setAcceptContentType('xml');
	}
	
	public function setAcceptJsonContentType()
	{
		$this->setAcceptContentType('json');
	}
	
	public function setHeaders( $headers = [] )
	{
		curl_setopt (self::$session, CURLOPT_HTTPHEADER, $headers);
	}
	
	public function setPort( $port = true )
	{
		curl_setopt (self::$session, CURLOPT_PORT, $port);
	}
	
	public function setPostMethod( $bool = true )
	{
		curl_setopt (self::$session, CURLOPT_POST, $bool);
	}

	public function setReturnTransfer( $hasResponse = true )
	{
		curl_setopt (self::$session, CURLOPT_RETURNTRANSFER, $hasResponse);
	}
	
	public function setReturnHeader( $hasResponse = true )
	{
		curl_setopt (self::$session, CURLOPT_HEADER, $hasResponse);
	}
	
}
