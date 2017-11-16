<?php
namespace lab\command;

use lab\domain\User;
use lab\base\Redirect;
use lab\validation\form\ForgotPassword as ForgotPasswordForm;
use lab\validation\form\Login as LoginForm;
use lab\base\Success;
use lab\domain\UserAccount;

class LoginCommand extends Command
{
    public function indexAction($request)
    {
        $user = new User();
        $loginForm = new LoginForm($user);
        $validation = $loginForm->handleRequest($request);
        if ($validation->isValid()) {
            $authUser = $user->authenticate();
            if ($authUser) {
                //zapisanie użytkownika do sesji
                \lab\base\ApplicationHelper::getSession()->login($authUser);
                new Redirect('?cmd=client');
            }
            return $this->render(
                'app/view/login/form.php',
                array('errors' => array('Błędny login lub hasło'),
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
        new Redirect('?cmd=login');
    }

    public function forgotPasswordAction($request)
    {
        $rawUser = new User();
        $forgotPasswordForm = new ForgotPasswordForm($rawUser);
        $validation = $forgotPasswordForm->handleRequest($request);
        if ($validation->isValid()) {
            $user = User::getFinder()->findByEmail($rawUser->getEmail());
            if ($user) {
                $account = new UserAccount();
                $password = $account->generateRandomPassword();
                new Redirect(
                    '?cmd=login',
                    new Success('Hasło zostało wysłane na podany adres e-mail.
                                <br />Zaloguj się podając nowe hasło.')
                );
            }
            return $this->render(
                'app/view/login/forgotPassword.php',
                array('errors' => array('Błędny e-mail'),
                      'entity' => new User())
            );
        }

        return $this->render(
            'app/view/login/forgotPassword.php',
            $forgotPasswordForm->getData()
        );
    }
}
