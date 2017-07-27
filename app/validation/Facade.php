<?php
namespace lab\validation;

use lab\controller\CleanRequest;
use lab\validation\Coordinator;
use lab\validation\validator\Basic;
use lab\validation\specification\SingleField;

class Facade
{
    private $coordinator;
    private $validators = array();
    private $hasValidated = false;

    public function addAlnumValidation($fieldname, $message)
    {
        $this->addValidator(
            new Basic(
                new SingleField(
                    $fieldname,
                    new AlphanumericValue
                ),
                $message
            );
        );
    }

    public function addValidator($validator)
    {
        $this->validators[] = $validator;
    }

    public function validate($request)
    {
        $this->coordinator = $this->createCoordinator(
            $request,
            new CleanRequest
        );
        foreach ($this->validators as $validator) {
            $validator->validate($this->coordinator);
        }
        $this->hasValidated = true;
        return $this->isValid();
    }

    public function isValid()
    {
        if (!$this->hasValidated) return false;
        return count($this->coordinator->getErrors() == 0);
    }

    public function createCoordinator($raw, $clean)
    {
        return new Coordinator($raw, $clean);
    }

    public function getCleanRequest()
    {
        if (!$this->isValid()) return false;
        return $this->coordinator->getCleanRequest();
    }

    public function getErrors()
    {
        if ($this->isValid()) return false;
        return $this->coordinator->getErrors();
    }
}
