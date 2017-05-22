<?php
namespace lab\mapper;

use \lab\domain\DomainObject;
use \lab\domain\User;

class UserMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            'SELECT * FROM user');
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM user WHERE id = ?");
        //$this->updateStmt = self::$PDO->prepare(
        //    "UPDATE me SET acronym = ?, name = ? WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO user(nick, password_md5, first_name, last_name, email)
             VALUES (?, ?, ?, ?, ?)");
    }

    public function getCollection(array $raw)
    {
        return new UserCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\User";
    }

    protected function doCreateObject(array $user)
    {
        $obj = new User(
            $user['id'],
            $user['nick'],
            $user['password_md5'],
            $user['first_name'],
            $user['last_name'],
            $user['email']
        );
        $method_mapper = new MethodMapper();
        $method_coll = $method_mapper->findByUser($user['id']);
        $obj->setMethods($method_coll);
        //$obj->setName($array['name']);
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $values = array(
            $object->getNick(),
            $object->getPasswordMd5(),
            $object->getFirstName(),
            $object->getLastName(),
            $object->getEmail()
        );
        $this->insertStmt->execute($values);
        $id = self::$PDO->lastInsertId();
        $object->setId($id);
    }

    public function update(DomainObject $object)
    {
        $values = array(
            $object->getAcronym(),
            $object->getName(),
            $object->getId()
        );
        $this->updateStmt->execute($values);
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
