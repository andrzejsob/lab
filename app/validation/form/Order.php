<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\domain\ContactPerson;
use lab\domain\Method;
use lab\domain\Client;
use lab\controller\Request;
use lab\mapper\MethodCollection;

class Order extends Entity
{
    protected function setProperties($request) {
        $contactPerson = new ContactPerson();
        $contactPerson->setClient(new Client());
        $methodColl = new MethodCollection();

        if ($contactId = $request->getProperty('contactId')) {
            $contactPerson = ContactPerson::find($contactId);
        }

        if ($methodIds = $request->getProperty('methods')) {
            foreach ($methodIds as $methodId) {
                $methodColl->add(Method::find($methodId));
            }
        }

        if (is_null($request->getProperty('akr'))) {
            $request->setProperty('akr', 0);
        }

        $this->entityObject->setContactPerson($contactPerson);
        $this->entityObject->setMethods($methodColl);
        $this->entityObject->setNr($request->getProperty('nr'));
        $this->entityObject->setAkr($request->getProperty('akr'));
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
            new specificator\ValidObject,
            'contactPerson',
            'Nie wybrano osoby do kontaktu'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\ValidDate,
            'orderDate',
            'Data zamówienia jest niepoprawna'
        );
        $this->validation->addSingleFieldValidation(new specificator\ValidDate)
            ->forField('receiveDate')
            ->withMessage(
                'Data wpłynięcia zlecenia do laboratorium jest niepoprawna'
        );
        $this->validation->addSingleFieldValidation(
          new specificator\NaturalNumber,
          'nrOfAnalyzes',
          'Liczba analiz musi być liczbą naturalną'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NumericValue,
            'sum',
            'Kwota zamówienia powinna być liczbą np. 10, 10.5'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\ValidCollection,
            'methods',
            'Nie wybrano metod badawczych'
        );
    }

    public function setVars(Request $request)
    {
        $selectedClient = $this->entityObject->getContactPerson()->getClient();

        $methodIds = array();
        if (is_null($request->getProperty('methods'))) {
            $methodIds = $this->entityObject->getMethods()->getArray('id');
        } else {
            $methodIds = $request->getProperty('methods');
        }

        $this->vars = array(
            'checkedMethodsIdArray' => $methodIds,
            'clients' => Client::getFinder()->findAll(),
            'methods' => Method::getFinder()->findAll(),
            'selectedContact' => $this->entityObject->getContactPerson(),
            'selectedClient' => $selectedClient,
            'selectedClientContacts' => $selectedClient->getContactPersons()
        );
    }
}
