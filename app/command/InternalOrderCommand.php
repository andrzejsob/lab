<?php
namespace lab\command;

class InternalOrderCommand extends Command
{
    public function listAction($request)
    {
        $ioMapper = new \lab\mapper\InternalOrderMapper();
        $io_coll = $ioMapper->findAll();
        $this->template->assign('orders', $io_coll);
        $this->template->setFile('app/view/internal_order/list.php');
        $this->render();
    }
}
