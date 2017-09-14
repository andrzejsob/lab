<?php
namespace lab\domain;

class Permission extends DomainObject
{
    private $name;
    private $desc;

    public function __construct($id = null, $name = null, $desc = null)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->desc = $desc;
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

    public function setDescription($desc) {
        $this->desc = $desc;
    }

    public function getDescription() {
        return $this->desc;
    }
}
