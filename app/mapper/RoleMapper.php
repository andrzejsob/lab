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
            'SELECT * FROM role'
        );
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM role WHERE id = ?"
        );
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE role SET name = ? WHERE id = ?"
        );
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO role(name) VALUES (?)"
        );
        $this->insertUserRoleStmt = self::$PDO->prepare(
            "INSERT INTO user_role(user_id, role_id) VALUES (?, ?)"
        );
        $this->insertRolePermissionsStmt = self::$PDO->prepare(
            "INSERT INTO role_perm(role_id, perm_id) VALUES (?, ?)"
        );
        $this->findByUserStmt = self::$PDO->prepare(
            "SELECT id, name FROM role as r
            JOIN user_role as ur
            ON r.id = ur.role_id
            WHERE ur.user_id = ?"
        );
        $this->deleteRolePermissionsStmt = self::$PDO->prepare(
            "DELETE FROM role_perm WHERE role_id = ?"
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
            self::$PDO->beginTransaction();
            $this->insertStmt->execute(array($object->getName()));
            $id = self::$PDO->lastInsertId();
            $object->setId($id);
            $this->insertRolePermissions($object);
            self::$PDO->commit();
        } catch (\Exception $e) {
            self::$PDO->rollBack();
            if ($e->errorInfo[1] == 1062) {
                throw new \Exception(
                    'Nazwa "'.$object->getName().'" jest już zajęta!'
                );
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
            self::$PDO->beginTransaction();
            $this->updateStmt->execute($values);
            $this->deleteRolePermissionsStmt->execute(array($object->getId()));
            $this->insertRolePermissions($object);
            self::$PDO->commit();
        } catch (\Exception $e) {
            self::$PDO->rollBack();
            if ($e->errorInfo[1] == 1062) {
                throw new \Exception('Podana nazwa jest już zajęta!');
            }
        }
    }

    private function insertRolePermissions($role)
    {
        $roleId = $role->getId();
        $permissions = $role->getPermissions();
        foreach($permissions as $perm) {
            $this->insertRolePermissionsStmt->execute(array(
                $roleId,
                $perm->getId()
            ));
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
