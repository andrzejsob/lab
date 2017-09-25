<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;

class Order extends Entity
{
    protected function setProperties($request) {
        $this->entityObject->setId($request->getProperty('id'));
        $contactPerson = \lab\domain\Order::getFinder('ContactPerson')
            ->find($request->getProperty('contactId'));
        if (!is_null($contactPerson)) {
            $this->entityObject->setContactPerson($contactPerson);
        }
        $this->entityObject->setNr($request->getProperty('nr'));
        $this->entityObject->setYear($request->getProperty('year'));
        $this->entityObject->setAKR($request->getProperty('akr'));
        $this->entityObject->setOrderDate($request->getProperty('orderDate'));
        $this->entityObject->setReceiveDate($request->getProperty('receiveDate'));
        $this->entityObject->setNrOfAnalyzes($request->getProperty('nrOfAnalyzes'));
        $this->entityObject->setSum($request->getProperty('sum'));
        $this->entityObject->setFoundSource($request->getProperty('foundSource'));
        $this->entityObject->setLoadNr($request->getProperty('loadNr'));
    }

    public function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NotNullObject,
            'contactPerson',
            'Nie wybrano osoby do kontaktu'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'orderDate',
            'Data zamówienia nie może być pusta'
        );
        $this->validation->addSingleFieldValidation(new specificator\NoEmptyValue)
            ->forField('receiveDate')
            ->withMessage(
                'Data wpłynięcia zlecenia do laboratorium nie może być pusta'
            );
    }
}
