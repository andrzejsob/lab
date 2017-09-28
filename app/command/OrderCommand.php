<?php
namespace lab\command;

use lab\domain\Order;
use lab\domain\ContactPerson;
use lab\domain\Client;
use lab\domain\Method;
use lab\mapper\MethodCollection;
use lab\base\Success;
use lab\base\Error;
use lab\base\Redirect;
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

    public function newAction($request)
    {
        $order = new Order();
        $order->setContactPerson(new ContactPerson());
        $order->getContactPerson()->setClient(new Client());
        $order->setMethods(new MethodCollection());

        $orderForm = new OrderForm($order);
        $validation = $orderForm->handleRequest($request);

        if($validation->isValid()) {
            $messageClass;
            try {
                $order->insert();
                $messageClass = new Success(
                    'Zarejestrowano zlecenie: '.
                    $order->getCode()
                );
            } catch (\Exception $e) {
                $messageClass = new Error('Dane nie zostały zapisane. '.
                $e->getMessage());
            }
            new Redirect('?cmd=order', $messageClass);
        }

        return $this->render('app/view/order/form.php', $orderForm->getData());
    }

    public function editAction($request)
    {
        $order = Order::find($request->getProperty('id'));
        if (is_null($order)) {
            new Redirect('?cmd=order', new Error('Brak zlecenia o podanym id.'));
        }
        $orderForm = new OrderForm($order);
        $validation = $orderForm->handleRequest($request);

        if ($validation->isValid()) {
            $messageClass;
            try {
                $order->update();
                $messageClass = new Success(
                    'Zlecenie nr: '.$order->getCode().' zostało zapisane');
            } catch (\Exception $e) {
                $messageClass = new Error('Dane nie zostały zapisane. '.
                $e->getMessage());
            }
            new Redirect('?cmd=order', $messageClass);
        }

        return $this->render('app/view/order/form.php', $orderForm->getData());
    }
}
