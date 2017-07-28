<?php
namespace lab\validation\specification;

class SingleField
{
    private $fieldname;
    private $valueSpecification;

    public function __construct($field, $specification)
    {
        $this->fieldname = $field;
        $this->valueSpecification = $specification;
    }

    public function getValidatedField()
    {
        return $this->fieldname;
    }

    public function isSatisfiedBy($candidate)
    {
        return $this->valueSpecification->isSatisfiedBy(
            $candidate->get($this->fieldname)
        );
    }

    public function forField($fieldname)
    {
        $this->fieldname = $fieldname;
    }
}
