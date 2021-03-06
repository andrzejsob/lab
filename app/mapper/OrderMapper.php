<?php
namespace lab\mapper;

use lab\domain\DomainObject;
use lab\domain\Order;
use lab\domain\ContactPerson;
use lab\mapper\OrderCollection;
use lab\base\ApplicationHelper;

class OrderMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM internal_order");
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM internal_order WHERE id = ?");
        $this->selectNrStmt = self::$PDO->prepare(
            "SELECT MAX(nr) FROM internal_order");
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
                load_nr )
              SELECT ?, MAX(nr)+1, ?, ?, ?, ?, ?, ?, ?, ? FROM internal_order'
        );
        $this->deleteOrderMethodStmt = self::$PDO->prepare(
            'DELETE FROM internal_order_method WHERE internal_order_id = ?'
        );
        $this->insertOrderMethodStmt = self::$PDO->prepare(
            'INSERT INTO internal_order_method (internal_order_id, method_id)
            VALUES (?, ?)'
        );
        $this->selectByClientAndUserStmt = self::$PDO->prepare(
            'SELECT DISTINCT o.*
            FROM internal_order as o
            JOIN contact_person AS cp ON cp.id = o.contact_person_id
            JOIN internal_order_method AS om ON om.internal_order_id = o.id
            JOIN user_method AS um ON um.method_id = om.method_id
            WHERE cp.client_id = ? AND um.user_id = ? ORDER BY o.nr DESC
        ');
        $this->selectByContactAndUserStmt = self::$PDO->prepare(
            'SELECT DISTINCT o.*
            FROM internal_order as o
            JOIN internal_order_method AS om ON om.internal_order_id = o.id
            JOIN user_method AS um ON um.method_id = om.method_id
            WHERE o.contact_person_id = ? AND um.user_id = ? ORDER BY o.nr DESC
        ');
        $this->updateStmt = self::$PDO->prepare(
            'UPDATE internal_order SET
            contact_person_id = ?,
            akr = ?,
            order_date = ?,
            receive_date = ?,
            nr_of_analyzes = ?,
            sum = ?,
            found_source = ?,
            load_nr = ?
            WHERE id = ?'
        );
        $this->selectOrdersForUserStmt = self::$PDO->prepare(
            'SELECT DISTINCT o.*
            FROM internal_order as o
            JOIN internal_order_method AS om ON om.internal_order_id = o.id
            JOIN user_method AS um ON um.method_id = om.method_id
            WHERE um.user_id = ? ORDER BY o.nr DESC'
        );
    }

    public function findByClientAndUser($clientId, $userId)
    {
        $this->selectByClientAndUserStmt->execute(array($clientId, $userId));
        $array = $this->selectByClientAndUserStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection($array);
    }

    public function findByContactAndUser($contactId, $userId)
    {
        $this->selectByContactAndUserStmt->execute(array($contactId, $userId));
        $array = $this->selectByContactAndUserStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection($array);
    }

    public function findOrdersForUser($userId)
    {
        $this->selectOrdersForUserStmt->execute(array($userId));
        $rawArray = $this->selectOrdersForUserStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection($rawArray);
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
        $order = new Order(
            $array['id'],
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
        $contactPerson = ContactPerson::find($array['contact_person_id']);
        $order->setContactPerson($contactPerson);
        return $order;
    }

    protected function doInsert(DomainObject $order)
    {
        $contactPersonId = $order->getContactPerson()->getId();

        if (!$contactPersonId) {
            throw new Exception('Brak id osoby do kontaktu.');
        }

        $order->setYear(date('Y'));
        $values = array(
            $contactPersonId,
            $order->getYear(),
            $order->getAkr(),
            $order->getOrderDate(),
            $order->getReceiveDate(),
            $order->getNrOfAnalyzes(),
            $order->getSum(),
            $order->getFoundSource(),
            $order->getLoadNr()
        );
        try {
            self::$PDO->beginTransaction();
            $this->insertStmt->execute($values);
            $order->setId(self::$PDO->lastInsertId());
            $stmt = $this->selectNrStmt->execute(array());
            $nr = $this->selectNrStmt->fetch(\PDO::FETCH_NUM);
            $order->setNr($nr[0]);
            $this->insertOrderMethods($order);
            self::$PDO->commit();
        } catch (\Exception $e) {
            self::$PDO->rollBack();
            throw new \Exception($e);
        }
    }

    public function update(DomainObject $order)
    {
        $values = array(
            $order->getContactPerson()->getId(),
            $order->getAkr(),
            $order->getOrderDate(),
            $order->getReceiveDate(),
            $order->getNrOfAnalyzes(),
            $order->getSum(),
            $order->getFoundSOurce(),
            $order->getLoadNr(),
            $order->getId()
        );
        try {
            self::$PDO->beginTransaction();
            $this->updateStmt->execute($values);
            $this->deleteOrderMethodStmt->execute(array($order->getId()));
            $this->insertOrderMethods($order);
            self::$PDO->commit();
        } catch (\Exception $e) {
            self::$PDO->rollback();
            throw new \Exception($e);
        }
    }

    private function insertOrderMethods($order)
    {
        $orderId = $order->getId();
        $methods = $order->getMethods();
        foreach($methods as $method) {
            $this->insertOrderMethodStmt->execute(array(
                $orderId,
                $method->getId()
            ));
        }
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
}
