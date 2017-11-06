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
    public function indexAction($request)
    {
        $roles = Role::getFinder()->findAll();

        return $this->render(
            'app/view/role/index.php',
            array('roles' => $roles)
        );
    }

    private function form($request, $role, $success, $error)
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
            $messageClass = new Success($success);
            try {
                $role->save();
                //zapisanie metod użytkownika do bazy
                DomainObject::getFinder('Permission')->updateRolePermissions(
                    $role->getId(),
                    $request->getProperty('permission')
                );
            } catch (\Exception $e) {
                $messageClass = new Error($error.$e->getMessage());
            }
            new Redirect('?cmd=role', $messageClass);
        }

        return $this->render('app/view/role/form.php', $roleForm->getData());
    }

    public function newAction($request)
    {
        $role = new Role();
        $role->setPermissions(new PermissionCollection());
        $success = 'Dodano nowe konto.';
        $error = 'Błąd zapisu. ';

        return $this->form($request, $role, $success, $error);
    }

    public function editAction($request)
    {
        $role = Role::getFinder()->find($request->getProperty('id'));
        if (is_null($role)) {
            new Redirect('?cmd=role', new Error('Brak konta o podanym id.'));
        }
        $success = 'Dane konta zostały zapisane.';
        $error = 'Bład edycji. ';

        return $this->form($request, $role, $success, $error);
    }

    public function deleteAction($request)
    {
        Role::getFinder()->delete($request->getProperty('id'));

        header('Location: ?cmd=role-index');
    }
}
