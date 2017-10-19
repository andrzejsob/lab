<?php
namespace lab\validation\specification;

class SingleField
{
    private $field;
    private $specification;
    private $message;

    public function __construct($specification, $field, $message)
    {
        $this->specification = $specification;
        $this->field = $field;
        $this->message = $message;
    }

    public function getForValidation($entity)
    {
        $getForValidation = 'get'.ucfirst($this->field);
        return $entity->$getForValidation();
    }

    public function validate($entity)
    {
        return $this->specification->isSatisfiedBy(
            $this->getForValidation($entity)
        );
    }

    public function forField($field)
    {
        $this->field = $field;
        return $this;
    }

    public function withMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getField()
    {
        return $this->field;
    }
    public function getMessage()
    {
        return $this->message;
    }
}
