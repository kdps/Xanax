<?php

namespace Xanax\Enumeration;

abstract class ImageFilter
{
    const BRIGHTNESS = 'brightness';
    const GRAYSCALE = 'grayscale';
    const GAUSSIAN_BLUR = 'gaussian_blur';
    const SELECTIVE_BLUR = 'selective_blur';
    const CONTRAST = 'contrast';
    const REVERSE = 'reverse';
    const EDGEDETECT = 'edgedetect';
    const EMBOSS = 'emboss';
    const SKETCH = 'sketch';
    const SMOOTH = 'smooth';
    const PIXELATE = 'pixelate';
    const COLORIZE = 'colorize';
    const SCATTER = 'scatter';
}