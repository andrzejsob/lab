<?php
namespace lab\command;

use \lab\mapper\InternalOrderMapper;

class InternalOrderCommand extends Command
{
    public function listAction($request)
    {
        $ioMapper = new InternalOrderMapper();
        $io_coll = $ioMapper->findAll();
        $this->template->assign('orders', $io_coll);
        $this->template->setFile('app/view/internal_order/list.php');
        $this->render();
    }
}
