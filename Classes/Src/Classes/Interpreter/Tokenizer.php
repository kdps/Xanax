<?php

namespace Xanax\Classes;

use Xanax\Exception\Interpreter\InvalidExpress;
use Xanax\Classes\TokenObject;

class Tokenizer {
	
	const OPERATOR = 1;
	const PARENTHESIES = 2;
	const WORD = 3;
	const COMMA = 4;
	
	private $tokens = array();
	private $token = "";
	
	private $variableSpecialCharacter = array("-", "_");
	private $operatorTokens = array(
		"," => self::COMMA,
		"=" => self::OPERATOR,
		"&" => self::OPERATOR,
		"%" => self::OPERATOR,
		"+" => self::OPERATOR,
		"-" => self::OPERATOR,
		"*" => self::OPERATOR,
		"/" => self::OPERATOR,
		"<" => self::OPERATOR,
		">" => self::OPERATOR,
		"(" => self::PARENTHESIES,
		")" => self::PARENTHESIES
	);
		
	const STATE_DEFAULT = 0;
	const STATE_STRING = 1;
	const STATE_NUMBER = 1;
	const STATE_COMMENT = 1;
	
	public function generateToken ( $string ) {
		$count = strlen( $string );
		
		$state = self::STATE_DEFAULT;
		
		// Lexical analysis
		for ($i = 0; $i < $count; $i++) {
			$character = $string{$i};
			
			switch ( $state ) {
				case self::STATE_DEFAULT:
					if (ctype_alpha($character)) {
						$this->token .= $character;
						$state = self::STATE_STRING;
					} else if (is_numeric($character)) {
						$this->token .= $character;
						$state = self::STATE_STRING;
					} else if ( in_array ($character, $this->variableSpecialCharacter) ) {
						$this->token .= $character;
					} else if ( isset($this->operatorTokens[$character]) ) {
						$this->tokens[] = new TokenObject($character, $this->operatorTokens[$character]);
					}
					
					if ($character === '"') {
					}
					
					break;
				case self::STATE_STRING:
					if (ctype_alnum($character) || in_array ($character, $this->variableSpecialCharacter) ) {
						$this->token .= $character;
					} else {
						$this->tokens[] = new TokenObject($this->token, self::WORD);
						$this->token = "";
						$i--;
						$state = self::STATE_DEFAULT;
					}
					
					break;
			}
		}
		
		echo print_r($this);
	}
	
}