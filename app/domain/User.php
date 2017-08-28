<?php
namespace lab\domain;

class User extends DomainObject
{
    private $nick;
    private $firstName;
    private $lastName;
    private $passwordMd5;
    private $email;
    private $methods = null;
    private $roles = null;

    public function __construct(
        $id = null,
        $nick = null,
        $passwordMd5 = null,
        $firstName = null,
        $lastName = null,
        $email = null
    )
    {
        parent::__construct($id);
        $this->nick = $nick;
        $this->passwordMd5 = $passwordMd5;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
//      self::getCollection("\\database\\domain\\Space");

    }

    public function getMethods()
    {
        if (is_null($this->methods) && !is_null($this->getId())) {
            $mm = User::getFinder('Method');
            $mColl = $mm->findByUser($this->getId());
            $this->methods = $mColl;
        }
        return $this->methods;
    }

    public function getRoles()
    {
        if (is_null($this->roles) && !is_null($this->getId())) {
            $rm = User::getFinder('Role');
            $rColl = $rm->findByUser($this->getId());
            $this->roles = $rColl;
        }
        return $this->roles;
    }

    public function setNick($nick)
    {
        $this->nick = $nick;
//        $this->markDirty();
    }

    public function setFirstName($name)
    {
        $this->firstName = $name;
//        $this->markDirty();
    }

    public function setLastName($name)
    {
        $this->lastName = $name;
//        $this->markDirty();
    }

    public function setPasswordMd5($pass)
    {
        $this->passwordMd5 = md5($pass);
//        $this->markDirty();
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMethods($methodColl)
    {
        $this->methods = $methodColl;
    }

    public function setRoles($roleColl)
    {
        $this->roles = $roleColl;
    }

    public function getNick()
    {
        return $this->nick;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPasswordMd5()
    {
        return $this->passwordMd5;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
