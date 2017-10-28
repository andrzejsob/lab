<?php
namespace lab\validation\specification;

class ValidDate
{
    public function isSatisfiedBy($candidate)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $candidate);
        return $date !== false && !array_sum($date->getLastErrors());
    }
}
