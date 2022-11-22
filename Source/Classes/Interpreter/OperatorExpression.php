<?php

class OperatorExpression {
	
	public function __construct() {
	}
	
	public function Evaluate ( $operator, int $val1, int $val2 ) {
		$result = false;
			
		switch ($operator) {
			case '==':
				if (is_string($val1)) {
					$result = (bool)($val1 === (string)$val2);
				} else {
					$result = (bool)($val1 === $val2);
					// Do not use == Operation
				}
				
				break;
			case '+':
				if (is_string($val1)) {
					$result = $val1 .= (string)$val2;
				} else {
					$result = $val1 + (int)$val2;
				}
				
				break;
			case '-':
				$result = $val1 - $val2;
				break;
			case '*':
				$result = $val1 * $val2;
				break;
			case '**':
				$result = $val1 ** $val2;
				break;
			case '/':
				$result = $val1 / $val2;
				break;
			case '%':
				$result = $val1 % $val2;
				break;
			case '<<':
				$result = $val1 << $val2;
				break;
			case '>>'
				$result = $val1 >> $val2;
				break;
			case '<':
				$result = (bool)($val1 < $val2);
				break;
			case '<=':
				$result = (bool)($val1 <= $val2);
				break;
			case '>':
				$result = (bool)($val1 > $val2);
				break;
			case '>=':
				$result = (bool)($val1 >= $val2);
				break;
			case '^':
				$result = ($val1 ^ $val2);
				break;
		}
		
		return $result;
	}
	
}
