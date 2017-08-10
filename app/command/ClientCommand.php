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
            ['clients' => $client]
        );
    }

    public function newAction($request)
    {
        if (!$request->getProperty('submit')) {
            $array = array(
                'name' => '',
                'city' => '',
                'street' => '',
                'zip_code' => '',
                'nip' => ''
            );
            $this->render('app/view/client/new.php', $array);
        }

        $validation = ClientValidation::handleRequest($request);
        //$cleanRequest = $validation->getCleanRequest();

        if ($validation->isValid()) {
            $array = array(
                'errors' => $validation->getErrors(),
                'name' => $cleanRequest->get('name'),
                'city' => $cleanRequest->get('city'),
                'street' => $cleanRequest->get('street'),
                'zip_code' => $cleanRequest->get('zip_code'),
                'nip' => $cleanRequest->get('street')
            );
            $this->render(
                'app/view/client/new.php', $array);
        }

        $client = new Client;
        $client->setName($cleanRequest->get('name'));
        $client->setStreet($cleanRequest->get('street'));
        $client->setZipCode($cleanRequest->get('zip_code'));
        $client->setCity($cleanRequest->get('city'));
        $client->setNip($cleanRequest->get('nip'));
        try {
            $client->save();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $errors = array('Klient o podanej nazwie istnieje w bazie');
                $this->render('app/view/client/new.php', $errors);
            }
        }
        header('Location: ?cmd=client-index');
    }

}
