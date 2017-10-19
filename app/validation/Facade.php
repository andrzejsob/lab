<?php
namespace lab\validation;

use lab\validation\specification\SingleField;
use lab\validation\specification as specificator;

class Facade
{
    private $coordinator;
    private $validators = array();
    private $hasValidated = false;
    private $errors = array();

    public function addSingleFieldValidation(
        $specificator,
        $fieldname = '',
        $message = ''
    ) {
        return $this->addValidator(
            new SingleField(
                new $specificator,
                $fieldname,
                $message
            )
        );
    }

    public function addValidator($validator)
    {
        return $this->validators[] = $validator;
    }

    public function validate($entity)
    {
        foreach ($this->validators as $validator) {
            if(!$validator->validate($entity)) {
                $this->errors[$validator->getField()] = $validator->getMessage();
            }
        }
        $this->hasValidated = true;
        return $this->isValid();
    }

    public function hasValidated() {
        return $this->hasValidated;
    }

    public function isValid()
    {
        if (!$this->hasValidated) return false;

        return count($this->errors) == 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
