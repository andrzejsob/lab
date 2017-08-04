<?php
namespace lab\command;

use lab\validation\Facade as ValidationFacade;
use lab\domain\Client as Client;

class ClientCommand extends Command
{
    public function newAction($request)
    {
        if (!$request->getProperty('submit')) {
            $this->assign('errors', false);
            $this->render('app/view/client/new.php');
        }

        $validation = new ValidationFacade();
        $validation->addNoEmptyValidation(
            'name',
            'Nazwa nie może być pusta'
        );
        $validation->addZipCodeValidation(
            'zip_code',
            'Kod pocztowy musi mieć format: 12-345'
        );

        if (!$validation->validate($request)) {
            $this->assign('errors', $validation->getErrors());
            $this->render('app/view/client/new.php');
        }

        $client = new Client;
        $client->setName($request->getProperty('name'));
        $client->setZipCode($request->getProperty('zip_code'));
        $client->save();
        header('Location: /lab');
    }
}
