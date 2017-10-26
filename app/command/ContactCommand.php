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
        $contactsColl = ContactPerson::getFinder()->findAll();
        $this->template->assign('contacts', $contactsColl);
        return $this->render('app/view/contact/index.php');
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

    public function newAction($request)
    {
        $contact = new ContactPerson();
        $contact->setClient(new Client());
        $success = 'Dodano osobę do kontaktu: ';
        $error = 'Dane nie zostały zapisane';
        return $this->form($request, $contact, $success, $error);

    }

    public function editAction($request)
    {
        $contact = ContactPerson::find($request->getProperty('id'));
        if (is_null($contact)) {
            new Redirect(
                '?cmd=contact',
                new Error('Brak osoby do kontaktu')
            );
        }
        $success = 'Zmieniono dane osoby do kontaktu: ';
        $error = 'Dane nie zostały zapisane';
        return $this->form($request, $contact, $success, $error);
    }

    private function form($request, $contact, $success, $error)
    {
        $contactForm = new ContactForm($contact);
        $validation = $contactForm->handleRequest($request);

        if($validation->isValid()) {
            $messageClass;
            try {
                $contact->save();
                $messageClass = new Success(
                    $success.
                    $contact->getFirstName().' '.$contact->getLastName()
                );
            } catch (\Exception $e) {
                $messageClass = new Error($error.
                $e->getMessage());
            }
            new Redirect('?cmd=contact', $messageClass);
        }

        return $this->render(
            'app/view/contact/form.php',
            $contactForm->getData()
        );
    }
}
