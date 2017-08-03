<?php
namespace lab\validation\specification;

class NoEmptyValue
{
    public function isSatisfiedBy($candidate)
    {
        return trim($candidate) == true;
    }
}
