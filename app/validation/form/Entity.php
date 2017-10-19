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
            $this->addValidators();
            $this->validation->validate($this->entityObject);
        }
        $this->setVars($request);
        return $this->validation;
    }

    public function getData()
    {
        $this->vars['errors'] = $this->validation->getErrors();
        $this->vars['entity'] = $this->entityObject;
        return $this->vars;
    }
}
