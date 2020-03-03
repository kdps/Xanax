<?php

namespace Xanax/Classes/XML;

class XMLParser {

  private $parser;

  public function __constructor() {
    $this->parser = xml_parser_create();
  }

  public function Parse($plainText) {
    xml_parse($this->parser, $plainText);
  }

}
