<?php
namespace lab\controller;

class CleanRequest
{
    private $data = array();

    public function get($var)
    {
        if (!array_key_exists($var, $this->data)) {
            return '';
        }
        return $this->data[$var];
    }

    public function set($var, $value)
    {
        $clone = clone $this;
        $clone->data[$var] = trim($value);
        return $clone;
    }
}
