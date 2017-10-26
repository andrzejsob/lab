<?php
namespace lab\mapper;

use \lab\domain\DomainObject;
use \lab\domain\Client;
use \lab\mapper\ClientCollection;

class ContactPersonMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM contact_person");
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM contact_person WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            'INSERT INTO contact_person (
                client_id,
                first_name,
                last_name,
                email,
                phone
            ) VALUES (?, ?, ?, ?, ?, ?)');
        $this->findByClientStmt = self::$PDO->prepare(
            'SELECT * FROM contact_person WHERE client_id = ?');
        $this->findByUserStmt = self::$PDO->prepare(
            'SELECT cp.* FROM contact_person AS cp
            JOIN internal_order AS io ON cp.id = io.contact_person_id
            JOIN internal_order_method AS iom ON io.id = iom.internal_order_id
            JOIN user_method as um ON iom.method_id = um.method_id
            WHERE um.user_id = ?');
    }

    public function findByUser($userId)
    {
        $this->findByUserStmt->execute(array($userId));
        return $this->getCollection(
            $this->findByUserStmt->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    public function findByClient($id)
    {
        $this->findByClientStmt->execute(array($id));
        return $this->getCollection(
            $this->findByClientStmt->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    public function getCollection(array $raw)
    {
        return new ContactPersonCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\ContactPerson";
    }

    protected function doCreateObject(array $array)
    {
        $obj = new \lab\domain\ContactPerson(
            $array['id'],
            $array['client_id'],
            $array['first_name'],
            $array['last_name'],
            $array['email'],
            $array['phone']
        );
        $client = Client::find($array['client_id']);
        $obj->setClient($client);
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $client = $object->getClient();
        if (!$client->getId()) {
            throw new \Exception('Brak id klienta');
        }
        $values = array(
            $client->getId(),
            $object->getFirstName(),
            $object->getLastName(),
            $object->getEmail(),
            $object->getPhone()
        );
        $this->insertStmt->execute($values);
        $id = self::$PDO->lastInsertId();
        $object->setId($id);
    }

    public function update(DomainObject $object)
    {
        $values = array();
        $this->updateStmt->execute($values);
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
