<?php
namespace lab\command;

use lab\domain\Client as Client;
use lab\mapper\ClientMapper;
use lab\validation\form\Client as ClientValidation;

class ClientCommand extends Command
{

    public function indexAction()
    {
        $clientMapper = new ClientMapper;
        $clients = $clientMapper->findAll();
        $this->render(
            'app/view/client/index.php',
            ['clients' => $clients]
        );
    }

    public function newAction($request)
    {
        if (!$request->getProperty('submit')) {
            $this->render('app/view/client/new.php');
        }

        $validation = ClientValidation::addValidators();
        $validation->validate($request);
        $cleanRequest = $validation->getCleanRequest();

        if (!$validation->isValid()) {
            $this->render(
                'app/view/client/new.php',
                ['errors' => $validation->getErrors(), 'clean' => $cleanRequest]
            );
        }

        $client = new Client;
        $client->setName($cleanRequest->get('name'));
        $client->setStreet($cleanRequest->get('street'));
        $client->setZipCode($cleanRequest->get('zip_code'));
        $client->setCity($cleanRequest->get('city'));
        $client->save();

        header('Location: ?cmd=client-index');
    }

}
