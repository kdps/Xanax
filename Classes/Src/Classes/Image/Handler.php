<?php

declare(strict_types = 1);

namespace Xanax\Classes\Image;

use Xanax\Implement\ImageHandlerInterface;

class ImageHandler implements ImageHandlerInterface {
	
	//http://www.php.net/manual/en/function.imagecreatefromgif.php#104473
	public function isAnimated ($filename) {
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
	
	public function drawRepeat ($imageResource, $width, $height) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		$width = $width || $this->getWidth($imageResource);
		$height = $height || $this->getHeight($imageResource);
		
		imagesettile($imageResource, $image);
		imagefilledrectangle($imageResource, 0, 0, $width, $height, IMG_COLOR_TILED);
	}
	
	/**
	 * Draw eclipse to image resource
	 *
	 * @param resource $imageResource
	 * @param int      $width
	 * @param int      $height
	 * @param int      $x
	 * @param int      $y
	 * @param int      $reg
	 * @param int      $green
	 * @param int      $blue
	 *
	 * @return resource
	 */
	public function drawEclipse ($imageResource, $width, $height, $x, $y, $red, $green, $blue) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		$backgroundColor = imagecolorallocate($imageResource, $red, $green, $blue);
		$outputImage = imagefilledellipse($imageResource, $x, $y, $width, $height, $backgroundColor);
		return $outputImage;
	}
	
	public function Combine ( $paletteImage, $combineImage, $right = 0, $top = 0) {
		if ( !$this->isResource($paletteImage) ) {
			$paletteImage = $this->getInstance( $paletteImage );
		}
		
		if ( !$this->isResource($combineImage) ) {
			$combineImage = $this->getInstance( $combineImage );
		}
		
		$x = imagesx($paletteImage) - imagesx($combineImage) - $right;
		$y = imagesy($paletteImage) - imagesy($combineImage) - $top;
		imagecopy($paletteImage, $combineImage, $x, $y, 0, 0, imagesx($combineImage), imagesy($combineImage));

		return $paletteImage;
	}
	
	/**
	 * Ratio resize to specific size
	 *
	 * @param resource $imageResource
	 * @param int      $resizeWidth
	 * @param int      $resizeHeight
	 *
	 * @return resource
	 */
	public function ratioResize ($imageResource, $resizeWidth, $resizeHeight) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		list($origin_width, $origin_height) = getimagesize($src);
		$ratio = $origin_width / $origin_height;
		$resizeWidth = $resizeHeight = min($resizeWidth, max($origin_width, $origin_height));
		
		if ($ratio < 1) {
			$resizeWidth = $thumbnail_height * $ratio;
		} else {
			$resizeHeight = $thumbnail_width / $ratio;
		}
		
		$outputImage = imagecreatetruecolor($resizeWidth, $resizeHeight);
		
		$width = $this->getWidth($imageResource);
		$height = $this->getHeight($imageResource);
		
		//make image alpha
		imageAlphaBlending($outputImage, false);
		imageSaveAlpha($outputImage, false);

		imagecopyresampled($outputImage, $imageResource, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $width, $height);
		
		return $outputImage;
	}
	
	/**
	 * Apply specific filter to image resource
	 *
	 * @param resource $imageResource
	 * @param resource $type
	 * @param resource $args1
	 * @param resource $args2
	 * @param resource $args3
	 *
	 * @return output stream
	 */
	
	// TODO get a args by array data
	public function FIlter ($imageResource, $type, $args1 = '', $args2 = '', $args3 = '') {
		
		$type = strtolower($type);
		
		if ($type=='reverse') {
			imagefilter($imageResource, IMG_FILTER_NEGATE);
		} else if ($type=='gray') {
			imagefilter($imageResource, IMG_FILTER_GRAYSCALE);
		} else if ($type=='edge') {
			imagefilter($imageResource, IMG_FILTER_EDGEDETECT);
		} else if ($type=='emboss') {
			imagefilter($imageResource, IMG_FILTER_EMBOSS);
		} else if ($type=='gaussian_blur') {
			imagefilter($imageResource, IMG_FILTER_GAUSSIAN_BLUR);
		} else if ($type=='blur') {
			imagefilter($imageResource, IMG_FILTER_SELECTIVE_BLUR);
		} else if ($type=='sketch') {
			imagefilter($imageResource, IMG_FILTER_MEAN_REMOVAL);
		} else if ($type=='brightness') {
			//args1 = Brightness Level
			imagefilter($imageResource, IMG_FILTER_BRIGHTNESS, $args1);
		} else if ($type=='brightness') {
			//args1 = Contrast Level
			imagefilter($imageResource, IMG_FILTER_CONTRAST, $args1);
		} else if ($type=='brightness') {
			//args1 = Smoothness Level
			imagefilter($imageResource, IMG_FILTER_SMOOTH, $args1);
		} else if ($type=='pixelate') {
			//arg1 = Block Size, arg2 = Pixelation Effect Mode
			imagefilter($imageResource, IMG_FILTER_PIXELATE, $args1, $args2);
		} else if ($type=='colorize') {
			//arg1, arg2 & arg3 = red, blue, green / arg4 = alpha channel
			imagefilter($imageResource, IMG_FILTER_COLORIZE, $args1, $args2, $args3);
		}
		
		return $imageResource;
	}
	
	/**
	 * Draw a picture to output
	 *
	 * @param resource $imageResource
	 *
	 * @return output stream
	 */
	public function Draw ( $imageResource ) {
		$format = $this->getType( $imageResource );
		
		switch($format) {
			case 'image/jpeg':
				header("Content-Type: image/jpeg");
				imagejpeg($imageResource);
				break;
			case 'image/png':
				header("Content-Type: image/png");
				imagepng($imageResource);
				break;
			case 'image/bmp':
				header("Content-Type: image/bmp");
				imagebmp($imageResource);
				break;
			case  'image/gif':
				header("Content-Type: image/gif");
				imagegif ($imageResource);
				break;
			case  'image/wbmp':
				header("Content-Type: vnd.wap.wbmp");
				imagewbmp($imageResource);
				break;
			case  'image/webp':
				header("Content-Type: image/webp");
				imagecreatefromwebp($imageResource);
				break;
			case  'image/xbm':
				header("Content-Type: image/xbm");
				imagexbm($imageResource);
				break;
			case  'image/gd':
				header("Content-Type: image/gd");
				imagegd($imageResource);
				break;
			case  'image/gd2':
				header("Content-Type: image/gd2");
				imagegd($imageResource);
				break;
			default:
				break;
		}
	}
	
	
	/**
	 * Pick a color of specific position
	 *
	 * @param resource $imageResource
	 * @param int      $x
	 * @param int      $y
	 *
	 * @return array($alpha, $r, $g, $b)
	 */
	public function pickColor ( $imageResource, $x, $y ) :array {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		//  0xAARRGGBB => 00000001(alpha) 00000010(red) 00000011(green) 00000100(blue)
		$rgb = imagecolorat($imageResource, $x, $y);
		$alpha = ($rgb >>> 24) & 0xFF;
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		
		return array($alpha, $r, $g, $b);
	}
		
	/**
	 * Draw text to image resource
	 *
	 * @param resource $imageResource
	 * @param int      $fontSize
	 * @param int      $x
	 * @param int      $y
	 * @param string   $text
	 * @param int      $reg
	 * @param int      $green
	 * @param int      $blue
	 *
	 * @return mixed
	 */
	public function drawText ( $imageResource, $fontSize, $x, $y, $text, $red, $green, $blue ) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		$textcolor = imagecolorallocate($imageResource, $red, $green, $blue);
		imagestring($imageResource, $fontSize, $x, $y, $text, $textcolor);
		
		return $imageResource;
	}
	
	/**
	 * Get a exif data of image file
	 *
	 * @param string $filePath
	 *
	 * @return mixed
	 */
	public function getExifData ( $filePath ) {
		if (function_exists('exif_read_data')) {
			return exif_read_data($filePath, 0, true);
		}
		
		return new stdClass();
	}
	
	/**
	 * Get type of image file
	 *
	 * @param string $filePath
	 *
	 * @return mixed
	 */
	public function getType ( $filePath ) {
		$finfo = getimagesize($filePath);
		if ($finfo === false) {
			return false;
		}
		
		$format = $finfo['mime'];
		return $format;
	}
	
	/**
	 * Create a image to path
	 *
	 * @param resource $imageResource
	 * @param string   $outputPath
	 * @param int      $quality
	 *
	 * @return boolean
	 */
	public function Create ( $imageResource, $outputPath, $quality = 100 ) {
		$format = $this->getType( $imageResource );
		
		switch ($format) {
			case 'image/jpeg':
				imagejpeg($imageResource, $outputPath, $quality);
				break;
			case  'image/png':
				imagepng($imageResource, $outputPath);
				break;
			case  'image/gif':
				imagegif ($imageResource, $outputPath);
				break;
			case  'image/wbmp':
				imagewbmp($imageResource, $outputPath);
				break;
			case  'image/webp':
				imagecreatefromwebp($imageResource, $outputPath);
				break;
			case  'image/xbm':
				imagexbm($imageResource, $outputPath);
				break;
			case  'image/gd':
				imagegd($imageResource, $outputPath);
				break;
			case  'image/gd2':
				imagegd2($imageResource, $outputPath);
				break;
			default:
				return false;
		}
		
		return true;
	}
	
	/**
	 * Flip a image resource
	 *
	 * @param resource $imageResource
	 *
	 * @return resource
	 */
	public function Flip ( $imageResource ) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		switch($type) {
			case 'vertical':
				imageflip($imageResource, IMG_FLIP_VERTICAL);
				break;
			case 'horizontal':
				imageflip($imageResource, IMG_FLIP_HORIZONTAL);
				break;
			case 'both':
				imageflip($imageResource, IMG_FLIP_BOTH);
				break;
		}
		
		return $imageResource;
	}
	
	/**
	 * Get width of image resource
	 *
	 * @param resource $imageResource
	 *
	 * @return int
	 */
	public function getWidth ( $imageResource ) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
	
		if (function_exists('exif_read_data')) {
			$exifData = exif_read_data($imageResource, 0, true);
			
			if (isset($exifData['COMPUTED'])) {
				$tmp = $exifData['COMPUTED'];
				return $tmp['Width'];
			}
		} else {
			return imagesx($imageResource);
		}
	}
	
	/**
	 * Get height of image resource
	 *
	 * @param resource $imageResource
	 *
	 * @return int
	 */
	public function getHeight ( $imageResource ) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		if (function_exists('exif_read_data')) {
			$exif = exif_read_data($imageResource, 0, true);
			
			if (isset($exif['COMPUTED'])) {
				$tmp = $exif['COMPUTED'];
				return $tmp['Height'];
			}
		} else {
			return imagesy($imageResource);
		}
	}
	
	/**
	 * Check that resource is valid
	 *
	 * @param resource $imageResource
	 *
	 * @return boolean
	 */
	public function isResource ( $imageResource ) {
		if ( gettype($createObject) === 'resource') {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Rotate a image resource
	 *
	 * @param resource $imageResource
	 * @param int $degrees
	 *
	 * @return resource
	 */
	public function Rotate ( $imageResource, $degrees ) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}
		
		$image = imagerotate($imageResource, $degrees, 0);
		
		return $this->getInstance($image);
	}

	/**
	 * Get a resource of file
	 *
	 * @param string $filePath
	 *
	 * @return resource
	 */
	public function getimageResource ( $filePath ) {
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
		} catch(Exception $e) { }
		
		return $createObject;
	}
	
	/**
	 * Get a resource of blank image
	 *
	 * @param int $width
	 * @param int $height
	 * @param int $red
	 * @param int $blue
	 * @param int $green
	 *
	 * @return resource
	 */
	public function getBlank ( $width, $height, $red, $blue, $green ) {
		$image = imagecreatetruecolor($width, $height);
		$background_color = imagecolorallocate($image, $red, $green, $blue);
		imagefilledrectangle($image,0,0,$width,$height,$background_color);
		imagecolortransparent($image, $background_color);
		
		return $this->getInstance($image);
	}
	
	public function Resize ( $sourceImageCreate ) {
		
	}
	
	/**
	 * Merge of two image to palette
	 *
	 * @param resource $sourceCreateObject
	 * @param resource $mergeCreateObject
	 * @param int      $transparent
	 *
	 * @return resource
	 */
	public function Merge ( $sourceCreateObject, $mergeCreateObject, $transparent ) {
		if ( !$this->isResource($sourceCreateObject) ) {
			$sourceCreateObject = $this->getInstance( $sourceCreateObject );
		}
		
		if ( !$this->isResource($mergeCreateObject) ) {
			$mergeCreateObject = $this->getInstance( $mergeCreateObject );
		}
		
		return imagecopymerge($mergeCreateObject, $sourceCreateObject, 0, 0, 0, 0, imagesx($sourceCreateObject), imagesy($sourceCreateObject), $transparent);
	}
	
	/**
	 * Get a singletone of image file
	 *
	 * @param string $filePath
	 *
	 * @return resource
	 */
	public function getInstance ( $filePath ) {
		if ( @is_array(getimagesize( $filePath )) ) {
			return $this->getimageResource($filePath);
		} else {
			$finfo = getImageSize($filePath);
			if ($finfo === false) {
				return false;
			} 
			
			return $filePath;
		}
		
		return new stdClass();
	}
	
	/**
	 * Convert hex to rgb
	 *
	 * @param string $hex
	 *
	 * @return array
	 */
	public function hexToRgb ($hex) {
		$rgb = substr($hex, 2, strlen($hex)-1);
		
		$r = hexdec(substr($rgb,0,2));
		$g = hexdec(substr($rgb,2,2));
		$b = hexdec(substr($rgb,4,2));
		
		return array($r, $g, $b);
	}
	
}
