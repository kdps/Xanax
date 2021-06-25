<?php

namespace Xanax\Implement;

interface ImageHandlerInterface {
	
	public function isAnimated($filename);

	public function drawRepeat($imageResource, $width, $height);

	public function drawEclipse($imageResource, $width, $height, $x, $y, $red, $green, $blue);

	public function Combine($paletteImage, $combineImage, $right = 0, $top = 0);

	public function ratioResize($imageResource, $resizeWidth, $resizeHeight);

	public function FIlter($imageResource, $type, $args1 = '', $args2 = '', $args3 = '');

	public function Draw($imageResource);

	public function pickColor($imageResource, $x, $y) :array;

	public function drawText($imageResource, $fontSize, $x, $y, $text, $red, $green, $blue);

	public function getExifData($filePath);

	public function getType($filePath);

	public function Create($imageResource, $outputPath, $quality = 100);

	public function Flip($imageResource);

	public function getWidth($imageResource);

	public function getHeight($imageResource);

	public function isResource($imageResource);

	public function Rotate($imageResource, $degrees);

	public function getimageResource($filePath);

	public function getBlank($width, $height, $red, $blue, $green);

	public function Merge($sourceCreateObject, $mergeCreateObject, $transparent);

	public function getInstance($filePath);

	public function hexToRgb($hex);
	
}
