<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;
use lab\mapper\MethodCollection;
use lab\mapper\RoleCollection;
use lab\domain\Method;
use lab\domain\Role;

class User extends Entity
{
    protected function setProperties($request) {
        if ($methodIds = $request->getProperty('methods')) {
            $methodColl = new MethodCollection();
            foreach ($methodIds as $methodId) {
                $methodColl->add(Method::find($methodId));
            }
            $this->entityObject->setMethods($methodColl);
        }

        if ($roleIds = $request->getProperty('roles')) {
            $roleColl = new RoleCollection();
            foreach ($roleIds as $roleId) {
                $roleColl->add(Role::find($roleId));
            }
            $this->entityObject->setRoles($roleColl);
        }

        $this->entityObject->setUsername($request->getProperty('username'));
        $this->entityObject->setFirstName($request->getProperty('firstName'));
        $this->entityObject->setLastName($request->getProperty('lastName'));
        $this->entityObject->setEmail($request->getProperty('email'));
    }

    protected function addValidators()
    {
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
            new specificator\NoEmptyValue,
            'username',
            'Login jest wymagany'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\ValidEmail,
            'email',
            'Niepoprawny format adresu email'
        );
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'email',
            'Email jest wymagany'
        );
    }

    public function setVars(Request $request)
    {
        $methodIds = [];
        $roleIds = [];

        if (is_null($request->getProperty('methods'))) {
            $methodIds = $this->entityObject->getMethods()->getArray('id');
        } else {
            $methodIds = $request->getProperty('methods');
        }

        if (is_null($request->getProperty('roles'))) {
            $roleIds = $this->entityObject->getRoles()->getArray('id');
        } else {
            $roleIds = $request->getProperty('roles');
        }

        $this->vars = array(
            'methods' => Method::getFinder()->findAll(),
            'roles' => Role::getFinder()->findAll(),
            'checkedMethodIdsArray' => $methodIds,
            'checkedRoleIdsArray' => $roleIds
        );
    }
}
