<?php
namespace lab\command;

use lab\domain\User;
use lab\base\Redirect;
use lab\validation\form\Login as LoginForm;
use lab\base\Success;

class LoginCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction($request)
    {
        $user = new User();
        $loginForm = new LoginForm($user);
        $validation = $loginForm->handleRequest($request);
        if ($validation->isValid()) {
            $user = $loginForm->getData();
            $authUser = $user->authenticate();
            if ($authUser) {
                //zapisanie użytkownika do sesji
                \lab\base\ApplicationHelper::getSession()->login($authUser);
                new Redirect('?cmd=user', new Success('Logowanie sie powiodło'));
            }
            return $this->render(
                'app/view/login/form.php',
                array('errors' => ['Błedny login lub hasło'],
                      'entity' => new User())
            );
        }
        return $this->render(
            'app/view/login/form.php',
            $loginForm->getData()
        );
    }

    public function logoutAction()
    {
        \lab\base\ApplicationHelper::getSession()->logout();
        new Redirect('?cmd=login', new Success('Wylogowanie się powiodło'));
    }
}
