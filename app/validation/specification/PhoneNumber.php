<?php
namespace lab\validation\specification;

class PhoneNumber
{
    public function isSatisfiedBy($candidate)
    {
        return preg_match('/^\d{1,9}$/', $candidate);
    }
}
