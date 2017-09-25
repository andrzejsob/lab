<?php
namespace lab\domain\factory;

use \lab\domain\Order;
use \lab\base\ApplicationHelper;

class Order
{
    private $object;

    public function __construct($request)
    {
        $this->object = new Order();
        $this->setProperties($request);
        return $this->object;
    }

    private function setProperties($request)
    {
        $this->object->setId($request->getProperty('id'));
        $contactPerson = Order::getFinder('ContactPerson')
            ->find($request->getProperty('contactPersonId'));
        $this->object->setContactPerson($contactPerson);
        $this->object->setNr($request->getProperty('nr'));
        $this->object->setYesr($request->getProperty('year'));
        $this->object->setAKR($request->getProperty('akr'));
        $this->object->setOrderDate($request->getProperty('orderDate'));
        $this->object->setReceiveDate($request->getProperty('receiveDate'));
        $this->object->setNrOfAnalyzes($request->getProperty('nrOfAnalyzes'));
        $this->object->setSum($request->getProperty('sum'));
        $this->object->setFoundSource($request->getProperty('foundSource'));
        $this->object->setLoadNr($request->getProperty('loadNr'));
    }
}
