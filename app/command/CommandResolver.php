<?php
namespace lab\command;

class CommandResolver
{
    private static $defaultCmd;
    private $command;
    private $action;
    private $defaultCommand = '\\lab\\command\\DefaultCommand';
    private $errorAction = 'error404Action';

    public function resolveCommand(\lab\controller\Request $request)
    {
        $cmd = $request->getProperty('cmd');
        if (!is_null($cmd)) {
            $this->setCommandFullName($cmd);
            if ($this->commandIsCorrect()) {
                //$user = ApplicationHelper::getSession()->getUser();
                if (!is_null($user) &&
                    !isset($user->getPermissionsArray[$cmd])) {
                    return array($this->defaultCommand, 'permissionErrorAction');
                }
                return array($this->command, $this->action);
            }
        }

        return array($this->defaultCommand, $this->errorAction);
    }

    private function setCommandFullName($cmd)
    {
        $command = '';
        $action = '';
        if(strpos($cmd, '-')) {
            list($command, $action) = explode('-', $cmd);
        } else {
            $command = $cmd;
            $action = 'index';
        }

        $this->command = '\\lab\\command\\'.ucfirst($command).'Command';
        $this->action = $action.'Action';
    }

    private function commandIsCorrect() {
        if(class_exists($this->command) &&
            is_subclass_of($this->command, '\\lab\\command\\Command') &&
            method_exists($this->command, $this->action)) {
            return true;
        }
        return false;
    }

    /*
    private function processClassAndAction($request)
    {
        $cmd = $request->getProperty('cmd');
        if (!is_null($cmd)) {
            if (strpos($cmd, '-')) {
                list($class, $action) = explode('-', $cmd);
                if(strpos($class, '_')) {
                    $class_array = explode('_', $class);
                    $class_array[1] = ucfirst($class_array[1]);
                    $class = implode($class_array);
                }
                $class = ucfirst($class);
                $this->checkIfClassAndActionExists($class, $action);
            } else {
                $this->action = 'error404';
            }
        }
    }

    private function checkIfClassAndActionExists($class, $action)
    {
        $classPath = '\\lab\\command\\'.$class.'Command';
        $actionName = $action.'Action';
        if(class_exists($classPath) &&
            is_subclass_of($classPath, '\\lab\\command\\Command') &&
            method_exists($classPath, $actionName)) {
                $this->class = $class;
                $this->action = $action;
            } else {
                $this->action = 'error404';
            }
    }
    */
}
