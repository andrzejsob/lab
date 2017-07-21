<?php
namespace lab\command;

class CommandResolver
{
    private static $defaultCmd;
    private $class = 'Default';
    private $action = 'default';

    public function resolveCommand(\lab\controller\Request $request)
    {
        $this->processClassAndAction($request);
        $array[] = '\\lab\\command\\'.$this->class.'Command';
        $array[] = $this->action.'Action';
        return $array;
    }

    private function processClassAndAction($request)
    {
        $cmd = $request->getProperty('cmd');
        if ($cmd) {
            if (strpos($cmd, '-')) {
                list($class, $action) = explode('-', $cmd);
                if(strpos($class, '_')) {
                    $class_array = explode('_', $class);
                    $class_array[1] = ucfirst($class_array[1]);
                    $class = implode($class_array);
                }
                $class = ucfirst($class);
                echo $class.$action;
                $this->checkIfClassAndActionExists($class, $action);
            } else {
                $this->aciton = 'error404';
            }
        }
    }

    private function checkIfClassAndActionExists($class, $action)
    {
        if(class_exists('\\lab\\command\\'.$class.'Command') &&
            is_subclass_of('\\lab\\command\\'.$class.'Command',
                        '\\lab\\command\\Command') &&
            method_exists('\\lab\\command\\'.$class.'Command',
                        $action.'Action')) {
                $this->class = $class;
                $this->action = $action;
            } else {
                $this->action = 'error404';
            }
    }
}
