<?php

namespace Xanax\Classes\String;

use Xanax\Classes\String\StringHandler;

class StringObject 
{

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __toString() {
        return $this->data;
    }

    public function isContains($search) {
        $handler = new StringHandler();
        return $handler->isContains($this->data, $search);
    }

}