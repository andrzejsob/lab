<?php
namespace lab\command;

use lab\domain\Order;
use lab\domain\ContactPerson;
use lab\domain\Client;
use lab\domain\Method;
use lab\mapper\MethodCollection;
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
        $order = new Order();
        $order->setContactPerson(new ContactPerson());
        $order->getContactPerson()->setClient(new Client());
        $order->setMethods(new MethodCollection());

        if ($id = $request->getProperty('id')) {
            $order = $order->find($id);
            if (is_null($order)) {
                new Redirect(
                    '?cmd=order',
                    new Error('Brak zlecenia o podanym id.')
                );
            }
        }

        $orderForm = new OrderForm($order);
        $validation = $orderForm->handleRequest($request);

        if($validation->isValid()) {
            echo '<pre>';
            print_r($order);
            echo '</pre>';exit;
        }

        return $this->render('app/view/order/form.php', $orderForm->getData());
    }
}
