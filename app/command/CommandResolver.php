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
        $session = \lab\base\ApplicationHelper::getSession();
        if (!$session->getLoggedIn() && $cmd != 'login') {
            header('Location: ?cmd=login');
        }

        if (!is_null($cmd)) {
            $this->setCommandFullName($cmd);
            if ($this->commandIsCorrect()) {
                if ($this->command != '\\lab\\command\\LoginCommand' &&
                    !isset($session->getUser()->getPermissionsArray()[$cmd])) {
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
}
