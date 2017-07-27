<?php
namespace lab\validation\specification;

class AlphanumericValue
{
    public function isSatisfiedBy($candidate)
    {
        return ctype_alnum($candidate);
    }
}
