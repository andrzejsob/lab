<?php
namespace lab\controller;

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
        $appHelper = \lab\base\ApplicationHelper::instance();
        $appHelper->init();
        $session = \lab\base\ApplicationHelper::getSession();
        $session->Impress();
    }

    private function handleRequest()
    {
        $request = \lab\base\ApplicationHelper::getRequest();
        $cmdResolver = new \lab\command\CommandResolver();
        list($class, $action) = $cmdResolver->resolveCommand($request);
        $cmdClass = new $class();
        $cmdClass->$action($request);
    }
}
