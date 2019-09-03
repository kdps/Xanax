<?php

namespace Xanax\Classes;

class InsertableSort {
	
	public function Sort ( array $array ) {
		$count = count($array);
		
		if ($count < 80) {
			// Approximately 5~20000 times faster than traditional algorithms
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
				
				if ($isSorted) {
					$iterator = ++$iterator;
				}
			}
			
			$array = array_reverse($array);
			
			$count = count($array);
			for($iterator = 0; $iterator < $count - 1; $iterator++ ) {
				for($index = $iterator; $index > -1; $index-- ) {
					if ($array[$index] < $array[$index+1]) {
						$tmp = $array[$index+1];
						$array[$index+1] = $array[$index];
						$array[$index] = $tmp;
					}
				}
			}
			
			return array_reverse($array);
		} else {
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
	
}