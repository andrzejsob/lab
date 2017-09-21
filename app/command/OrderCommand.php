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
        $clients = Order::getFinder('Client')->findAll();

        $this->assign('clients', $clients);
        return $this->render('app/view/order/form.php');
    }
}
