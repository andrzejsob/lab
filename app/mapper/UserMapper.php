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
        $this->authenticateStmt = self::$PDO->prepare(
            "SELECT * FROM user WHERE nick = ? AND passwordMd5 = ?"
        );
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO user(nick, firstName, lastName, email)
             VALUES (?, ?, ?, ?)");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE user SET nick = ?, firstName = ?, lastName = ?, email = ?
             WHERE id = ?");
    }

    public function getCollection(array $raw)
    {
        return new UserCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\User";
    }

    public function authenticate($nick, $password)
    {
        $this->authenticateStmt->execute(array($nick, md5($password)));
        $array = $this->authenticateStmt->fetch();
        if(!is_array($array)) {
            return null;
        }
        return $this->createObject($array);
    }

    protected function doCreateObject(array $user)
    {
        $obj = new User(
            $user['id'],
            $user['nick'],
            $user['passwordMd5'],
            $user['firstName'],
            $user['lastName'],
            $user['email']
        );
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $values = array(
            $object->getNick(),
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
            $object->getNick(),
            $object->getFirstName(),
            $object->getLastName(),
            $object->getEmail(),
            $object->getId()
        );
        $this->updateStmt->execute($values);
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
