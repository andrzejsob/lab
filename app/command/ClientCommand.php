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
        try {
            $client->save();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $error = array('Klient o podanej nazwie istnieje w bazie');
                $this->render('app/view/client/new.php', ['errors' => $error]);
            }
        }

        header('Location: ?cmd=client-index');
    }

}
