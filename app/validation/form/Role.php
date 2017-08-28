<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;

class Role extends Entity
{

    protected function setProperties($request) {
        $this->entityObject->setId($request->getProperty('id'));
        $this->entityObject->setName($request->getProperty('name'));
    }

    protected function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'name',
            'Nazwa jest wymagana'
        );
    }
}
