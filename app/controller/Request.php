<?php
namespace lab\controller;

class Request
{
    private $properties;
    private $feedback = array();

    public function __construct()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->properties = $_REQUEST;
        } else {
            $_SERVER['HTTP_USER_AGENT'] = 'console';
            foreach ($_SERVER['argv'] as $arg) {
                if (strpos($arg, '=')) {
                    list($key, $value) = explode('=', $arg);
                    $this->properties[$key] = $value;
                }
            }
        }
    }

    public function getProperty($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
        return null;
    }

    public function getForValidation($key)
    {
        return $this->getProperty($key);
    }

    public function setProperty($key, $val)
    {
        $this->property[$key] = $val;
    }

    public function addFeedback($msg)
    {
        $this->feedback[] = $msg;
    }

    public function getFeedback()
    {
        return $this->feedback;
    }
}
