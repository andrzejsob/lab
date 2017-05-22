<?php
namespace lab\domain;

class ContactPerson extends DomainObject
{
    private $firstName;
    private $lastName;
    private $email;
    private $email2;
    private $phone;
    private $client;

    public function __construct(
        $id = null,
        $client_id = null,
        $first_name = null,
        $last_name = null,
        $email = null,
        $email2 = null,
        $phone = null
    )
    {
        parent::__construct($id);
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->email = $email;
        $this->email2 = $email2;
        $this->phone = $phone;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(DomainObject $obj)
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

    public function setEmail2($email2)
    {
        $this->email2 = $email2;
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

    public function getEmail2()
    {
        return $this->email2;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
