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
        $this->findByUserStmt = self::$PDO->prepare(
            "SELECT id, acronym, name FROM method as m
            JOIN user_method as um
            ON m.id = um.method_id
            WHERE um.user_id = ?"
        );
        $this->findByInternalOrderStmt = self::$PDO->prepare(
            "SELECT id, acronym, name FROM method as m
            JOIN internal_order_method as iom
            ON m.id = iom.method_id
            WHERE iom.internal_order_id = ?"
        );
    }

    public function findByUser($user_id)
    {
        $this->findByUserStmt->execute(array($user_id));
        return new MethodCollection(
            $this->findByUserStmt->fetchAll(\PDO::FETCH_ASSOC),
            $this
        );
    }

    public function findByInternalOrder($order_id)
    {
        $this->findByInternalOrderStmt->execute(array($order_id));
        return new MethodCollection(
            $this->findByInternalOrderStmt->fetchAll(\PDO::FETCH_ASSOC),
            $this
        );
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
        $obj = new Method($method['id'], $method['acronym'], $method['name']);
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
