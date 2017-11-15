<?php
namespace lab\command;

class DefaultCommand extends Command
{
    public function defaultAction($request)
    {
        $this->render('app/view/default.php');
    }

    public function error404Action()
    {
        $this->render('app/view/error404.php');
    }

    public function permissionErrorAction()
    {
        $this->render('app/view/permissionError.php');
    }
}
