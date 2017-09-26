<?php
namespace lab\validation\specification;

class ValidObject
{
    public function isSatisfiedBy($candidate)
    {
        return !is_null($candidate->getId());
    }
}
