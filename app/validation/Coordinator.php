<?php
namespace lab\validation;

class Coordinator
{
    private $raw;
    private $clean;
    private $errors = array();

    public function __construct($raw, $clean)
    {
        $this->raw = $raw;
        $this->clean = $clean;
    }

    public function get($name)
    {
        return $this->raw->getForValidation($name);
    }

    public function setClean($name = false)
    {
        if (!$name) {
            return false;
        }
        $this->clean = $this->clean->set(
            $name,
            $this->raw->getForValidation($name)
        );
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getCleanRequest()
    {
        return $this->clean;
    }
}
