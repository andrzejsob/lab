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
        $this->deleteOrderMethodStmt = self::$PDO->prepare(
            'DELETE FROM internal_order_method WHERE internal_order_id = ?'
        );
        $this->insertOrderMethodStmt = self::$PDO->prepare(
            'INSERT INTO internal_order_method (internal_order_id, method_id)
            VALUES (?, ?)'
        );
        $this->selectByClientIdStmt = self::$PDO->prepare(
            'SELECT o.*
            FROM internal_order as o
            JOIN contact_person AS cp ON cp.id = o.contactPersonId
            JOIN client AS c ON c.id = cp.client_id
            JOIN internal_order_method AS om ON om.internal_order_id = o.id
            JOIN method AS m ON m.id = om.method_id
            JOIN user_method AS um ON um.method_id = m.id
            JOIN user AS u ON u.id = um.user_id
            WHERE c.id = ?
        ');
        $this->updateStmt = self::$PDO->prepare(
            'UPDATE internal_order SET
            contact_person_id = ?,
            nr = ?,
            akr = ?,
            order_date = ?,
            receive_date = ?,
            nr_of_analyzes = ?,
            sum = ?,
            found_source = ?,
            load_nr = ?
            WHERE id = ?'
        );
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

        $this->selectPreviousNrStmt->execute(array());
        $nr = $this->selectPreviousNrStmt->fetch(\PDO::FETCH_NUM);
        print_r($nr);
        $object->setNr($nr[0] + 1);
        echo $object->getNr()."\n";exit;
        $values = array(
            $contactPerson->getId(),
            $object->getNr(),
            date('Y'),
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

    public function update(DomainObject $order)
    {
        $values = array(
            $order->getContactPerson()->getId(),
            $order->getNr(),
            $order->getAkr(),
            $order->getOrderDate(),
            $order->getReceiveDate(),
            $order->getNrOfAnalyzes(),
            $order->getSum(),
            $order->getFoundSOurce(),
            $order->getLoadNr(),
            $order->getId()
        );

        self::$PDO->beginTransaction();
            $this->updateStmt->execute($values);
            $this->deleteOrderMethodStmt->execute(array($order->getId()));

            foreach($order->getMethods() as $method) {
                $this->insertOrderMethodStmt->execute(array(
                    $order->getId(),
                    $method->getId()
                ));
            }

        self::$PDO->commit();
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
