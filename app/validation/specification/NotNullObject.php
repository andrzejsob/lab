<?php
namespace lab\validation\specification;

class NotNullObject
{
    public function isSatisfiedBy($candidate)
    {
        return !is_null($candidate);
    }
}
