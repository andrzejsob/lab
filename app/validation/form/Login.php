<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;

class Login extends Entity
{
    protected function setProperties($request) {
        $this->entityObject->setUsername($request->getProperty('username'));
        $this->entityObject->setPassword($request->getProperty('password'));
    }

    public function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'username',
            'Brak loginu'
        );
        $this->validation->addSingleFieldValidation(new specificator\NoEmptyValue)
            ->forField('password')
            ->withMessage('Brak hasła');
    }

    public function setVars(Request $request)
    {

    }
}
