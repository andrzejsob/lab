<?php
namespace lab\base;

use lab\base\ApplicationHelper;

abstract class Message
{
    protected $message;
    protected $session;

    public function __construct($message)
    {
        $this->message = $message;
        $this->session = $appHelper = ApplicationHelper::instance()->getSession();
    }

    abstract public function setMessage();
}
