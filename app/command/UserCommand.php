<?php
namespace lab\command;

use lab\mapper\MethodMapper;
use lab\mapper\UserMapper;
use lab\mapper\RoleMapper;
use lab\domain\User;
use lab\validation\form\Client as ClientForm;
use lab\validation\form\User as UserForm;
use lab\base\Redirect;
use lab\base\Success;
use lab\base\Error;

class UserCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction()
    {
        $uMapper = new UserMapper();
        //getting list of users from database
        $users = $uMapper->findAll();

        $this->render(
            'app/view/user/index.php',
            ['users' => $users]
        );
    }

    public function formAction($request)
    {
        $user = new User();
        $mm = new MethodMapper();
        $rm = new RoleMapper();
        //getting all methods
        $allMethods = $mm->findAll();
        $allRoles = $rm->findAll();
        //creation of user methods array
        $userMethodsArray = [];
        $userRolesArray = [];
        if($id = $request->getProperty('id')) {
            $user = User::find($id);
            if (is_null($user)) {
                new Redirect(
                    '?cmd=user-index',
                    new Error('Brak użytkownika o podanym id.')
                );
            }
            //pobranie metod użytkownika do macierzy
            $userMethodsArray = $user->getMethods()->getArray('acronym');
            //pobrane metod użytkownika do macirzy
            $userRolesArray = $user->getRoles()->getArray('name');
        }

        $userForm = new UserForm($user);
        $validation = $userForm->handleRequest($request);

        if ($validation->isValid()) {
            $messageClass = new Success('Dane zostały zapisane');
            try {
                //zapisanie danych użytkownika do bazy
                $user->save();
                //zapisanie metod użytkownika do bazy
                $mm->updateUserMethods(
                    $user->getId(),
                    $request->getProperty('method')
                );
                $rm->updateUserRoles(
                    $user->getId(),
                    $request->getProperty('role')
                );
            } catch (\Exception $e) {
                $messageClass = new Error('Dane nie zostały zapisane. '.
                $e->getMessage());
            }
            new Redirect('?cmd=user', $messageClass);
        }

        $this->assign('methods', $allMethods);
        $this->assign('userMethods', $userMethodsArray);
        $this->assign('roles', $allRoles);
        $this->assign('userRoles', $userRolesArray);
        $this->render('app/view/user/form.php', $userForm->getData());
    }
}
