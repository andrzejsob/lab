<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;

class Method extends Entity
{

    protected function setProperties($request) {
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

    public function setVars(Request $request)
    {
    }
}
