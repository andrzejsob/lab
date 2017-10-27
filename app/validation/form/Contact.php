<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\domain\Client;
use lab\controller\Request;

class Contact extends Entity
{
    protected function setProperties($request) {
        if ($clientId = $request->getProperty('clientId')) {
            $this->entityObject->setClient(Client::find($clientId));
        }
        $this->entityObject->setFirstName($request->getProperty('firstName'));
        $this->entityObject->setLastName($request->getProperty('lastName'));
        $this->entityObject->setEmail($request->getProperty('email'));
        $this->entityObject->setPhone($request->getProperty('phone'));
    }

    public function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\ValidObject,
            'Client',
            'Nie wybrano klienta'
        );
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
            new specificator\ValidEmail,
            'email',
            'Niepoprawny format adresu email'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NumericValue,
            'phone',
            'Nr telefonu może zawirać tylko cyfry'
        );
    }

    public function setVars(Request $request)
    {
        $selectedClient = $this->entityObject->getClient();
        $this->vars = array(
            'clients' => Client::getFinder()->findAll(),
            'selectedClient' => $selectedClient,
        );
    }
}
