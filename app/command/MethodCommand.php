<?php
namespace lab\command;

use lab\domain\Method;
use lab\validation\form\Method as MethodForm;
use lab\base\Success;
use lab\base\Error;
use lab\base\Redirect;

class MethodCommand extends Command
{
    public function __construct() {
        parent::__construct();
        $this->template->setLayout('app/view/admin/layout.php');
    }

    public function indexAction()
    {
        $mm = Method::getFinder();
        $methods = $mm->findAll();

        $this->render(
            'app/view/method/index.php',
            ['methods' => $methods]
        );
    }

    public function formAction($request)
    {
        $method = new Method();
        if ($id = $request->getProperty('id')) {
            $method = $method->find($id);
            if (is_null($method)) {
                new Redirect(
                    '?cmd=method-index',
                    new Error('Brak metody o podanym id.')
                );
            }
        }

        $methodForm = new MethodForm($method);
        $validation = $methodForm->handleRequest($request);

        if ($validation->isValid()) {
            $method = $methodForm->getData();
            $messageClass = new Success('Dane zostały zapisane');
            try {
                $method->save();
            } catch (\Exception $e) {
                $messageClass = new Error('Dane nie zostały zapisane. '.
                $e->getMessage());
            }
            new Redirect('?cmd=method', $messageClass);
        }
        return $this->render(
            'app/view/method/form.php',
            $methodForm->getData()
        );
    }
}
