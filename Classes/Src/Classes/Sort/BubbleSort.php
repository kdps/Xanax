<?php

namespace Xanax\Classes;

class BubbleSort {
	
	public function Sort ( array $array ) {
		$count = count($array);
		
		for ($iterator = 1; $iterator < $count; $iterator++) {
			
			$isMerged = true;
			$overload = $count - $iterator;
			
			for ($index = 0; $index < $overload; $index++) {
				if ($array[ $index ] > $array[ $index + 1 ]) {
					$isMerged = false;
					$tmp = $array[ $index ];
					$array[ $index ] = $array[ $index + 1 ];
					$array[ $index+1 ] = $tmp;
				}
			}
			
			if ($isMerged) {
				break;
			}
		}
		
		return $array;
	}
	
}