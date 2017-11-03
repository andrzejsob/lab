<?php
namespace lab\command;

use lab\domain\Method;
use lab\validation\form\Method as MethodForm;
use lab\base\Success;
use lab\base\Error;
use lab\base\Redirect;

class MethodCommand extends Command
{
    public function indexAction()
    {
        $mm = Method::getFinder();
        $methods = $mm->findAll();

        $this->render(
            'app/view/method/index.php',
            ['methods' => $methods]
        );
    }

    public function newAction($request)
    {
        $method = new Method();
        $success = 'Dodano metodę badawczą:';
        $error = 'Błąd zapisu:';
        return $this->form($request, $method, $success, $error);
    }

    public function editAction($request)
    {
        $method = Method::find($request->getProperty('id'));
        if (is_null($method)) {
            new Redirect(
                '?cmd=method',
                new Error('Brak metody o podanym id.')
            );
        }
        $success = 'Zapisano dane dla metody:';
        $error = 'Błąd edycji:';
        return $this->form($request, $method, $success, $error);
    }

    private function form($request, $method, $successMessage, $errorMessage)
    {
        $methodForm = new MethodForm($method);
        $validation = $methodForm->handleRequest($request);

        if ($validation->isValid()) {
            $message = new Success($successMessage.' '.
                $method->getAcronym().' -> '.$method->getName());
            try {
                $method->save();
            } catch (\Exception $e) {
                $message = new Error($erroMessage.' '.
                $e->getMessage());
            }
            new Redirect('?cmd=method', $message);
        }
        return $this->render(
            'app/view/method/form.php',
            $methodForm->getData()
        );
    }
}
