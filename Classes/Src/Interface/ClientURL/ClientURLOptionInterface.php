<?php

namespace Xanax\Implement;

interface ClientURLOptionInterface
{
	public function setURL(string $url);
	
	public function setSSLVerifypeer(bool $bool = true);
	
	public function setTimeout(bool $timeout = true);
	
	public function setPostField(int $fields = 0);
	
	public function setPostFieldSize(int $size = 0);
	
	public function setFollowLocationHeader(int $size = 0) ;
	
	public function setFTPUseEPSV(int $size = 0);
	
	public function setFileHandler($filePointer);
	
	public function setDnsUseGlobalCache(bool $bool = true);
	
	public function setUserAgent($userAgent = '');
	
	public function setAcceptEncoding($encoding = '');
	
	public function setCookieHeader($cookieData = '');
	
	public function useCookieSession(bool $bool = true);
	
	public function setMaximumConnectionCount(bool $maximumConnection = true);
	
	public function setAutoReferer(bool $bool = true);
	
	public function setEmptyBody(bool $bool = true);
	
	public function setConnectionTimeout(bool $timeout = true, bool $useMilliseconds = false);
	
	public function setConnectionTimeoutMilliseconds(bool $timeout = true);
	
	public function setNobody(bool $bool = true);
	
	public function setBinaryTransfer(bool $bool = true);
	
	public function setMaximumUploadSpeed(int $bytePerSeconds = 1000);
	
	public function setMaximumSendSpeed(int $bytePerSeconds = 1000);
	
	public function setMaximumDownloadSpeed(int $bytePerSeconds = 1000);
	
	public function setMaximumReceiveSpeed(int $bytePerSeconds = 1000);
	
	public function setHeader(string $key, string $value, bool $overwrite = false);
	
	public function setAcceptContentType(string $applicationType);
	
	public function setAcceptXmlContentType();
	
	public function setAcceptJsonContentType();
	
	public function setHeaders($headers = []);
	
	public function setPort(bool $port = true);
	
	public function setPostMethod(bool $bool = true);
	
	public function setReturnTransfer(bool $hasResponse = true);
	
	public function setReturnHeader(bool $hasResponse = true);
}