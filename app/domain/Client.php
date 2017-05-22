<?php
namespace lab\domain;

class Client extends DomainObject
{
    private $name;
    private $street;
    private $zipCode;
    private $city;
    private $nip;
    private $contact_persons;

    public function __construct(
        $id = null,
        $name = null,
        $street = null,
        $zip_code = null,
        $city = null,
        $nip = null
    )
    {
        parent::__construct($id);
        $this->name = $name;
        $this->street = $street;
        $this->zipCode = $zip_code;
        $this->city = $city;
        $this->nip = $nip;
//      self::getCollection("\\database\\domain\\Space");
    }

    public function getContactPersons()
    {
        return $this->contact_persons;
    }

    public function setName($name)
    {
        $this->name = $name;
//        $this->markDirty();
    }

    public function setStreet($street)
    {
        $this->street = $street;
//        $this->markDirty();
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setNip($nip)
    {
        $this->nip = $nip;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getNip()
    {
        return $this->nip;
    }
}
