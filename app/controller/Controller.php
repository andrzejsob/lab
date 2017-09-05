<?php
namespace lab\controller;

use lab\base\ApplicationHelper as ApplicationHelper;
use lab\command\CommandResolver;

class Controller
{
    private function __construct() {}

    public static function run()
    {
        $inst = new Controller();
        $inst->init();
        $inst->handleRequest();
    }

    private function init()
    {
        $appHelper = ApplicationHelper::instance();
        $appHelper->init();
        $session = ApplicationHelper::getSession();
        $session->Impress();
    }

    private function handleRequest()
    {
        $request = ApplicationHelper::getRequest();
        $cmdResolver = new CommandResolver();
        list($class, $action) = $cmdResolver->resolveCommand($request);
        $cmdClass = new $class();
        $cmdClass->$action($request);
    }
}
