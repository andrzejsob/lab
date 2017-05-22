<?php
namespace lab\domain;

class User extends DomainObject
{
    private $nick;
    private $firstName;
    private $lastName;
    private $passwordMd5;
    private $email;
    private $methods;

    public function __construct(
        $id = null,
        $nick = null,
        $password_md5 = null,
        $first_name = null,
        $last_name = null,
        $email = null
    )
    {
        parent::__construct($id);
        $this->nick = $nick;
        $this->passwordMd5 = $password_md5;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->email = $email;
//      self::getCollection("\\database\\domain\\Space");

    }

    public function getMethods()
    {
        return $this->methods;
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

    public function setMethods($method_coll)
    {
        $this->methods = $method_coll;
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
