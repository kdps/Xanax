<?php

namespace Xanax\Classes;

class InsertableSort {
	
	public function Sort ( array $array ) {
		$count = count($array);
		
		for($iterator = 1; $iterator < $count; $iterator++ ) {
			for($index = $iterator-1; $index > -1; $index-- ) {
				if ($array[$index] < $array[$index+1]) {
					$tmp = $array[$index+1];
					$array[$index+1] = $array[$index];
					$array[$index] = $tmp;
				}
			}
		}
		
		return array_reverse($array);
	}
	
}