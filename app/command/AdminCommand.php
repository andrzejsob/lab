<?php
namespace lab\command;

use lab\mapper\MethodMapper;
use lab\validation\form\Client as ClientForm;

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

    public function userAction($request)
    {
        //$user = new User();
        //$user = $user->find($request->getProperty('id'));
        $userId = $request->getProperty('id');
        $mm = new MethodMapper();
        //aktualizacja metod uzytkownika w bazie danych
        if ($request->getProperty('submit')) {
            $mm->updateUserMethods(
                $userId,
                $request->getProperty('method')
            );
        }
        //pobranie wszystkich method
        $allMethods = $mm->findAll();
        //pobranie metod użytkownika
        $userMethods = $mm->findByUser($userId);
        //transformacja method uzytkownika z kolekcji obiektów na macierz
        $userMethodsArray = [];
        foreach ($userMethods as $method) {
            $userMethodsArray[$method->getAcronym()] = $method->getId();
        }

        $this->assign('methods', $allMethods);
        $this->assign('userMethods', $userMethodsArray);
        $this->render('app/view/admin/user.php');
        //header('Location: ?cmd=admin-user&id='.$userId);
    }
}
