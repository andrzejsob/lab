<?php
namespace lab\command;

use lab\domain\Order;
use lab\domain\ContactPerson;
use lab\domain\Client;
use lab\validation\form\Order as OrderForm;

class OrderCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction($request)
    {
        $io_coll = Order::getFinder()->findAll();
        $this->template->assign('orders', $io_coll);
        return $this->render('app/view/order/index.php');
    }

    public function formAction($request)
    {
        var_dump($request->getProperty('clientId'));
        $order = new Order();
        $order->setContactPerson(new ContactPerson());
        $order->getContactPerson()->setClient(new Client());

        $clients = Order::getFinder('Client')->findAll();
        $methods = Order::getFinder('Method')->findAll();

        $orderForm = new OrderForm($order);
        $validation = $orderForm->handleRequest($request);

        if($validation->isValid()) {
            echo 'Formularz poprawny';exit;
        }
        $this->assign('selectedClient', $order->getContactPeron()->getClient());
        $clientContactPersons =
        $this->assign('selectedClientContacts', )
        $this->assign('seletedContacts',)
        $this->assign('clients', $clients);
        $this->assign('methods', $methods);
        return $this->render('app/view/order/form.php', $orderForm->getData());
    }
}
