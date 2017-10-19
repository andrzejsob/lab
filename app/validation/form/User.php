<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;

class User extends Entity
{

    protected function setProperties($request) {
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
            'Imię jest wymagane'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'lastName',
            'Nazwisko jest wymagane'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'nick',
            'Login jest wymagany'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\ValidEmail,
            'email',
            'Niepoprawny format adresu email'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'email',
            'Email jest wymagany'
        );
    }

    public function setVars(Request $request)
    {
    }
}
