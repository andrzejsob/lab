<?php
namespace lab\validation\form;

use lab\validation\Facade as ValidationFacade;
use lab\validation\specification as specificator;
use lab\controller\Request as Request;
use lab\domain\DomainObject as DomainObject;

class Client
{
    private $clientObject;
    private $validation;

    public function __construct(DomainObject $client)
    {
        $this->clientObject = $client;
        $this->validation = new ValidationFacade();
    }

    public function handleRequest(Request $request)
    {
        if($request->getProperty('submit')) {
            $this->clientObject->setProperties($request);
            $this->addValidators();
            $this->validation->validate($this->clientObject);
        }

        return $this->validation;
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
    }

    public function getData()
    {
        if (!$this->validation->hasValidated()) {
            return array(
                'errors' => [],
                'client' => $this->clientObject
            );
        }

        if (!$this->validation->isValid()) {
            return array(
                'errors' => $this->validation->getErrors(),
                'client' => $this->validation->getClean()
            );
        }

        return $this->validation->getClean();
    }
}
