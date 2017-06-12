<?php
namespace lab\command;

class ClientCommand extends Command
{
    public function newAction($request)
    {
        if(!$request->getProperty('submit')) {
            $this->render('app/view/client/new.php');
        }
    }
}
