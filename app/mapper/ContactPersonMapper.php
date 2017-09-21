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
                email2,
                phone
            ) VALUES (?, ?, ?, ?, ?, ?)');
        $this->findByClientStmt = self::$PDO->prepare(
            'SELECT * FROM contact_person WHERE client_id = ?');
    }

    public function findByClient($id)
    {
        $this->findByClientStmt->execute(array($id));
        return $this->getCollection($this->findByClientStmt->fetchAll(\PDO::FETCH_ASSOC));
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
            $array['email2'],
            $array['phone']
        );
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
            $object->getEmail2(),
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
