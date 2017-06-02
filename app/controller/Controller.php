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
    }

    private function handleRequest()
    {
        $request = \lab\base\ApplicationHelper::getRequest();
        $cmdRsolver = new \lab\command\CommadResolver();
        $cmd = $cmdRsolver->getCommand($reequest);
        $cmd = execute($request);
    }
}
