<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;

class Client extends Entity
{
    protected function setProperties($request) {
        $this->entityObject->setId($request->getProperty('id'));
        $this->entityObject->setName($request->getProperty('name'));
        $this->entityObject->setStreet($request->getProperty('street'));
        $this->entityObject->setZipCode($request->getProperty('zipCode'));
        $this->entityObject->setCity($request->getProperty('city'));
        $this->entityObject->setNip($request->getProperty('nip'));
    }

    public function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'name',
            'Nazwa nie może być pusta'
        );
        $this->validation->addSingleFieldValidation(new specificator\ZipCodeFormat)
            ->forField('zipCode')
            ->withMessage('Kod musi mieć format: 12-345');
        $this->validation->addSingleFieldValidation(new specificator\NoEmptyValue)
            ->forField('zipCode')
            ->withMessage('Kod pocztowy nie może być pusty');
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'city',
            'Miasto nie może być puste'
        );
    }

    public function setVars(Request $request)
    {

    }
}
