<?php
namespace lab\validation\specification;

class Intvalue
{
    public function isSatisfiedBy($candidate)
    {
        return preg_match('/^\d+$/', $candidate);
    }
}
