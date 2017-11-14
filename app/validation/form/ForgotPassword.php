<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;

class ForgotPassword extends Entity
{
    protected function setProperties($request) {
        $this->entityObject->setEmail($request->getProperty('email'));
    }

    public function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\ValidEmail,
            'email',
            'Niepoprawny format adresu e-mail'
        );
    }

    public function setVars(Request $request)
    {

    }
}
