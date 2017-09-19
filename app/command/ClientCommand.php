<?php
namespace lab\command;

use lab\domain\Client as Client;
use lab\controller\Request;
use lab\base\Redirect;
use lab\base\Success;
use lab\validation\form\Client as ClientForm;

class ClientCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction()
    {
        $clients = Client::getFinder()->findAll();
        $this->render(
            'app/view/client/index.php',
            ['clients' => $clients]
        );
    }

    /**
     * @param  Request $request
     */
    public function formAction(Request $request)
    {
        $client = new Client();

        if ($id = $request->getProperty('id')) {
            $client = $client->find($id);
            if (is_null($client)) {
                new Redirect(
                    '?cmd=client',
                    new Error('Brak klienta o podanym id.')
                );
            }
        }

        $clientForm = new ClientForm($client);
        $validation = $clientForm->handleRequest($request);

        if ($validation->isValid()) {
            $client = $clientForm->getData();
            $client->save();
            new Redirect(
                '?cmd=client',
                new Success('Dane klienta zostały zapisane')
            );
        }

        $this->render('app/view/client/form.php', $clientForm->getData());
    }

    /**
     * @param  Request
     */
    public function showAction(Request $request)
    {
        $client = new Client();
        if ($id = $request->getProperty('id')) {
            $client = $client->find($id);
            if (is_null($client)) {
                new Redirect(
                    '?cmd=client',
                    new Error('Brak klienta o podanym id.')
                );
            }
        }
        $contactsColl = $client->getContactPersons();
        $this->assign('contacts', $contactsColl);
        $this->render('app/view/client/show.php');
    }
}
