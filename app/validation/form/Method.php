<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;

class Method extends Entity
{

    protected function setProperties($request) {
        $this->entityObject->setId($request->getProperty('id'));
        $this->entityObject->setAcronym($request->getProperty('acronym'));
        $this->entityObject->setName($request->getProperty('name'));
    }

    protected function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'acronym',
            'Akronim jest wymagany'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'name',
            'Opis jest wymagany'
        );
    }
}
