<?php

namespace Xanax\Classes\XML;

class XMLParser {

	private $parser;

	public function __constructor() {
		$this->parser = xml_parser_create();
		$this->setObject();
	}

	public function setObject() {
		xml_set_object($this->parser, $this);
	}

	public function Parse($plainText) {
		xml_parse($this->parser, $plainText);
	}

	public function setElementHandler(callable $startTag, callable $endTag) {
		xml_set_element_handler($this->parser, $startTag, $endTag);
	}

	public function setCharacterDataHandler($object) {
		xml_set_character_data_handler($this->parser, $object);
	}

}
