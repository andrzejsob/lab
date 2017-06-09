<?php
namespace lab\command;

class PersonCommand extends Command
{
    public function listAction($request)
    {
        $personMapper = new \lab\mapper\ContactPersonMapper();
        $person_coll = $personMapper->findAll();
        $this->render('app/view/person/list.php', array(
            'persons' => $person_coll
        ));
    }
}
