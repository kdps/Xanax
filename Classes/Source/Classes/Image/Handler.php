<?php

declare(strict_types = 1);

namespace Xanax\Classes\Image;

use Xanax\Implement\ImageHandlerInterface;

use Xanax\Enumeration\Orientation;

use Xanax\Enumeration\ImageFilter;

use Xanax\Enumeration\ExifFileHeader;


class Handler implements ImageHandlerInterface
{

	//http://www.php.net/manual/en/function.imagecreatefromgif.php#104473
	public function isAnimated ($filename)
	{
		if (!($fh = @fopen($filename, 'rb')))
		{
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
		while (!feof($fh) && $count < 2)
		{
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

	/**
	 * Draw picture to pallete
	 *
	 * @param resource $imageResource
	 * @param int $width
	 * @param int $height
	 *
	 * return Resource
	 */
	public function drawRepeat ($imageResource, $width, $height)
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		$width = $width || $this->getWidth($imageResource);
		$height = $height || $this->getHeight($imageResource);

		imagesettile($imageResource, $image);
		imagefilledrectangle($imageResource, 0, 0, $width, $height, IMG_COLOR_TILED);

		return $imageResource;
	}

	/**
	 * Get a exif data of image file
	 *
	 * @param resource $imageResource
	 *
	 * @return mixed
	 */
	public function getExifData ($filePath, $header = ExifFileHeader::MAIN_IMAGE)
	{
		if (function_exists('exif_read_data'))
		{
			return exif_read_data($filePath, $header);
		}

		return $filePath;
	}
	
	private function getExifOrientationData($orientation)
	{
		$corrections = array(
			// Horizontal (normal)
			'1' => array(
				"Degree" => 0, 
				"Orientation" => Orientation::NORMAL
			), 
			// Mirror horizontal
			'2' => array(
				"Degree" => 0, 
				"Orientation" => Orientation::HORIZONTAL
			), 
			// Rotate 180
			'3' => array(
				"Degree" => 180, 
				"Orientation" => Orientation::NORMAL
			), 
			// Mirror vertical
			'4' => array(
				"Degree" => 0, 
				"Orientation" => Orientation::VERTICAL
			), 
			// Mirror horizontal and rotate 270 CW
			'5' => array(
				"Degree" => 270, 
				"Orientation" => Orientation::HORIZONTAL
			), 
			// Rotate 90 CW
			'6' => array(
				"Degree" => 270, 
				"Orientation" => Orientation::NORMAL
			), 
			// Mirror horizontal and rotate 90 CW
			'7' => array(
				"Degree" => 90, 
				"Orientation" => Orientation::HORIZONTAL
			), 
			// Rotate 270 CW
			'8' => array(
				"Degree" => 90, 
				"Orientation" => Orientation::NORMAL
			)
		);

		return $corrections[$orientation];
	}

	public function fixOrientation ($filePath, $imageResource)
	{
		$exif = $this->getExifData($filePath);
		
		$image = $imageResource;
		$degree = 0;
		$flip = 0;

		if (!empty($exif['Orientation'])) {
			$orientation = $exif['Orientation'];

			$data = $this->getExifOrientationData($orientation);

			$degree = $data['Degree'];
			$flip = $data['Orientation'];
		}
		
		$image = $this->Rotate($imageResource, $degree);

		switch ($flip) {
			case Orientation::VERTICAL:
			case Orientation::HORIZONTAL:
				$image = $this->Flip($image, $flip);
				break;
		}

		return $image;
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
	public function drawEclipse ($imageResource, $width, $height, $x, $y, $red, $green, $blue)
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		$backgroundColor = imagecolorallocate($imageResource, $red, $green, $blue);
		$outputImage = imagefilledellipse($imageResource, $x, $y, $width, $height, $backgroundColor);
		return $outputImage;
	}

	public function Combine ( $paletteImage, $combineImage, $right = 0, $top = 0)
	{
		if ( !$this->isResource($paletteImage) )
		{
			$paletteImage = $this->getInstance( $paletteImage );
		}

		if ( !$this->isResource($combineImage) )
		{
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
	public function ratioResize ($imageResource, $resizeWidth, $resizeHeight)
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		list($origin_width, $origin_height) = getimagesize($imageResource);
		$ratio = $origin_width / $origin_height;
		$resizeWidth = $resizeHeight = min($resizeWidth, max($origin_width, $origin_height));

		if ($ratio < 1)
		{
			$resizeWidth = $thumbnail_height * $ratio;
		}
		else
		{
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
	 * Crop Image
	 *
	 * @param resource $imageResource
	 * @param int      $width
	 * @param int      $height
	 * @param int      $left
	 * @param int      $top
	 */
	public function Crop ($imageResource, $resizeWidth, $resizeHeight, $sourceX = 0, $sourceY = 0)
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		$trueColorImage = $this->createTrueColorImage($resizeWidth, $resizeHeight);
		$this->setAlphaBlendMode($trueColorImage);
		$this->saveAlphaChannel($trueColorImage, false);

		$this->Resample($trueColorImage, $imageResource, 0, 0, $sourceX, $sourceY, $resizeWidth, $resizeHeight, $resizeWidth - $sourceX, $resizeHeight - $sourceY);

		return $trueColorImage;
	}

	public function centerCrop ($imageResource, $resizeWidth, $resizeHeight)
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		$sourceWidth = $this->getWidth($imageResource);
		$sourceHeight = $this->getHeight($imageResource);

		$centreX = round($sourceWidth / 2);
		$centreY = round($sourceHeight / 2);

		$cropWidthHalf  = round($resizeWidth / 2);
		$cropHeightHalf = round($resizeHeight / 2);

		$x1 = max(0, $centreX - $cropWidthHalf);
		$y1 = max(0, $centreY - $cropHeightHalf);

		$x2 = min($sourceWidth, $centreX + $cropWidthHalf);
		$y2 = min($sourceHeight, $centreY + $cropHeightHalf);

		$trueColorImage = $this->createTrueColorImage($resizeWidth, $resizeHeight);
		$this->setAlphaBlendMode($trueColorImage);
		$this->saveAlphaChannel($trueColorImage, false);

		$this->Resample($trueColorImage, $imageResource, 0,0,(int)$x1,(int)$y1, $resizeWidth, $resizeHeight, $resizeWidth, $resizeHeight);

		return $trueColorImage;
	}

	public function Resample ($destinationImage, $imageResource, $destinationX = 0, $destinationY = 0, $sourceX = 0, $sourceY = 0, $destinationWidth = 0, $destinationHeight = 0, $sourceWidth = 0, $sourceHeight = 0)
	{
		imagecopyresampled ($destinationImage, $imageResource, $destinationX, $destinationY, $sourceX, $sourceY, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight );
	}

	public function saveAlphaChannel($imageResource, $saveFlag = false)
	{
		imageSaveAlpha($imageResource, $saveFlag);
	}

	public function createTrueColorImage ($width, $height)
	{
		return imagecreatetruecolor($width, $height);
	}

	public function setAlphaBlendMode ($imageResource, $useBlendMode = true)
	{
		imagealphablending($imageResource, $useBlendMode);
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
	public function Filter ($imageResource, string $type, ...$args)
	{
		$filter = 0;
		$type = strtolower($type);

		switch ($type) {
			case ImageFilter::REVERSE: // 0
				$filter = IMG_FILTER_NEGATE;
				break;
			case ImageFilter::GRAYSCALE: // 1
				$filter = IMG_FILTER_GRAYSCALE;
				break;
			case ImageFilter::BRIGHTNESS: // 2
				$filter = IMG_FILTER_BRIGHTNESS;
				break;
			case ImageFilter::CONTRAST: // 3
				$filter = IMG_FILTER_CONTRAST;
				break;
			case ImageFilter::COLORIZE: // 4
				$filter = IMG_FILTER_COLORIZE;
				break;
			case ImageFilter::EDGEDETECT: // 5
				$filter = IMG_FILTER_EDGEDETECT;
				break;
			case ImageFilter::EMBOSS: // 6
				$filter = IMG_FILTER_EMBOSS;
				break;
			case ImageFilter::GAUSSIAN_BLUR: // 7
				$filter = IMG_FILTER_GAUSSIAN_BLUR;
				break;
			case ImageFilter::SELECTIVE_BLUR: // 8
				$filter = IMG_FILTER_SELECTIVE_BLUR;
				break;
			case ImageFilter::SKETCH: // 9
				$filter = IMG_FILTER_MEAN_REMOVAL;
				break;
			case ImageFilter::SMOOTH: // 10
				$filter = IMG_FILTER_SMOOTH;
				break;
			case ImageFilter::PIXELATE: // 11
				$filter = IMG_FILTER_PIXELATE;
				break;
			case ImageFilter::SCATTER: // 12
				$filter = IMG_FILTER_SCATTER;
				break;
		}

		imagefilter($imageResource, $filter, $args);

		return $imageResource;
	}

	/**
	 * Draw a picture to output
	 *
	 * @param resource $imageResource
	 *
	 * @return output stream
	 */
	public function Draw ( $imageResource, $format )
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

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
	public function pickColor ( $imageResource, $x, $y ) :array
	{
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}

		//  0xAARRGGBB => 00000001(alpha) 00000010(red) 00000011(green) 00000100(blue)
		$rgb = imagecolorat($imageResource, $x, $y);
		$alpha = ($rgb >> 24) & 0xFF;
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
	public function drawText ( $imageResource, $fontSize, $x, $y, $text, $red, $green, $blue )
	{
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		$textcolor = imagecolorallocate($imageResource, $red, $green, $blue);
		imagestring($imageResource, $fontSize, $x, $y, $text, $textcolor);

		return $imageResource;
	}

	/**
	 * Get type of image file
	 *
	 * @param string $filePath
	 *
	 * @return mixed
	 */
	public function getType ( $filePath )
	{
		$format = "unknown";

		if ($this->isResource($filePath)) {
			$format = \getimagesizefromstring($filePath);
		} else {
            $finfo = \getimagesize($filePath);
            if ($finfo === false) {
                return false;
            }

            $format = $finfo['mime'];
        }
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
	public function Create ($filePath, $imageResource, $outputPath, $quality = 100 ) {
		$format = $this->getType( $filePath );

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
	public function Flip ( $imageResource, $type ) {
		if ( !$this->isResource($imageResource) ) {
			$imageResource = $this->getInstance( $imageResource );
		}

		switch($type) {
			case Orientation::VERTICAL:
				imageflip($imageResource, IMG_FLIP_VERTICAL);
				break;
			case Orientation::HORIZONTAL:
				imageflip($imageResource, IMG_FLIP_HORIZONTAL);
				break;
			case Orientation::BOTH:
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

		if (function_exists('exif_read_data') && false) {
			$exifData = exif_read_data($imageResource, '', true, false);

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

		if (function_exists('exif_read_data') && false) {
			$exif = exif_read_data($imageResource, null, true, false);

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
		if ( gettype($imageResource) === 'resource') {
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

		$image = \imagerotate($imageResource, $degrees, 0);

		return $image;
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
						$createObject = \imagecreatefromjpeg($filePath);
					}
					break;
				case 'image/bmp':
					$createObject = \imagecreatefrombmp($filePath);
					break;
				case 'image/png':
					if (extension_loaded('gd')) {
						$createObject = \imagecreatefrompng($filePath);
					}
					break;
				case 'image/gif':
					if (extension_loaded('gd')) {
						$createObject = \imagecreatefromgif ($filePath);
					}
					break;
				case 'image/webp':
					if (extension_loaded('gd')) {
						$createObject = \imagecreatefromwebp($filePath);
					}
					break;
				default:
					return false;
			}
		} catch(\Exception $e) { }

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

	public function Resize ( $imageResource, $resizeWidth, $resizeHeight ) {
		if ( !$this->isResource($imageResource) )
		{
			$imageResource = $this->getInstance( $imageResource );
		}

		$outputImage = $this->createTrueColorImage($resizeWidth, $resizeHeight);

		$width = $this->getWidth($imageResource);
		$height = $this->getHeight($imageResource);

		imageAlphaBlending($outputImage, false);
		imageSaveAlpha($outputImage, false);

		imagecopyresampled($outputImage, $imageResource, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $width, $height);

		return $outputImage;
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

		$source_width = $this->getWidth($sourceCreateObject);
		$source_height = $this->getHeight($sourceCreateObject);

		return imagecopymerge($mergeCreateObject, $sourceCreateObject, 0, 0, 0, 0, $source_width, $source_height, $transparent);
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

		return new \stdClass();
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
