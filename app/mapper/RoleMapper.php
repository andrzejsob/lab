<?php
namespace lab\mapper;

use lab\domain\Role;
use lab\domain\DomainObject;

class RoleMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            'SELECT * FROM role');
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM role WHERE id = ?");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE role SET name = ? WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO role(name) VALUES (?)");
        $this->insertUserRoleStmt = self::$PDO->prepare(
            "INSERT INTO user_role(userId, roleId) VALUES (?, ?)");
        $this->findByUserStmt = self::$PDO->prepare(
            "SELECT id, name FROM role as r
            JOIN user_role as ur
            ON r.id = ur.roleId
            WHERE ur.userId = ?"
        );
        $this->deleteUserRolesStmt = self::$PDO->prepare(
            "DELETE FROM user_role WHERE userId = ?"
        );
        $this->deleteStmt = self::$PDO->prepare(
            "DELETE FROM role WHERE id = ?"
        );
    }

    public function findByUser($userId)
    {
        $this->findByUserStmt->execute(array($userId));
        return $this->getCollection(
            $this->findByUserStmt->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    public function updateUserRoles($userId, $rolesIdArray)
    {
        self::$PDO->beginTransaction();
        $this->deleteUserRolesStmt->execute(array($userId));
        if ($rolesIdArray) {
            foreach($rolesIdArray as $key => $roleId) {
                $stmt = $this->insertUserRoleStmt->execute(array(
                    $userId,
                    $roleId
                ));
            }
        }
        self::$PDO->commit();
    }

    public function getCollection(array $raw)
    {
        return new RoleCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\Role";
    }

    protected function doCreateObject(array $role)
    {
        $obj = new Role($role['id'], $role['name']);
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        try {
            $this->insertStmt->execute(array($object->getName()));
            $id = self::$PDO->lastInsertId();
            $object->setId($id);
        } catch (\Exception $e) {
            if ($e->errorInfo[1] == 1062) {
                throw new \Exception('Podana nazwa jest już zajęta!');
            }
        }
    }

    public function update(DomainObject $object)
    {
        $values = array(
            $object->getName(),
            $object->getId()
        );
        try {
            $result = $this->updateStmt->execute($values);
        } catch (\Exception $e) {
            if ($e->errorInfo[1] == 1062) {
                throw new \Exception('Podana nazwa jest już zajęta!');
            }
        }
    }

    public function delete($id) {
        $this->deleteStmt->execute(array($id));
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
