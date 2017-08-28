<?php
namespace lab\command;

use lab\mapper\RoleMapper;
use lab\mapper\PermissionMapper;
use lab\domain\Role;
use lab\validation\form\Client as ClientForm;
use lab\validation\form\Role as RoleForm;

class RoleCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction($request)
    {
        $rMapper = new RoleMapper();
        $roles = $rMapper->findAll();

        return $this->render(
            'app/view/role/index.php',
            ['roles' => $roles]
        );
    }

    public function newAction($request)
    {
        $role = new Role();
        $pMapper = new PermissionMapper();
        $allPermissions = $pMapper->findAll();

        $roleForm = new RoleForm($role);
        $validation = $roleForm->handleRequest($request);

        if ($validation->isValid()) {
            $role = $roleForm->getData();
            $role->save();
            //zapisanie metod użytkownika do bazy
            $pMapper->updateRolePermissions(
                $role->getId(),
                $request->getProperty('permission')
            );
            header('Location: ?cmd=role-index');
        }
        $this->assign('permissions', $allPermissions);
        return $this->render(
            'app/view/role/new.php',
            $roleForm->getData()
        );
    }
}
