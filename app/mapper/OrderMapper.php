<?php
namespace lab\mapper;

use \lab\domain\DomainObject;
use \lab\domain\Order;
use \lab\mapper\OrderCollection;

class OrderMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM internal_order");
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM internal_order WHERE id = ?");
        $this->selectPreviousNrStmt = self::$PDO->prepare(
            "SELECT MAX(nr) FROM internal_order");
        $this->insertStmt = self::$PDO->prepare(
            'INSERT INTO internal_order as io (
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
        $this->insertOrderMethodStmt = self::$PDO->prepare(
            'INSERT INTO internal_order_method (internal_order_id, method_id)
            VALUES (?, ?)');
        $this->selectByClientIdStmt = self::$PDO->prepare(
            'SELECT o.id, o.contactPersonId, o.nr, o.year, o.akr, o.orderDate,
            o.receiveDate, o.nrOfAnalyzes, o.sum, o.foundSource, o.loadNr
            FROM internal_order as o
            JOIN contact_person AS cp ON cp.id = o.contactPersonId
            JOIN client AS c ON c.id = cp.client_id
            JOIN internal_order_method AS om ON om.internal_order_id = o.id
            JOIN method AS m ON m.id = om.method_id
            JOIN user_method AS um ON um.method_id = m.id
            JOIN user AS u ON u.id = um.user_id
            WHERE c.id = ?
        ');
    }

    public function getCollection(array $raw)
    {
        return new OrderCollection($raw, $this);
    }

    protected function targetClass()
    {
        return "lab\domain\InternalOrder";
    }

    protected function doCreateObject(array $array)
    {
        $obj = new Order(
            $array['id'],
            $array['contactPersonId'],
            $array['nr'],
            $array['year'],
            $array['akr'],
            $array['orderDate'],
            $array['receiveDate'],
            $array['nrOfAnalyzes'],
            $array['sum'],
            $array['foundSource'],
            $array['loadNr']
        );
        return $obj;
    }

    protected function doInsert(DomainObject $object)
    {
        $contactPerson = $object->getContactPerson();
        if (!$contactPerson->getId()) {
            throw new Exception('Brak id osoby do kontaktu.');
        }

        $this->selectPreviousNrStmt->execute(array());
        $nr = $this->selectPreviousNrStmt->fetch(\PDO::FETCH_NUM);
        print_r($nr);
        $object->setNr($nr[0] + 1);
        echo $object->getNr()."\n";exit;
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
            $this->insertOrderMethodStmt->execute($array);
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

    public function selectByClientId($id)
    {
        $this->selectByClientIdStmt->execute(array($id));
        $array = $this->selectByClientIdStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection($array);
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
