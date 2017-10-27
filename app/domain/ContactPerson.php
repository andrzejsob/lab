<?php
namespace lab\domain;

use lab\domain\Client;

class ContactPerson extends DomainObject
{
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $client = null;

    public function __construct(
        $id = null,
        $first_name = null,
        $last_name = null,
        $email = null,
        $phone = null
    )
    {
        parent::__construct($id);
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(Client $obj)
    {
        $this->client = $obj;
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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
