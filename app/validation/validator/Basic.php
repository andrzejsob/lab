<?php
namespace lab\validation\validator;

class Basic
{
    private $specification;
    private $message;

    public function __construct($specification, $message)
    {
        $this->specification = $specification;
        $this->message = $message;
    }

    public function validate($coordinator)
    {
        if ($this->specification->isSatisfiedBy($coordinator)) {
            $coordinator->setClean($this->specification->getValidatedField());
            return true;
        } else {
            $coordinator->addError($this->message);
            return false;
        }
    }

    public function withMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function forField($fieldname)
    {
        $this->specification->forField($fieldname);
        return $this;
    }
}
