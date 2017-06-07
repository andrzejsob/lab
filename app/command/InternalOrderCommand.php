<?php
namespace lab\command;

class InternalOrderCommand
{
    public function listAction($request)
    {
        $ioMapper = new \lab\mapper\InternalOrderMapper();
        $order_coll = $ioMapper->findAll();
        include('app/view/InternalOrderList.php');
    }
}
