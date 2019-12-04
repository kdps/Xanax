<?php

declare(strict_types=1);

class HTMLHandler
{
	public static function generateParameter($attributes = [])
	{
		$result = '';
		
		foreach ($attributes as $key => $val) {
			$pair = sprintf("'%s'", $val);
			if ($result) {
				$result = $result . ',' . $pair;
			} else {
				$result = $pair;
			}
		}

		return $result;
	}

	public static function generateElement($type, $content, $attributes = [])
	{
		$html .= sprintf('%s%s', '<', $type);

		if (empty($attributes)) {
			$html .= '';
		} elseif (is_string($attributes)) {
			$html .= ' ' . $attributes;
		} elseif (is_array($attributes)) {
			foreach ($attributes as $key => $val) {
				if ($key) {
					$pairs[] = sprintf('%s="%s"', $key, $val);
				}
			}

			$html .= ' ' . implode(' ', $pairs);
		}

		return sprintf('%s>%s</%s>', $html, $content, $type);
	}
}
