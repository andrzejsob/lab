<?php
namespace lab\validation\specification;

class ZipCodeFormat
{
    public function isSatisfiedBy($candidate)
    {
        return preg_match('/^\d{2}-\d{3}$/', $candidate);
    }
}
