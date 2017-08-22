<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;

class User extends Entity
{

    protected function setProperties($request) {
        $this->entityObject->setId($request->getProperty('id'));
        $this->entityObject->setNick($request->getProperty('nick'));
        $this->entityObject->setFirstName($request->getProperty('firstName'));
        $this->entityObject->setLastName($request->getProperty('lastName'));
        $this->entityObject->setEmail($request->getProperty('email'));
    }

    protected function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'firstName',
            'Imię nie może być puste'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'lastName',
            'Nazwisko nie może być puste'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'nick',
            'Login jest wymagany'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'email',
            'Email jest wymagany'
        );
    }
}
