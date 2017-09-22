<?php
namespace lab\command;

use lab\domain\Order;

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
        $order = new Order;

        $clients = Order::getFinder('Client')->findAll();
        $methods = Order::getFinder('Method')->findAll();
        $this->assign('clients', $clients);
        $this->assign('methods', $methods);
        $this->assign('entity', $order);
        return $this->render('app/view/order/form.php');
    }
}
