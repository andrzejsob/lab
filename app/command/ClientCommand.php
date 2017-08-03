<?php
namespace lab\command;

use lab\validation\Facade as ValidationFacade;

class ClientCommand extends Command
{
    public function newAction($request)
    {
        if (!$request->getProperty('submit')) {
            $this->assign('errors', false);
            $this->render('app/view/client/new.php');
        }

        $validation = new ValidationFacade();
        $validation->addNoEmptyValidation('name', 'Nazwa nie może być pusta');

        if (!$validation->validate($request)) {
            $this->assign('errors', $validation->getErrors());
            $this->render('app/view/client/new.php');
        }
        echo 'dupa';
    }
}
