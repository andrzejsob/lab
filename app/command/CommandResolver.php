<?php
namespace lab\command;

use lab\base\Redirect;
use lab\domain\Permission;

class CommandResolver
{
    private static $defaultCmd;
    private $command;
    private $action;
    private $commandFullName;
    private $actionFullName;
    private $session;
    private $defaultCommand = '\\lab\\command\\DefaultCommand';
    private $errorAction = 'error404Action';

    public function resolveCommand(\lab\controller\Request $request)
    {
        $cmd = $request->getProperty('cmd');
        $this->session = \lab\base\ApplicationHelper::getSession();

        if (!$this->session->getLoggedIn()) {
            if ($cmd == 'login') {
                return array('\\lab\\command\\LoginCommand', 'indexAction');
            }
            new Redirect('?cmd=login');
        } elseif ($cmd == 'login' || $cmd == 'login-index') {
            new Redirect('?cmd=client');
        }

        if (!is_null($cmd)) {
            $this->setNames($cmd);
            if ($this->isCommandCorrect()) {
                if ($this->userHasAccess($cmd)) {
                    return array($this->commandFullName, $this->actionFullName);
                }
                return array($this->defaultCommand, 'permissionErrorAction');
            }
        }

        return array($this->defaultCommand, $this->errorAction);
    }

    private function userHasAccess($cmd)
    {
        $permArray = Permission::getFinder()->findAll()->getArray('name');
        $userPermArray = $this->session->getUser()->getPermissionsArray();
        if (isset($userPermArray[$cmd]) || $this->command == 'login') {
            return true;
        }
        if (!in_array($cmd, $permArray) && $userPermArray[$this->command]) {
            return true;
        }

        return false;
    }

    private function setNames($cmd)
    {
        if(strpos($cmd, '-')) {
            list($this->command, $this->action) = explode('-', $cmd);
        } else {
            $this->command = $cmd;
            $this->action = 'index';
        }
        $this->commandFullName = '\\lab\\command\\'.
            ucfirst($this->command).'Command';
        $this->actionFullName = $this->action.'Action';
    }

    private function isCommandCorrect() {
        if(class_exists($this->commandFullName) &&
            is_subclass_of($this->commandFullName, '\\lab\\command\\Command') &&
            method_exists($this->commandFullName, $this->actionFullName)) {
            return true;
        }
        return false;
    }
}
