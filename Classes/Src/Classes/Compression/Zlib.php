<?php

namespace Xanax\Classes;

class Zlib {
	
	public function Uncompress ( $filePath, $destination ) {
		if(is_file($filePath) && file_exists($filePath) && filesize($filePath) > 0) {
			$fileHandler = fopen($filePath, 'rb'); 
			
			if($fp) {
				$uncompresscontents = fread($fileHandler, filesize($filePath));  
				fclose($fileHandler);  

				$uncompressing = gzuncompress($uncompresscontents);  

				if($uncompressing) {
					$fileHandler = fopen($destination, 'wb');  
					fwrite($fileHandler, $uncompressing);  
					fclose($fileHandler);
				}
			} else {
				fclose($fp);
				
				return false;
			}
		}
	}
	
	public function Compress ( $filePath, $destination ) {
		$fp = fopen($filePath, 'rb');  
		$compresscontents = fread($fp, filesize($filePath));  
		fclose($fp);  

		$compressing = gzcompress($compresscontents);  

		if($compressing) {
			$fp = fopen($destination, 'wb');  
			fwrite($fp, $compressing);  
			fclose($fp);
		}
	}
}