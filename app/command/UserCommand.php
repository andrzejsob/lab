<?php
namespace lab\command;

use lab\domain\User;
use lab\mapper\RoleCollection;
use lab\mapper\MethodCollection;
use lab\validation\form\Client as ClientForm;
use lab\validation\form\User as UserForm;
use lab\base\Redirect;
use lab\base\Success;
use lab\base\Error;

class UserCommand extends Command
{
    public function indexAction()
    {
        $this->render(
            'app/view/user/index.php',
            ['users' => User::getFinder()->findAll()]
        );
    }

    private function form($request, $user, $success, $error)
    {
        $userForm = new UserForm($user);
        $validation = $userForm->handleRequest($request);

        if ($validation->isValid()) {
            $messageClass = new Success(
                $success.
                $user->getFirstName().' '.
                $user->getLastName()
            );
            try {
                $user->save();
            } catch (\Exception $e) {
                $messageClass = new Error($error.$e->getMessage());
            }
            new Redirect('?cmd=user', $messageClass);
        }
        $this->render('app/view/user/form.php', $userForm->getData());
    }

    public function newAction($request)
    {
        $user = new User();
        $user->setMethods(new MethodCollection());
        $user->setRoles(new RoleCollection());

        return $this->form(
            $request,
            $user,
            'Dodano uźytkownika: ',
            'Błąd zapisu. '
        );
    }

    public function editAction($request)
    {
        $user = User::find($request->getProperty('id'));
        if (is_null($user)) {
            new Redirect(
                '?cmd=user',
                new Error('Brak użytkownika.')
            );
        }

        return $this->form(
            $request,
            $user,
            'Zapisano dane uźytkownika: ',
            'Błąd edycji. '
        );
    }
}
