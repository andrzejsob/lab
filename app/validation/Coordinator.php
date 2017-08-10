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
        $getForValidation = 'get'.ucfirst($name);
        return $this->raw->$getForValidation();
    }

    public function setClean($name = false)
    {
        if (!$name) {
            return false;
        }
      //  $this->clean = $this->clean->set(
      //      $name,
      //      $this->raw->getForValidation($name)
    //    );
        $setMethod = 'set'.ucfirst($name);
        $getMethod = 'get'.ucfirst($name);
        $this->clean = $this->clean->$setMethod($this->raw->$getMethod());
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getClean()
    {
        return $this->clean;
    }
}
