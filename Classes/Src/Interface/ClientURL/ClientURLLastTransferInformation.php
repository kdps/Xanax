<?php

namespace Xanax\Implement;

interface ClientURLLastTransferInformation {
	
	public function getContentType();
	
	public function getHeaderSize();
	
	public function getUploadedSize();
	
	public function getDownloadedSize();
	
	public function getAverageUploadSpeed();
	
	public function getAverageDownloadSpeed();
	
	public function getUploadContentLength();
	
	public function getDownloadContentLength();
	
	public function getHeaderOutput();
	
	public function getEffectiveURL();
	
	public function getRemoteTime();
	
	public function getStatusCode();
	
	public function getConnectionTime();
	
	public function getPreTransferTime();
	
	public function getStartTransferTime();
	
	public function getRedirectCount();
	
	public function getLastConnectionIPAddress();
	
	public function getLastConnectionPortNumber();
	
	public function getLookupNameTime();
	
	public function getResponseCode();
	
	public function getTotalTransferTime();
	
	public function getCreatedConnectionCount();
	
	public function getRecentReceivedCSeq();
	
	public function getNextRTSPClientCSeq();
	
	public function getAllKnownCookies();
	
	public function getConnectCode();
	
	public function getLastConnectFailureErrorNumber();
	
}
