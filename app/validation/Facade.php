<?php
namespace lab\validation;

use lab\controller\CleanRequest;
use lab\validation\Coordinator;
use lab\validation\validator\Basic;
use lab\validation\specification\SingleField;

use lab\validation\specification as specificator;

class Facade
{
    private $coordinator;
    private $validators = array();
    private $hasValidated = false;

    public function addSingleFieldValidation(
        $specificator,
        $fieldname = '',
        $message = ''
    ) {
        return $this->addValidator(
            new Basic(
                new SingleField(
                    $fieldname,
                    new $specificator
                ),
                $message
            )
        );
    }
    /*public function addAlnumValidation($fieldname = '', $message = '')
    {
        return $this->addValidator(
            new Basic(
                new SingleField(
                    $fieldname,
                    new specificator\AlphanumericValue
                ),
                $message
            )
        );
    }*/

    public function addValidator($validator)
    {
        return $this->validators[] = $validator;
    }

    public function validate($rawDomainObject)
    {
        $cleanDomainObject = get_class($rawDomainObject);
        $this->coordinator = $this->createCoordinator(
            $rawDomainObject,
            new $cleanDomainObject
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

        return count($this->coordinator->getErrors()) == 0;
    }

    public function createCoordinator($raw, $clean)
    {
        return new Coordinator($raw, $clean);
    }

    public function getClean()
    {
        //if (!$this->isValid()) return false;
        return $this->coordinator->getClean();
    }

    public function getErrors()
    {
        if ($this->isValid()) return false;
        return $this->coordinator->getErrors();
    }
}
