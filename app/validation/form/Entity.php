<?php
namespace lab\validation\form;

use lab\validation\Facade as ValidationFacade;
use lab\validation\specification as specificator;
use lab\controller\Request;
use lab\domain\DomainObject;

abstract class Entity
{
    protected $entityObject;
    protected $validation;

    public function __construct(DomainObject $object)
    {
        $this->entityObject = $object;
        $this->validation = new ValidationFacade();
    }

    abstract protected function addValidators();

    abstract protected function setProperties($request);

    public function handleRequest(Request $request)
    {
        if($request->getProperty('save')) {
            $this->setProperties($request);
            //$this->entityObject->setProperties($request);
            $this->addValidators();
            $this->validation->validate($this->entityObject);
        }

        return $this->validation;
    }

    public function getData()
    {
        //dane nie zostały sprawdzone
        if (!$this->validation->hasValidated()) {
            return array(
                'errors' => [],
                'entity' => $this->entityObject
            );
        }
        //dane zostały sprawdzone i są niepoprawne
        if (!$this->validation->isValid()) {
            return array(
                'errors' => $this->validation->getErrors(),
                'entity' => $this->validation->getClean()
            );
        }
        //dane zostały sprawdzone i są poprawne
        return $this->validation->getClean();
    }
}
