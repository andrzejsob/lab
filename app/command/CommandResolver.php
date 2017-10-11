<?php
namespace lab\command;

use lab\base\Redirect;
use lab\domain\Permission;

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
        
        if (!$session->getLoggedIn()) {
            if ($cmd == 'login') {
                return array('\\lab\\command\\LoginCommand', 'indexAction');
            }
            new Redirect('?cmd=login');
        } elseif ($cmd == 'login' || $cmd == 'login-index') {
            new Redirect('?cmd=client');
        }

        if (!is_null($cmd)) {
            $this->setCommandFullName($cmd);
            if ($this->isCommandCorrect()) {
                $permArray = Permission::getFinder()->findAll()->getArray('name');
                $userPermArray = $session->getUser()->getPermissionsArray();
                if (in_array($cmd, $permArray) && !isset($userPermArray[$cmd])) {
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

    private function isCommandCorrect() {
        if(class_exists($this->command) &&
            is_subclass_of($this->command, '\\lab\\command\\Command') &&
            method_exists($this->command, $this->action)) {
            return true;
        }
        return false;
    }
}
