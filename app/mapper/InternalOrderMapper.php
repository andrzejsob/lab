<?php
namespace lab\mapper;

use \lab\domain\DomainObject;
use \lab\domain\InternalOrder;
use \lab\mapper\InternalOrderCollection;

class InternalOrderMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM internal_order");
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM internal_order WHERE id = ?");
        $this->insertStmt = self::$PDO->prepare(
            'INSERT INTO internal_order (
                contact_person_id,
                nr,
                year,
                akr,
                order_date,
                receive_date,
                nr_of_analyzes,
                sum,
                found_source,
                load_nr ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $this->insertMethodStmt = self::$PDO->prepare(
            'INSERT INTO internal_order_method (internal_order_id, method_id)
            VALUES (?, ?)');
    }

    public function getCollection(array $raw)
    {
        return new InternalOrderCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\InternalOrder";
    }

    protected function doCreateObject(array $array)
    {
        $obj = new InternalOrder(
            $array['id'],
            $array['contact_person_id'],
            $array['nr'],
            $array['year'],
            $array['akr'],
            $array['order_date'],
            $array['receive_date'],
            $array['nr_of_analyzes'],
            $array['sum'],
            $array['found_source'],
            $array['load_nr']
        );
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $contactPerson = $object->getContactPerson();
        if (!$contactPerson->getId()) {
            throw new Exception('Brak id osoby do kontaktu.');
        }
        $values = array(
            $contactPerson->getId(),
            $object->getNr(),
            $object->getYear(),
            $object->getAkr(),
            $object->getOrderDate(),
            $object->getReceiveDate(),
            $object->getNrOfAnalyzes(),
            $object->getSum(),
            $object->getFoundSOurce(),
            $object->getLoadNr()
        );
        $this->insertStmt->execute($values);
        $id = self::$PDO->lastInsertId();
        $object->setId($id);

        foreach($object->getMethods() as $method) {
            $array = [$object->getId(), $method->getId()];
            $this->insertMethodStmt->execute($array);
        }
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

    public function selectByMethodsStmt($qm)
    {
        $selectStmt = self::$PDO->prepare("SELECT
            id,
            contact_person_id,
            nr,
            year,
            akr,
            order_date,
            receive_date,
            nr_of_analyzes,
            sum,
            found_source,
            load_nr
            FROM internal_order as io
            JOIN internal_order_method as iom
            ON io.id = iom.internal_order_id
            WHERE iom.method_id IN (".$qm.")");
        return $selectStmt;
    }

    public function selectByMethods(MethodCollection $methods)
    {
        foreach ($methods as $method) {
            $id_array[] = $method->getId();
            $marks[] = '?';
        }
        $qm = implode(', ', $marks);
        $sth = $this->selectByMethodsStmt($qm);
        $sth->execute($id_array);
        $array = $sth->fetchAll(\PDO::FETCH_ASSOC);
        if (is_null($array)) {return null;}
        return $this->getCollection($array);
    }
}
