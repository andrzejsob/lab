<?php
namespace lab\command;

use lab\domain\Client as Client;
use lab\controller\Request;
use lab\base\Redirect;
use lab\base\Success;
use lab\base\Error;
use lab\base\ApplicationHelper;
use lab\domain\ContactPerson;
use lab\validation\form\Contact as ContactForm;

class ContactCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction()
    {
        $userId = ApplicationHelper::getSession()->getUser()->getId();
        $contactsColl = ContactPerson::getFinder()->findByUser($userId);
        $this->template->assign('contacts', $contactsColl);
        return $this->render('app/view/contact/index.php');
    }

    /*
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


    public function showAction(Request $request)
    {
        $client = new Client();
        $id = $request->getProperty('id');
        $client = $client->find($id);
        if (is_null($client)) {
            new Redirect(
                '?cmd=client',
                new Error('Brak klienta o podanym id.')
            );
        }

        $contractsColl = Client::getFinder('InternalOrder')
            ->selectByClientId($client->getId());
        if(!$contractsColl->valid()) {
            new Redirect(
                '?cmd=client',
                new Error('Brak zleceń klienta.')
            );
        }
        $this->assign('contracts', $contractsColl);
        $this->render('app/view/client/show.php');
    }
    */
    public function newAction($request)
    {
        $contact = new ContactPerson();
        $contact->setClient(new Client());

        $contactForm = new ContactForm($contact);
        $validation = $contactForm->handleRequest($request);

        if($validation->isValid()) {
            $messageClass;
            try {
                $contact->save();
                $messageClass = new Success(
                    'Dodano osobę do kontaktu: '.
                    $contact->getFirstName().' '.$contact->getLastName()
                );
            } catch (\Exception $e) {
                $messageClass = new Error('Dane nie zostały zapisane. '.
                $e->getMessage());
            }
            new Redirect('?cmd=contact', $messageClass);
        }

        return $this->render('app/view/contact/form.php', $contactForm->getData());
    }
}
