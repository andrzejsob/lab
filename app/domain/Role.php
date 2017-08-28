<?php
namespace lab\domain;

class Role extends DomainObject
{
    private $name;
    private $permissions = null;

    public function __construct($id = null, $name = null)
    {
        parent::__construct($id);
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPermissions()
    {
        if (is_null($this->permissions) && !is_null($this->getId())) {
            $pm = DomainObject::getFinder('Permission');
            $pColl = $pm->findByRole($this->getId());
            $this->permissions = $pColl;
        }
        return $this->permissions;
    }

    public function setName($name)
    {
        $this->name = $name;
//        $this->markDirty();
    }

    public function setPermissions($pColl)
    {
        $this->permissions = $pColl;
    }
}
