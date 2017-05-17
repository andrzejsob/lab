<?php
namespace lab\domain;

class Method extends DomainObject
{
    private $acronym;
    private $name;
    private $users;

    public function __construct($acronym = null, $name = null, $id = null)
    {
        $this->acronym = $acronym;
        $this->name = $name;
//      self::getCollection("\\database\\domain\\Space");
        parent::__construct($id);
    }

    public function setAcronym($acronym)
    {
        $this->name = $acronym;
//        $this->markDirty();
    }

    public function setName($name)
    {
        $this->name = $name;
//        $this->markDirty();
    }

    public function getAcronym()
    {
        return $this->acronym;
    }

    public function getName()
    {
        return $this->name;
    }
}
