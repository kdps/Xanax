<?php

namespace Xanax\Classes;

class Tokenizer
{
	const OPERATOR = 1;
	const PARENTHESIES = 2;
	const WORD = 3;
	const COMMA = 4;
	const DATATYPE = 5;

	private $tokens = [];
	private $token = '';

	private $variableSpecialCharacter = ['-', '_'];

	private $quotes = ['"', "'"];

	private $operatorTokens = [
		',' => self::COMMA,
		'?' => self::OPERATOR,
		'=' => self::OPERATOR,
		'&' => self::OPERATOR,
		'%' => self::OPERATOR,
		'+' => self::OPERATOR,
		'-' => self::OPERATOR,
		'*' => self::OPERATOR,
		'/' => self::OPERATOR,
		'<' => self::OPERATOR,
		'>' => self::OPERATOR,
		'(' => self::PARENTHESIES,
		')' => self::PARENTHESIES
	];
	private $firstTokens = [
		'string' => self::DATATYPE,
		'integer' => self::DATATYPE,
		'boolean' => self::DATATYPE,
		'float' => self::DATATYPE,
		'array' => self::DATATYPE,
		'double' => self::DATATYPE,
		'long' => self::DATATYPE,
		'character' => self::DATATYPE,
		'short' => self::DATATYPE
	];

	const STATE_DEFAULT = 0;
	const STATE_STRING = 1;
	const STATE_NUMBER = 2;
	const STATE_COMMENT = 3;
	const STATE_WORD = 4;
	const STATE_OPERATOR = 5;

	public function generateToken($string)
	{
		$count = strlen($string);

		$state = self::STATE_DEFAULT;

		// Lexical analysis
		for ($i = 0; $i < $count; $i++) {
			$character = $string[$i];

			switch ($state) {
				case self::STATE_DEFAULT:
					if (ctype_alpha($character)) {
						$this->token .= $character;
						$state = self::STATE_WORD;
					} elseif (is_numeric($character)) {
						$this->token .= $character;
						$state = self::STATE_WORD;
					} elseif (in_array($character, $this->variableSpecialCharacter)) {
						$this->token .= $character;
					} elseif (isset($this->operatorTokens[$character])) {
						$this->token .= $character;
						$state = self::STATE_OPERATOR;
					} elseif (in_array($character, $this->quotes)) {
						$state = self::STATE_STRING;
					}

					break;
				case self::STATE_OPERATOR:
					if (isset($this->operatorTokens[$character])) {
						$this->token .= $character;
					} else {
						$this->tokens[] = new TokenObject($this->token, $this->operatorTokens[$this->token]);
						$this->token = '';
						$i--;

						$state = self::STATE_DEFAULT;
					}

					break;
				case self::STATE_STRING:
					if ($character == '"') {
						$this->tokens[] = new TokenObject($this->token, self::STATE_STRING);
						$this->token = '';

						$state = self::STATE_DEFAULT;
					} else {
						$this->token .= $character;
					}

					break;
				case self::STATE_WORD:
					if (ctype_alnum($character) || in_array($character, $this->variableSpecialCharacter)) {
						$this->token .= $character;
					} else {
						if (isset($this->operatorTokens[$character])) {
							$this->tokens[] = new TokenObject($this->token, self::STATE_WORD);
						} else {
							$this->tokens[] = new TokenObject($this->token, self::STATE_WORD);
						}

						$this->token = '';
						$i--;

						$state = self::STATE_DEFAULT;
					}

					break;
			}
		}

		echo print_r($this);
	}
}
