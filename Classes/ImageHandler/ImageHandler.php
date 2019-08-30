<?php

class ImageHandler {
	
	//http://www.php.net/manual/en/function.imagecreatefromgif.php#104473
	public function is_animated_gif ($filename) {
		if (!($fh = @fopen($filename, 'rb'))) {
			return false;
		}
		
		$count = 0;
		// an animated gif contains multiple "frames", with each frame having a
		// header made up of:
		// * a static 4-byte sequence (\x00\x21\xF9\x04)
		// * 4 variable bytes
		// * a static 2-byte sequence (\x00\x2C) (some variants may use \x00\x21 ?)

		// We read through the file til we reach the end of the file, or we've found
		// at least 2 frame headers
		while (!feof($fh) && $count < 2) {
			$chunk = fread($fh, 1024 * 100); //read 100kb at a time
			$count += preg_match_all(
				'#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s',
				$chunk,
				$matches
			);
		}

		fclose($fh);
		return $count > 1;
	}
	
	public function getExifData ( $filePath ) {
		return exif_read_data($filePath, 0, true);
	}
	
	public function getType ( $filePath ) {
		$finfo = getimagesize($filePath);
		if ($finfo === false) {
			return false;
		}
		
		$format = $finfo['mime'];
		return $format;
	}
	
	public function Create ( $filePath, $outputPath, $quality = 100 ) {
		$format = $this->getType( $filePath );
		
		switch ($format) {
			case 'image/jpeg':
				imagejpeg($filePath, $outputPath, $quality);
				break;
			case  'image/png':
				imagepng($filePath, $outputPath);
				break;
			case  'image/gif':
				imagegif ($filePath, $outputPath);
				break;
			case  'image/wbmp':
				imagewbmp($filePath, $outputPath);
				break;
			case  'image/webp':
				imagecreatefromwebp($filePath, $outputPath);
				break;
			case  'image/xbm':
				imagexbm($filePath, $outputPath);
				break;
			case  'image/gd':
				imagegd($filePath, $outputPath);
				break;
			case  'image/gd2':
				imagegd2($filePath, $outputPath);
				break;
			default:
				return false;
		}
	}
	
	public function getHeight ( $createInstance ) {
		if (function_exists('exif_read_data')) {
			$exif = exif_read_data($source_image, 0, true);
			if (isset($exif['COMPUTED'])) {
				$tmp = $exif['COMPUTED'];
				return $tmp['Height'];
			}
		} else {
			return $imagesy($source_image);
		}
	}
	
	public function Rotate ( $createInstance, $degrees ) {
		$image = imagerotate($createInstance, $degrees, 0);
		
		return $this->getInstance($image);
	}
	
	public function getCreateInstance ( $filePath ) {
		$format = $this->getType( $filePath );
		$createObject = null;
		
		try {
			switch ($format) {
				case 'image/jpeg':
					if (extension_loaded('gd')) {
						$createObject = imagecreatefromjpeg($filePath);
					}
					break;
				case 'image/bmp':
					$createObject = imagecreatefrombmp($filePath);
					break;
				case 'image/png':
					if (extension_loaded('gd')) {
						$createObject = imagecreatefrompng($filePath);
					}
					break;
				case 'image/gif':
					if (extension_loaded('gd')) {
						$createObject = imagecreatefromgif ($filePath);
					}
					break;
				case 'image/webp':
					if (extension_loaded('gd')) {
						$createObject = imagecreatefromwebp($filePath);
					}
					break;
				default:
					return false;
			}
		} catch(Exception $e) {
		}
		
		return $createObject;
	}
	
	public function getBlank ($width, $height, $red, $blue, $green) {
		$image = imagecreatetruecolor($width, $height);
		$background_color = imagecolorallocate($image, $red, $green, $blue);
		imagefilledrectangle($image,0,0,$width,$height,$background_color);
		imagecolortransparent($image, $background_color);
		
		return $this->getInstance($image);
	}
	
	public function Resize ( $sourceImageCreate ) {
		
	}
	
	public function Merge ( $sourceCreateObject, $mergeCreateObject, $transparent ) {
		return imagecopymerge($mergeCreateObject, $sourceCreateObject, 0, 0, 0, 0, imagesx($sourceCreateObject), imagesy($sourceCreateObject), $transparent);
	}
	
	public function getInstance ( $filePath ) {
		if ( @is_array(getimagesize( $filePath )) ) {
			return $this->getCreateInstance($filePath);
		}
		
		return new stdClass();
	}
	
	public function hexToRgb ($hex) {
		$rgb = substr($hex, 2, strlen($hex)-1);
		
		$r = hexdec(substr($rgb,0,2));
		$g = hexdec(substr($rgb,2,2));
		$b = hexdec(substr($rgb,4,2));
		
		return array($r, $g, $b);
	}
	
}