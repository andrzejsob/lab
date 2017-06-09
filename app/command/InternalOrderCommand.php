<?php
namespace lab\command;

class PersonCommand extends Command
{
    public function listAction($request)
    {
        $personMapper = new \lab\mapper\ContactPersonMapper();
        $person_coll = $personMapper->findAll();
        $this->template->set('persons', $person_coll);
        $this->template->setTemplate('app/view/internal_order/list.php');
        $this->render();
    }
}
