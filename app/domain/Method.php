<?php
namespace lab\domain;

class Method extends DomainObject
{
    private $acronym;
    private $name;
    private $users;

    public function __construct($id = null, $acronym = null, $name = null)
    {
        parent::__construct($id);
        $this->acronym = $acronym;
        $this->name = $name;
//      self::getCollection("\\database\\domain\\Space");
    }

    public function setAcronym($acronym)
    {
        $this->acronym = $acronym;
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
