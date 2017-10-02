<?php
namespace lab\command;

use lab\mapper\RoleMapper;
use lab\mapper\PermissionCollection;
use lab\domain\DomainObject;
use lab\domain\Role;
use lab\validation\form\Client as ClientForm;
use lab\validation\form\Role as RoleForm;
use lab\base\Redirect;
use lab\base\Success;
use lab\base\Error;

class RoleCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction($request)
    {
        //$rMapper = new RoleMapper();
        $roles = Role::getFinder()->findAll();

        return $this->render(
            'app/view/role/index.php',
            ['roles' => $roles]
        );
    }

    public function formAction($request)
    {
        $role = new Role();
        $role->setPermissions(new PermissionCollection());

        if ($id = $request->getProperty('id')) {
            $role = $role->find($id);
            if (is_null($role)) {
                new Redirect(
                    '?cmd=role',
                    new Error('Brak konta o podanym id.')
                );
            }
        }

        $roleForm = new RoleForm($role);
        $validation = $roleForm->handleRequest($request);

        if ($validation->isValid()) {
            $messageClass = new Success('Dane zostały zapisane');
            try {
                $role->save();
                //zapisanie metod użytkownika do bazy
                DomainObject::getFinder('Permission')->updateRolePermissions(
                    $role->getId(),
                    $request->getProperty('permission')
                );
            } catch (\Exception $e) {
                $messageClass = new Error('Dane nie zostały zapisane. '.
                $e->getMessage());
            }
            new Redirect('?cmd=role', $messageClass);
        }

        return $this->render('app/view/role/new.php', $roleForm->getData());
    }

    public function deleteAction($request)
    {
        Role::getFinder()->delete($request->getProperty('id'));

        header('Location: ?cmd=role-index');
    }
}
