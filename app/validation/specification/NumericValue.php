<?php
namespace lab\validation\specification;

class NumericValue
{
    public function isSatisfiedBy($candidate)
    {
        return is_numeric($candidate);
    }
}
