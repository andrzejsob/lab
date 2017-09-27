<?php
namespace lab\validation\specification;

class ValidCollection
{
    public function isSatisfiedBy($candidate)
    {
        $candidate->rewind();
        return $candidate->valid();
    }
}
