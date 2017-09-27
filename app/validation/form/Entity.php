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
    protected $vars = array();

    public function __construct(DomainObject $object)
    {
        $this->entityObject = $object;
        $this->validation = new ValidationFacade();
    }

    abstract protected function addValidators();
    abstract protected function setVars(Request $request);
    abstract protected function setProperties($request);

    public function handleRequest(Request $request)
    {
        if($request->getProperty('save')) {
            $this->setProperties($request);
            //$this->entityObject->setProperties($request);
            $this->addValidators();
            $this->validation->validate($this->entityObject);
        }
        $this->setVars($request);
        return $this->validation;
    }

    public function getData()
    {
        //dane nie zostały sprawdzone
        if (!$this->validation->hasValidated()) {
            $this->vars['errors'] = array();
            $this->vars['entity'] = $this->entityObject;
            return $this->vars;
            /*return array(
                'errors' => [],
                'entity' => $this->entityObject
            );*/
        }
        //dane zostały sprawdzone i są niepoprawne
        if (!$this->validation->isValid()) {
            $this->vars['errors'] = $this->validation->getErrors();
            $this->vars['entity'] = $this->validation->getClean();
            return $this->vars;
            /*return array(
                'errors' => $this->validation->getErrors(),
                'entity' => $this->validation->getClean()
            );*/
        }
        //dane zostały sprawdzone i są poprawne
        return $this->validation->getClean();
        //return $this->validation->getClean();
    }
}
