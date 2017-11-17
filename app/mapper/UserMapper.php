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
            'SELECT * FROM user'
        );
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM user WHERE id = ?"
        );
        $this->selectByEmail = self::$PDO->prepare(
            "SELECT * FROM user WHERE email = ?"
        );
        $this->authenticateStmt = self::$PDO->prepare(
            "SELECT * FROM user WHERE username = ? AND passwordMd5 = ?"
        );
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO user(username, firstName, lastName, email)
             VALUES (?, ?, ?, ?)"
        );
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE user SET username = ?, firstName = ?, lastName = ?, email = ?
            WHERE id = ?"
        );
        $this->updatePasswordStmt = self::$PDO->prepare(
            "UPDATE user SET passwordMd5 = ? where id = ?"
        );
        $this->insertUserMethodStmt = self::$PDO->prepare(
            "INSERT INTO user_method(user_id, method_id) VALUES (?, ?)"
        );
        $this->insertUserRoleStmt = self::$PDO->prepare(
            "INSERT INTO user_role(user_id, role_id) VALUES (?, ?)"
        );
        $this->deleteUserMethodsStmt = self::$PDO->prepare(
            "DELETE FROM user_method WHERE user_id = ?"
        );
        $this->deleteUserRolesStmt = self::$PDO->prepare(
            "DELETE FROM user_role WHERE user_id = ?"
        );
        $this->deleteStmt = self::$PDO->prepare(
            "DELETE FROM user WHERE id = ?"
        );
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
            $user['username'],
            $user['passwordMd5'],
            $user['firstName'],
            $user['lastName'],
            $user['email']
        );
        return $obj;
    }

    public function findByEmail($email)
    {
        $this->selectByEmail->execute(array($email));
        $array = $this->selectByEmail->fetch(\PDO::FETCH_ASSOC);
        if (!is_array($array)) {
            return null;
        }
        $object = $this->createObject($array);
        return $object;
    }

    private function insertUserMethods($user)
    {
        $userId = $user->getId();
        $methods = $user->getMethods();
        foreach ($methods as $method) {
            $this->insertUserMethodStmt->execute(array(
                $userId,
                $method->getId()
            ));
        }
    }

    private function insertUserRoles($user)
    {
        $userId = $user->getId();
        $roles = $user->getRoles();
        foreach ($roles as $role) {
            $this->insertUserRoleStmt->execute(array(
                $userId,
                $role->getId()
            ));
        }
    }

    protected function doInsert(DomainObject $object)
    {
        $values = array(
            $object->getUsername(),
            $object->getFirstName(),
            $object->getLastName(),
            $object->getEmail()
        );
        try {
            self::$PDO->beginTransaction();
            $this->insertStmt->execute($values);
            $id = self::$PDO->lastInsertId();
            $object->setId($id);
            $this->insertUserMethods($object);
            $this->insertUserRoles($object);
            self::$PDO->commit();
        } catch (\Exception $e) {
            self::$PDO->rollBack();
            throw new \Exception($e->errorInfo[1]);
        }
    }

    public function updatePassword($user)
    {
        $this->updatePasswordStmt->execute(array(
            $user->getPasswordMD5(),
            $user->getId()
        ));
    }

    public function update(DomainObject $object)
    {
        $values = array(
            $object->getUsername(),
            $object->getFirstName(),
            $object->getLastName(),
            $object->getEmail(),
            $object->getId()
        );
        try {
            self::$PDO->beginTransaction();
            $this->updateStmt->execute($values);
            $this->deleteUserRolesStmt->execute(array($object->getId()));
            $this->deleteUserMethodsStmt->execute(array($object->getId()));
            $this->insertUserMethods($object);
            $this->insertUserRoles($object);
            self::$PDO->commit();
        } catch (\Exception $e) {
            self::$PDO->rollBack();
            throw new \Exception($e);
        }
    }

    public function delete($id)
    {
        $this->deleteStmt->execute(array($id));
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
