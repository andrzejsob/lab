<?php
namespace lab\command;

use lab\mapper\MethodMapper;
use lab\mapper\UserMapper;
use lab\domain\User;
use lab\validation\form\Client as ClientForm;
use lab\validation\form\User as UserForm;

class AdminCommand extends Command
{

    public function indexAction()
    {
        $uMapper = new UserMapper();
        $users = $uMapper->findAll();

        $this->render(
            'app/view/admin/index.php',
            ['users' => $users]
        );
    }

    public function panelAction($request)
    {
        $userMapper = new UserMapper();
        $users = $userMapper->findAll();
        //print_r($users);exit;
        $this->assign('users', $users);
        $this->render('app/view/admin/panel.php');
    }

    public function userAction($request)
    {
        $user = new User();
        $mm = new MethodMapper();
        //pobranie wszystkich method
        $allMethods = $mm->findAll();
        //zapisanie macierzy metod użytkownika
        $userMethodsArray = [];
        if($request->getProperty('id')) {
            $user = User::find($request->getProperty('id'));
            //pobranie metod użytkownika
            $userMethods = $mm->findByUser($user->getId());
            //transformacja method uzytkownika z kolekcji obiektów na macierz
            foreach ($userMethods as $method) {
                $userMethodsArray[$method->getAcronym()] = $method->getId();
            }
        }

        $userForm = new UserForm($user);
        //print_r($userForm->getData());
        $validation = $userForm->handleRequest($request);

        if ($validation->isValid()) {
            //pobranie obiektu użytkownika
            $user = $userForm->getData();
            //zapisanie danych użytkownika do bazy
            $user->save();
            //zapisanie metod użytkownika do bazy
            $mm->updateUserMethods(
                $user->getId(),
                $request->getProperty('method')
            );
            header('Location: ?cmd=admin-panel');
        }

        $this->assign('methods', $allMethods);
        $this->assign('userMethods', $userMethodsArray);
        print_r($userForm->getData());
        $this->render('app/view/admin/user.php', $userForm->getData());
        //header('Location: ?cmd=admin-user&id='.$userId);
    }
}
