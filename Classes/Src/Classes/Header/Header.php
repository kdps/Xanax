<?php

declare(strict_types = 1);

namespace Xanax\Classes;

class Header {
	
	public function Location ( $location ) {
		header(sprintf("Location: %s", $location));
	}
	
	public static function noCache() {
		header('Cache-Control: no-cache');
	}
	
	public static function fileAttachment ( $fileName ) {
		header("Content-Disposition: attachment; filename=$fileName");
	}
	
	public static function binaryEncoding(){
		header("Content-Transfer-Encoding: binary"); 
	}
	
	public static function fileZip(){
		header("Content-Type: application/zip; charset=UTF-8");
	}
	
	public static function fileXml(){
		header("Content-Type: text/xml; charset=UTF-8");
	}
	
	public static function fileJson(){
		header('Content-Type: application/json');
	}
	
	public static function filePdf(){
		header('Content-Type: application/pdf');
	}
	
	public static function fileGif(){
		header('Content-Type: image/gif');
	}
	
	public static function fileJpeg(){
		header( "Content-type: image/jpeg");
	}
	
	public static function fileJpg(){
		header("Content-type: image/jpg");
	}
	
	public static function filePng(){
		header("Content-type: image/png");
	}
	
	public static function fileHtml(){
		header("Content-Type: text/html; charset=UTF-8");
	}
	
	public static function fileJavascript(){
		header("Content-Type: text/javascript; charset=UTF-8");
	}
	
}