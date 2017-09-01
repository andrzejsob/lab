<?php
namespace lab\mapper;

use lab\domain\Permission;
use lab\domain\DomainObject;

class PermissionMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            'SELECT * FROM permission');
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM permission WHERE id = ?");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE permission SET name = ? WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO permission(name) VALUES (?)");
        $this->insertRolePermissionStmt = self::$PDO->prepare(
            "INSERT INTO role_perm(roleId, permId) VALUES (?, ?)");
        $this->findByRoleStmt = self::$PDO->prepare(
            "SELECT id, name FROM permission as p
            JOIN role_perm as rp
            ON p.id = rp.permId
            WHERE rp.roleId = ?"
        );
        $this->deleteRolePermissionsStmt = self::$PDO->prepare(
            "DELETE FROM role_perm WHERE roleId = ?"
        );
    }

    public function findByRole($roleId)
    {
        $this->findByRoleStmt->execute(array($roleId));
        return $this->getCollection(
            $this->findByRoleStmt->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    public function updateRolePermissions($roleId, $permissionsIdArray)
    {
        self::$PDO->beginTransaction();
        $this->deleteRolePermissionsStmt->execute(array($roleId));
        if ($permissionsIdArray) {
            foreach($permissionsIdArray as $key => $permId) {
                $stmt = $this->insertRolePermissionStmt->execute(array(
                    $roleId,
                    $permId
                ));
            }
        }
        self::$PDO->commit();
    }

    public function getCollection(array $raw)
    {
        return new PermissionCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\Permission";
    }

    protected function doCreateObject(array $perm)
    {
        $obj = new Permission($perm['id'], $perm['name']);
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $this->insertStmt->execute(array($object->getName()));
        $id = self::$PDO->lastInsertId();
        $object->setId($id);
    }

    public function update(DomainObject $object)
    {
        $values = array($object->getName(), $object->getId());
        $this->updateStmt->execute($values);
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}