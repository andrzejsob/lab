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
        $client = new Client;

        $validation = ClientValidation::handleRequest($request, $client);
        //$cleanRequest = $validation->getCleanRequest();

        if ($validation->isValid()) {
            header('Location: ?cmd=client-index');
        } else {
        //    var_dump($validation->getErrors());exit;
        //    $this->assign('errors', $validation->getErrors());
        }
        $this->assign('clean', $client);
        $this->render('app/view/client/new.php');
    }

}
