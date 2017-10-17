<?php
namespace lab\mapper;

use \lab\domain\DomainObject;
use \lab\domain\Client;
use \lab\mapper\ClientCollection;

class ClientMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM client");
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM client WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            'INSERT INTO client (name, street, zip_code, city, nip)
             VALUES (?, ?, ?, ?, ?)');
        $this->updateStmt = self::$PDO->prepare(
            'UPDATE client SET name = ?, street = ?, zip_code = ?,
            city = ?, nip =? WHERE id = ?');
    }

    public function getCollection(array $raw)
    {
        return new ClientCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\Client";
    }

    protected function doCreateObject(array $array)
    {
        $obj = new Client(
            $array['id'],
            $array['name'],
            $array['street'],
            $array['zip_code'],
            $array['city'],
            $array['nip']
        );
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $values = array(
            $object->getName(),
            $object->getStreet(),
            $object->getZipCode(),
            $object->getCity(),
            $object->getNip()
        );

        if (!$this->insertStmt->execute($values)) {
            throw new \Exception();
        }

        $id = self::$PDO->lastInsertId();
        $object->setId($id);
    }

    public function update(DomainObject $object)
    {
        $this->updateStmt->execute([
            $object->getName(),
            $object->getStreet(),
            $object->getZipCode(),
            $object->getCity(),
            $object->getNip(),
            $object->getId(),
        ]);
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
