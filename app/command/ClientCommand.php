<?php
namespace lab\command;

use lab\domain\Client as Client;
use lab\domain\Order;
use lab\controller\Request;
use lab\base\ApplicationHelper;
use lab\base\Redirect;
use lab\base\Success;
use lab\base\Error;
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
    public function newAction(Request $request)
    {
        $client = new Client();
        $success = 'Dodano nowego klienta: ';
        $error = 'Błąd zapisu.';
        return $this->form($request, $client, $success, $error);
    }

    public function editAction(Request $request)
    {
        $client = Client::find($request->getProperty('id'));
        if (is_null($client)) {
            new Redirect('?cmd=client', new Error('Brak klienta o podanym id.'));
        }
        $success = 'Zmieniono dane klienta: ';
        $error = 'Błąd zapisu.';
        return $this->form($request, $client, $success, $error);
    }

    public function form($request, $client, $success, $error)
    {
        $clientForm = new ClientForm($client);
        $validation = $clientForm->handleRequest($request);

        if ($validation->isValid()) {
            try {
                $client->save();
            } catch (\Exception $e) {
                $message = new Error($error.' '.
                $e->getMessage());
            }
            new Redirect(
                '?cmd=client',
                new Success($success. $client->getName())
            );
        }

        $this->render('app/view/client/form.php', $clientForm->getData());
    }
    /**
     * @param  Request
     */
    public function showAction(Request $request)
    {
        $client = Client::find($request->getProperty('id'));
        if (is_null($client)) {
            new Redirect('?cmd=client', new Error('Brak klienta'));
        }

        $ordersColl = Order::getFinder()->findByClientAndUser(
            $client->getId(),
            ApplicationHelper::getSession()->getUser()->getId()
        );

        $this->assign('client', $client);
        $this->assign('contracts', $ordersColl);
        $this->render('app/view/client/show.php');
    }
}
