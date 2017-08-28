<?php
namespace lab\domain;

class Permission extends DomainObject
{
    private $name;

    public function __construct($id = null, $name = null)
    {
        parent::__construct($id);
        $this->name = $name;
    }

    public function setName($name)
    {
        $this->name = $name;
//        $this->markDirty();
    }

    public function getName()
    {
        return $this->name;
    }
}
