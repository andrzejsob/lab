<?php
namespace lab\validation\form;

use lab\validation\specification as specificator;
use lab\controller\Request;
use lab\domain\Permission;
use lab\mapper\PermissionCollection;
use lab\domain\Method;

class Role extends Entity
{

    protected function setProperties($request)
    {
        $permColl = new PermissionCollection();

        if ($permIds = $request->getProperty('permissions')) {
            foreach ($permIds as $permId) {
                $permColl->add(Permission::find($permId));
            }
        }

        $this->entityObject->setName($request->getProperty('name'));
        $this->entityObject->setPermissions($permColl);
    }

    protected function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'name',
            'Nazwa jest wymagana'
        );

        $this->validation->addSingleFieldValidation(
            new specificator\ValidCollection,
            'permissions',
            'Nie wybrano uprawnień'
        );
    }

    public function setVars(Request $request)
    {
        $permIds = array();
        if (!is_null($request->getProperty('permissions'))) {
            $permIds = $request->getProperty('permissions');
        } else {
            $permIds = $this->entityObject->getPermissions()->getArray('id');
        }

        $this->vars = array(
            'checkedPermIdArray' => $permIds,
            'permissions' => Permission::getFinder()->findAll(),
        );
    }
}
