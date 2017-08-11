<?php
namespace lab\command;

use lab\domain\Client as Client;
use lab\mapper\ClientMapper;
use lab\validation\form\Client as ClientForm;

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
        $client = new Client();

        $clientForm = new ClientForm($client);
        $validation = $clientForm->handleRequest($request);

        if ($validation->isValid()) {
            $client = $clientForm->getData();
            echo '<pre>';
            print_r($client);
            echo '</pre>';exit;
            header('Location: ?cmd=client-index');
        }
        
        $this->render('app/view/client/new.php', $clientForm->getData());
    }
}
