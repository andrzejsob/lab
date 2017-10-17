<?php
namespace lab\validation\specification;

class ValidEmail
{
    public function isSatisfiedBy($candidate)
    {
        return filter_var($candidate, FILTER_VALIDATE_EMAIL));;
    }
}
