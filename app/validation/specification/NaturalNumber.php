<?php
namespace lab\validation\specification;

class NaturalNumber
{
    public function isSatisfiedBy($candidate)
    {
        return preg_match('/^[1-9]+[0-9]*/', $candidate);
    }
}
