<?php
namespace lab\mapper;

use lab\domain\Method;
use lab\domain\DomainObject;

class MethodMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            'SELECT * FROM method');
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM method WHERE id = ?");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE method SET acronym = ?, name = ? WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO method(acronym, name) VALUES (?, ?)");
    }

    public function getCollection(array $raw)
    {
        return new MethodCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\Method";
    }

    protected function doCreateObject(array $method)
    {
        $obj = new Method($method['id'], $method['name']);
        //$obj->setName($array['name']);
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $values = array($object->getAcronym(), $object->getName());
        $this->insertStmt->execute($values);
        $id = self::$PDO->lastInsertId();
        $object->setId($id);
    }

    public function update(DomainObject $object)
    {
        $values = array($object->getAcronym(), $object->getName(), $object->getId());
        $this->updateStmt->execute($values);
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
