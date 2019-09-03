<?php

namespace Xanax\Classes;

class InsertableSort {
	
	public function Sort ( array $array ) {
		$count = count($array);
		
		for($iterator = 0; $iterator < $count - 1; $iterator++ ) {
			$isSorted = true;
			for($index = $iterator; $index > -1; $index-- ) {
				if ($array[$index] < $array[$index+1]) {
					$tmp = $array[$index+1];
					$array[$index+1] = $array[$index];
					$array[$index] = $tmp;
					$isSorted = false;
				}
			}
		}
		
		return array_reverse($array);
	}
	
}