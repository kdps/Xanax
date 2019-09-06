<?php

namespace Xanax\Interpreter;

class Tokenizer {
	
	private $tokens = array();
	
	public function generateToken ( $string ) {
		$count = strlen( $string );
		
		// Lexical analysis
		for ($i = 0; $i < $count; $i++) {
			$character = $string{$i};
		}
	}
	
}