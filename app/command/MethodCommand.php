<?php
namespace lab\command;

use lab\mapper\MethodMapper;
use lab\mapper\UserMapper;
use lab\domain\User;
use lab\validation\form\Client as ClientForm;
use lab\validation\form\User as UserForm;

class MethodCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction()
    {
        $mm = new MethodMapper();
        $methods = $mm->findAll();

        $this->render(
            'app/view/method/index.php',
            ['methods' => $methods]
        );
    }
}
