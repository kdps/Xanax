<?php

namespace Xanax\Classes\Data;

use Xanax\Classes\Data\StringHandler as StringHandler;

class StringObject 
{

    private $data;
    private $handler;

    public function __construct($data) {
        $this->data = $data;

        $this->handler = new StringHandler();
    }

    public function __toString() 
    {
        return $this->data;
    }

    public function Substring($start, $length) 
    {
        return $this->handler->Substring($this->data, $start, $length);
    }

    public function isNull() 
    {
        return $this->handler->isNull($this->data);
    }

    public function isContains($search) 
    {
        return $this->handler->isContains($this->data, $search);
    }

    public function toUpperCase()
    {
        return $this->handler->toUpperCase($this->data);
    }

    public function removeByteOrderMark()
    {
        return $this->handler->removeByteOrderMark($this->data);
    }

    public function toLowerCase()
    {
        return $this->handler->toLowerCase($this->data);
    }

    public function Length()
    {
        return $this->handler->Length($this->data);
    }

}